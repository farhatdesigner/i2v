/**
 * Custom Store Locator - Leaflet.js Map with CPT Data
 * Client-side filtering using map_location AND map_project_type
 * Single query data from WordPress CPT via wp_localize_script
 */

(function() {
    'use strict';

    // Wait for DOM and Leaflet to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Check if global data exists (check inside DOMContentLoaded)
        if (typeof customStoreLocatorData === 'undefined' || !customStoreLocatorData.projects) {
            console.warn('Custom Store Locator: No projects data found. Check if map_projects CPT has data with latitude/longitude fields.');
            // Show error message on page
            const mapContainers = document.querySelectorAll('.custom-store-locator-wrapper');
            mapContainers.forEach(function(wrapper) {
                const mapContainer = wrapper.querySelector('.custom-map-container');
                if (mapContainer) {
                    mapContainer.innerHTML = '<div style="padding: 40px; text-align: center; color: #666;">No projects with valid coordinates found. Please ensure you have published posts in the map_projects CPT with latitude and longitude ACF fields set.</div>';
                }
            });
            return;
        }

        // Wait for Leaflet to load (with retry mechanism)
        function checkLeafletAndInit() {
            if (typeof L === 'undefined') {
                // Retry after a short delay if Leaflet hasn't loaded yet
                setTimeout(checkLeafletAndInit, 100);
                return;
            }

            // Find all map containers on the page
            const mapContainers = document.querySelectorAll('.custom-store-locator-wrapper');
            
            mapContainers.forEach(function(wrapper) {
                const settingsAttr = wrapper.getAttribute('data-widget-settings');
                if (!settingsAttr) return;

                let widgetSettings;
                try {
                    widgetSettings = JSON.parse(settingsAttr);
                } catch (e) {
                    console.error('Failed to parse widget settings:', e);
                    return;
                }

                // Initialize map for this widget instance
                initStoreLocatorMap(wrapper, widgetSettings);
            });
        }

        // Start checking for Leaflet
        checkLeafletAndInit();
    });

    /**
     * Initialize Leaflet map with CPT data
     */
    function initStoreLocatorMap(wrapper, settings) {
        const mapId = settings.mapId;
        const initialZoom = settings.initialZoom || 5;
        const showLocationFilter = settings.showLocationFilter !== false;
        const showProjectTypeFilter = settings.showProjectTypeFilter !== false;

        // Get map container element
        const mapElement = document.getElementById(mapId);
        if (!mapElement) {
            console.error('Map element not found:', mapId);
            return;
        }

        // Get all projects data from localized script
        if (typeof customStoreLocatorData === 'undefined') {
            console.error('Custom Store Locator: customStoreLocatorData is undefined. Check if wp_localize_script is working.');
            mapElement.innerHTML = '<div style="padding: 40px; text-align: center; color: #dc2626;"><strong>Error:</strong> Data not loaded. Check browser console and PHP error log.</div>';
            return;
        }
        
        const allProjects = customStoreLocatorData.projects || [];
        
        // Debug: Log projects data
        console.log('Custom Store Locator Debug:', {
            'customStoreLocatorData exists': typeof customStoreLocatorData !== 'undefined',
            'projects array exists': typeof customStoreLocatorData.projects !== 'undefined',
            'total projects': allProjects.length,
            'projects': allProjects,
            'first project sample': allProjects.length > 0 ? allProjects[0] : null
        });

        // Filter projects that have valid coordinates
        const validProjects = allProjects.filter(function(project) {
            return project.latitude && project.longitude &&
                   !isNaN(parseFloat(project.latitude)) &&
                   !isNaN(parseFloat(project.longitude));
        });

        if (validProjects.length === 0) {
            let errorMsg = '<div style="padding: 40px; text-align: center; color: #666; line-height: 1.6;">';
            errorMsg += '<strong>No projects with valid coordinates found.</strong><br><br>';
            if (allProjects.length === 0) {
                errorMsg += 'Please ensure:<br>';
                errorMsg += '1. The <code>map_projects</code> CPT exists<br>';
                errorMsg += '2. You have published posts in this CPT<br>';
                errorMsg += '3. Each post has <code>latitude</code> and <code>longitude</code> ACF fields set<br>';
            } else {
                errorMsg += 'Found ' + allProjects.length + ' project(s), but none have valid coordinates.<br>';
                errorMsg += 'Please set <code>latitude</code> and <code>longitude</code> ACF fields for your posts.';
            }
            errorMsg += '</div>';
            mapElement.innerHTML = errorMsg;
            console.warn('Custom Store Locator: No valid projects found. Total projects:', allProjects.length, 'Valid:', validProjects.length);
            return;
        }

        // Initialize Leaflet map
        const map = L.map(mapId, {
            zoomControl: true,
            scrollWheelZoom: true,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            dragging: true,
            touchZoom: true
        });

        // Calculate center point from all projects
        const avgLat = validProjects.reduce(function(sum, p) { return sum + p.latitude; }, 0) / validProjects.length;
        const avgLng = validProjects.reduce(function(sum, p) { return sum + p.longitude; }, 0) / validProjects.length;

        // Set initial view
        map.setView([avgLat, avgLng], initialZoom);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Store markers for filtering
        let allMarkers = [];
        let currentMarkers = [];
        let markersByProjectId = {}; // Track markers by project ID
        const filterContainer = wrapper.querySelector('.custom-map-filters'); // Cache filter container
        let selectedLocationSlug = 'all';
        let selectedProjectTypeSlug = 'all';
        let chipsPerPage = 5; // Show 5 chips initially
        let currentChipPage = 1;

        // Create custom marker icon
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div class="marker-pin"></div>',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
            popupAnchor: [0, -42]
        });

        /**
         * Create marker for a project
         */
        function createMarker(project) {
            // Check if marker already exists
            if (markersByProjectId[project.id]) {
                return markersByProjectId[project.id];
            }

            const marker = L.marker([project.latitude, project.longitude], {
                icon: customIcon
            });

            // Store project data in marker
            marker.projectData = project;

            // Add click event to open detail panel (NO Leaflet popup)
            marker.on('click', function() {
                openDetailPanel(project, wrapper);
            });

            // Store marker by project ID
            markersByProjectId[project.id] = marker;
            allMarkers.push(marker);

            return marker;
        }

        /**
         * Open custom detail panel (NOT Leaflet popup)
         */
        function openDetailPanel(project, wrapper) {
            const detailPanel = wrapper.querySelector('.custom-map-detail-panel');
            if (!detailPanel) return;

            // Populate panel content with metrics and description
            const titleEl = detailPanel.querySelector('.detail-title');
            const itmsEl = detailPanel.querySelector('.detail-itms');
            const monthsEl = detailPanel.querySelector('.detail-months');
            const camerasCountEl = detailPanel.querySelector('.detail-cameras-count');
            const quoteEl = detailPanel.querySelector('.detail-quote');

            if (titleEl) titleEl.textContent = project.title || 'N/A';
            
            // ITMS/ITS - Use project_type_name if available, otherwise show ITMS/ITS
            if (itmsEl) {
                itmsEl.textContent = project.project_type_name || 'ITMS/ITS';
            }
            
            // Months - Format project_date or use default
            if (monthsEl) {
                if (project.project_date) {
                    // Try to parse date and calculate months, or display as is
                    const dateStr = project.project_date;
                    // If it's a number (months), display with "Months"
                    if (!isNaN(dateStr) && parseFloat(dateStr) > 0) {
                        monthsEl.textContent = dateStr + ' Months';
                    } else {
                        // Otherwise display as is (assuming it's already formatted)
                        monthsEl.textContent = dateStr;
                    }
                } else {
                    monthsEl.textContent = '2 Months'; // Default fallback
                }
            }
            
            // Number of cameras with formatting
            if (camerasCountEl) {
                const cameras = project.number_of_cameras || '0';
                // Format number with comma separators
                camerasCountEl.textContent = parseInt(cameras).toLocaleString('en-US');
            }
            
            // Description/Quote
            if (quoteEl) {
                const desc = project.project_description || '';
                // Format as quote if it contains quotes, otherwise add quotes
                if (desc && desc.indexOf('"') === -1) {
                    quoteEl.textContent = '"' + desc + '"';
                } else {
                    quoteEl.textContent = desc;
                }
            }

            // Show panel with animation
            detailPanel.classList.add('active');

            // Highlight selected marker
            if (markersByProjectId[project.id]) {
                // Remove previous highlights
                allMarkers.forEach(function(marker) {
                    if (marker._icon) {
                        marker._icon.classList.remove('marker-active');
                    }
                });
                // Add highlight to current marker
                if (markersByProjectId[project.id]._icon) {
                    markersByProjectId[project.id]._icon.classList.add('marker-active');
                }
            }

            // Pan map to marker
            const marker = markersByProjectId[project.id];
            if (marker) {
                map.setView([project.latitude, project.longitude], Math.max(map.getZoom(), 12), {
                    animate: true,
                    duration: 0.5
                });
            }
        }

        /**
         * Close detail panel
         */
        function closeDetailPanel(wrapper) {
            const detailPanel = wrapper.querySelector('.custom-map-detail-panel');
            if (detailPanel) {
                detailPanel.classList.remove('active');
            }
        }

        /**
         * Filter markers based on selected filters (AND logic)
         * 
         * FILTERING RULES:
         * - Location filter: uses ONLY map_location taxonomy slug (location_slug)
         * - Project type filter: uses ONLY map_project_type taxonomy slug (project_type_slug)
         * - Both filters use AND condition (both must match)
         * - No other fields (title, description, date, etc.) are used for filtering
         */
        function filterMarkers() {
            if (!filterContainer || (!showLocationFilter && !showProjectTypeFilter)) {
                // No filters, show all markers
                showAllMarkers();
                return;
            }

            // Use stored selected values (set by chip clicks or dropdown)
            // These values are taxonomy slugs from map_location and map_project_type ONLY

            // Remove current markers from map
            currentMarkers.forEach(function(marker) {
                if (map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            });
            currentMarkers = [];

            // Filter projects based ONLY on taxonomies: map_location AND map_project_type
            // Filtering uses ONLY taxonomy slugs - no other fields are considered
            const filtered = validProjects.filter(function(project) {
                // Location filter: only based on map_location taxonomy slug
                const locationMatch = selectedLocationSlug === 'all' || 
                                     (project.location_slug && project.location_slug === selectedLocationSlug);
                
                // Project type filter: only based on map_project_type taxonomy slug
                const typeMatch = selectedProjectTypeSlug === 'all' || 
                                 (project.project_type_slug && project.project_type_slug === selectedProjectTypeSlug);
                
                // AND condition: both taxonomies must match
                return locationMatch && typeMatch;
            });

            // Add filtered markers to map
            filtered.forEach(function(project) {
                const marker = createMarker(project);
                marker.addTo(map);
                currentMarkers.push(marker);
            });

            // Adjust map bounds to show all visible markers
            if (currentMarkers.length > 0) {
                const group = new L.featureGroup(currentMarkers);
                map.fitBounds(group.getBounds().pad(0.1), {
                    maxZoom: (selectedLocationSlug !== 'all' || selectedProjectTypeSlug !== 'all') ? 12 : initialZoom
                });
            } else {
                // Reset to default view if no markers match
                map.setView([avgLat, avgLng], initialZoom);
            }

            // Close detail panel when filtering
            closeDetailPanel(wrapper);
        }

        /**
         * Show all markers (when filters are hidden)
         */
        function showAllMarkers() {
            selectedLocationSlug = 'all';
            selectedProjectTypeSlug = 'all';
            
            // Remove current markers
            currentMarkers.forEach(function(marker) {
                if (map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            });
            currentMarkers = [];

            // Add all markers
            validProjects.forEach(function(project) {
                const marker = createMarker(project);
                marker.addTo(map);
                currentMarkers.push(marker);
            });

            // Fit bounds to all markers
            if (currentMarkers.length > 0) {
                const group = new L.featureGroup(currentMarkers);
                map.fitBounds(group.getBounds().pad(0.1), {
                    maxZoom: initialZoom
                });
            }
        }


        /**
         * Get unique values for filters from valid projects
         * Used ONLY for taxonomy slugs (map_location_slug or map_project_type_slug)
         */
        function getUniqueValues(projects, key) {
            // Filter by taxonomy slug keys only (location_slug or project_type_slug)
            const values = projects
                .map(function(p) { return p[key]; })
                .filter(function(val) { return val && val !== ''; }); // Only include non-empty taxonomy slugs
            return [...new Set(values)].sort(); // Return unique, sorted taxonomy slugs
        }

        /**
         * Create location filter chips
         * ONLY uses map_location taxonomy data
         */
        function createLocationChips() {
            if (!showLocationFilter) return;

            const chipsContainer = wrapper.querySelector('#location-chips-' + mapId);
            if (!chipsContainer) return;

            // Get unique locations from map_location taxonomy ONLY
            const locationMap = {};
            validProjects.forEach(function(p) {
                // Only use projects that have map_location taxonomy assigned
                if (p.location_slug && p.location_name) {
                    if (!locationMap[p.location_slug]) {
                        locationMap[p.location_slug] = {
                            slug: p.location_slug, // taxonomy slug
                            name: p.location_name, // taxonomy name
                            count: 0
                        };
                    }
                    locationMap[p.location_slug].count++;
                }
            });

            const locations = Object.values(locationMap).sort(function(a, b) {
                return a.name.localeCompare(b.name);
            });

            // Clear existing chips
            chipsContainer.innerHTML = '';

            // Calculate pagination
            const totalChips = locations.length;
            const startIndex = (currentChipPage - 1) * chipsPerPage;
            const endIndex = Math.min(startIndex + chipsPerPage, totalChips);
            const chipsToShow = locations.slice(startIndex, endIndex);
            const remainingChips = totalChips - endIndex;

            // Create chips
            chipsToShow.forEach(function(location) {
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'location-chip';
                chip.setAttribute('data-location-slug', location.slug);
                chip.textContent = location.name;
                
                // Add click event
                chip.addEventListener('click', function() {
                    const wasActive = chip.classList.contains('active');
                    
                    // Remove active class from all chips
                    chipsContainer.querySelectorAll('.location-chip').forEach(function(c) {
                        c.classList.remove('active');
                    });
                    
                    if (wasActive) {
                        // Deselect if already active (show all)
                        selectedLocationSlug = 'all';
                    } else {
                        // Select clicked chip
                        chip.classList.add('active');
                        selectedLocationSlug = location.slug;
                    }
                    
                    // Filter markers
                    filterMarkers();
                });

                chipsContainer.appendChild(chip);
            });

            // Add "+X" chip if there are more locations
            if (remainingChips > 0) {
                const moreChip = document.createElement('button');
                moreChip.type = 'button';
                moreChip.className = 'location-chip location-chip-more';
                moreChip.textContent = '+' + remainingChips;
                
                moreChip.addEventListener('click', function() {
                    currentChipPage++;
                    createLocationChips();
                });

                chipsContainer.appendChild(moreChip);
            }
        }

        /**
         * Initialize filters (chips for location, dropdown for project type)
         */
        function initFilters() {
            if (!filterContainer || (!showLocationFilter && !showProjectTypeFilter)) {
                // No filters, show all markers immediately
                showAllMarkers();
                return;
            }

            // Initialize location chips
            if (showLocationFilter) {
                createLocationChips();
            }

            // Initialize project type dropdown
            // ONLY uses map_project_type taxonomy data
            if (showProjectTypeFilter) {
                // Get unique project types from map_project_type taxonomy ONLY
                const projectTypes = getUniqueValues(validProjects, 'project_type_slug');
                const projectTypeNames = {};
                
                // Debug: Check project type data
                console.log('Custom Store Locator: Project types from valid projects', {
                    validProjectsCount: validProjects.length,
                    projectTypes: projectTypes,
                    sampleProject: validProjects.length > 0 ? validProjects[0] : null
                });
                
                validProjects.forEach(function(p) {
                    // Only use projects that have map_project_type taxonomy assigned
                    if (p.project_type_slug && p.project_type_name) {
                        projectTypeNames[p.project_type_slug] = p.project_type_name; // taxonomy name
                    }
                });

                console.log('Custom Store Locator: Project type names map', projectTypeNames);

                const typeSelect = filterContainer.querySelector('#type-filter-' + mapId);
                if (typeSelect) {
                    // Remove existing options except first
                    while (typeSelect.options.length > 1) {
                        typeSelect.remove(1);
                    }

                    // Add project type options
                    if (projectTypes.length > 0) {
                        projectTypes.forEach(function(slug) {
                            const option = document.createElement('option');
                            option.value = slug;
                            option.textContent = projectTypeNames[slug] || slug;
                            typeSelect.appendChild(option);
                        });
                    } else {
                        console.warn('Custom Store Locator: No project types found. Ensure projects have map_project_type taxonomy assigned.');
                    }

                    // Add event listener (only if not already added)
                    typeSelect.removeEventListener('change', function() {});
                    typeSelect.addEventListener('change', function() {
                        selectedProjectTypeSlug = typeSelect.value || 'all';
                        filterMarkers();
                    });
                } else {
                    console.error('Custom Store Locator: Project type select element not found:', '#type-filter-' + mapId);
                }
            }

            // Initial load - show all markers
            filterMarkers();
        }

        /**
         * Initialize detail panel close button and show list button
         */
        function initDetailPanel() {
            const closeBtn = wrapper.querySelector('.detail-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    closeDetailPanel(wrapper);
                    // Remove active marker highlight
                    allMarkers.forEach(function(marker) {
                        if (marker._icon) {
                            marker._icon.classList.remove('marker-active');
                        }
                    });
                });
            }

            // Initialize "Show list" button
            const showListBtn = wrapper.querySelector('.show-list-button');
            if (showListBtn) {
                showListBtn.addEventListener('click', function() {
                    // Toggle list view (you can implement list view functionality here)
                    // For now, scroll to filters
                    if (filterContainer) {
                        filterContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        }

        // Initialize filters (will call filterMarkers or showAllMarkers)
        initFilters();

        // Initialize detail panel
        initDetailPanel();
    }

})();
