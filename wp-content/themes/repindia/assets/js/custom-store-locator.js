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
            scrollWheelZoom: false,
            doubleClickZoom: true,
            boxZoom: true,
            keyboard: true,
            dragging: true,
            touchZoom: true
        });

        // Calculate center point from all projects
        const avgLat = validProjects.reduce(function(sum, p) { return sum + p.latitude; }, 0) / validProjects.length;
        const avgLng = validProjects.reduce(function(sum, p) { return sum + p.longitude; }, 0) / validProjects.length;

        // Add OpenStreetMap tiles first
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Set a temporary initial view (will be properly set with initialZoom in filterMarkers() on initial load)
        // This ensures the map has a view while waiting for filterMarkers() to be called
        map.setView([avgLat, avgLng], initialZoom);

        // Store markers for filtering
        let allMarkers = [];
        let currentMarkers = [];
        let markersByProjectId = {}; // Track markers by project ID
        const filterContainer = wrapper.querySelector('.custom-map-filters'); // Cache filter container
        let selectedLocationSlug = 'all';
        let selectedProjectTypeSlug = 'all';
        let hoverTimeout = null; // Global hover timeout for card display
        let isInitialLoad = true; // Track if this is the initial load to respect initialZoom
        let locationChipsExpanded = false; // Track if location chips are expanded to show all

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

            // Detect touch device
            const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

            if (isTouchDevice) {
                // For touch devices (mobile/tablet), use click event instead of hover
                marker.on('click', function() {
                    const detailCard = wrapper.querySelector('.custom-map-detail-card');
                    const isActive = detailCard && detailCard.classList.contains('active');
                    
                    if (isActive && detailCard.dataset.currentProjectId === project.id.toString()) {
                        // If same card is open, close it
                        closeDetailCard(wrapper);
                    } else {
                        // Clear any pending hide timeout
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                            hoverTimeout = null;
                        }
                        
                        // Show detail card on click
                        openDetailCard(project, wrapper, marker);
                        // Store project ID in card for tracking
                        if (detailCard) {
                            detailCard.dataset.currentProjectId = project.id.toString();
                        }
                    }
                });
            } else {
                // For desktop, use hover events
                marker.on('mouseover', function() {
                    // Clear any pending hide timeout
                    if (hoverTimeout) {
                        clearTimeout(hoverTimeout);
                        hoverTimeout = null;
                    }
                    
                    // Show detail card on hover next to marker
                    openDetailCard(project, wrapper, marker);
                });

                marker.on('mouseout', function() {
                    // Delay hiding to allow moving to card
                    hoverTimeout = setTimeout(function() {
                        closeDetailCard(wrapper);
                    }, 150);
                });
            }

            // Store marker by project ID
            markersByProjectId[project.id] = marker;
            allMarkers.push(marker);

            return marker;
        }

        /**
         * Open custom detail card on hover next to marker (popup-style positioning)
         */
        function openDetailCard(project, wrapper, markerElement) {
            // Clear any pending hide timeout
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
                hoverTimeout = null;
            }

            const detailCard = wrapper.querySelector('.custom-map-detail-card');
            if (!detailCard) return;

            // Position card next to marker (will be recalculated after content loads)
            // Initial positioning happens after content is populated

            // Populate card content with project details (matching screenshot 1 layout)
            const titleEl = detailCard.querySelector('.detail-title');
            const itmsEl = detailCard.querySelector('.detail-itms');
            const projectDateEl = detailCard.querySelector('.detail-project-date');
            const camerasCountEl = detailCard.querySelector('.detail-cameras-count');
            const quoteEl = detailCard.querySelector('.detail-quote');

            if (titleEl) titleEl.textContent = project.title || 'N/A';
            
            // ICCC/PSIM or Project Type - Use project_type_name if available
            if (itmsEl) {
                itmsEl.textContent = project.project_type_name || 'ICCC/PSIM';
            }
            
            // Project Date - Format to match screenshot 1 (DD/MM/YYYY format)
            if (projectDateEl) {
                if (project.project_date) {
                    const dateStr = String(project.project_date).trim();
                    
                    // If it's already in DD/MM/YYYY or MM/DD/YYYY format, use as is
                    if (dateStr.match(/^\d{1,2}[\/-]\d{1,2}[\/-]\d{2,4}$/)) {
                        projectDateEl.textContent = dateStr.replace(/-/g, '/');
                    } 
                    // If it's a timestamp or ISO date, format it
                    else if (dateStr.match(/^\d{4}-\d{2}-\d{2}/) || !isNaN(Date.parse(dateStr))) {
                        const dateObj = new Date(dateStr);
                        if (!isNaN(dateObj.getTime())) {
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            const year = dateObj.getFullYear();
                            projectDateEl.textContent = day + '/' + month + '/' + year;
                        } else {
                            projectDateEl.textContent = dateStr;
                        }
                    }
                    // If it's a number (months), display with "Months"
                    else if (!isNaN(dateStr) && parseFloat(dateStr) > 0) {
                        projectDateEl.textContent = dateStr + ' Months';
                    }
                    // Otherwise display as is
                    else {
                        projectDateEl.textContent = dateStr;
                    }
                } else {
                    projectDateEl.textContent = 'N/A';
                }
            }
            
            // Number of cameras with formatting
            if (camerasCountEl) {
                const cameras = project.number_of_cameras || '0';
                camerasCountEl.textContent = parseInt(cameras).toLocaleString('en-US');
            }
            
            // Description/Quote - Handle HTML content from ACF (preserve formatting like screenshot 1)
            if (quoteEl) {
                let desc = project.project_description || '';
                
                // If description exists, preserve HTML formatting
                if (desc) {
                    // Clean up but preserve HTML structure (p, br tags)
                    desc = desc.trim();
                    // Ensure proper formatting
                    if (desc.indexOf('<p>') === -1 && desc.indexOf('<br') === -1) {
                        // If no HTML, wrap in paragraph
                        desc = '<p>' + desc + '</p>';
                    }
                    quoteEl.innerHTML = desc;
                } else {
                    quoteEl.innerHTML = '<p>No description available.</p>';
                }
            }

            // Show card with animation
            detailCard.classList.add('active');

            // Highlight hovered marker
            if (markersByProjectId[project.id]) {
                // Remove previous highlights
                allMarkers.forEach(function(m) {
                    if (m._icon) {
                        m._icon.classList.remove('marker-active');
                    }
                });
                // Add highlight to current marker
                if (markersByProjectId[project.id]._icon) {
                    markersByProjectId[project.id]._icon.classList.add('marker-active');
                }
            }

            // Position card next to marker after content is populated
            // Use requestAnimationFrame for smooth positioning
            requestAnimationFrame(function() {
                if (markerElement && markerElement._icon && detailCard.classList.contains('active')) {
                    positionCardNearMarker(detailCard, markerElement, wrapper);
                }
            });
            
            // Recalculate position after a short delay to ensure content is rendered
            setTimeout(function() {
                if (markerElement && markerElement._icon && detailCard.classList.contains('active')) {
                    positionCardNearMarker(detailCard, markerElement, wrapper);
                }
            }, 100);

        }

        /**
         * Position detail card next to marker (mobile: centered, desktop: next to marker)
         */
        function positionCardNearMarker(detailCard, markerElement, wrapper) {
            if (!detailCard) return;

            const mapContainer = wrapper.querySelector('.custom-map-container');
            if (!mapContainer) return;
            
            // Detect if mobile/tablet (screen width <= 768px)
            const isMobile = window.innerWidth <= 768;
            
            if (isMobile) {
                // On mobile/tablet, center the card horizontally and vertically
                // CSS will handle centering via transform: translate(-50%, -50%)
                detailCard.style.position = 'absolute';
                detailCard.style.left = '50%';
                detailCard.style.top = '50%';
                detailCard.style.right = 'auto';
                detailCard.style.bottom = 'auto';
                detailCard.style.margin = '0';
                return;
            }
            
            // Desktop: Position card next to marker with edge detection
            if (!markerElement || !markerElement._icon) return;

            const markerIcon = markerElement._icon;
            const markerRect = markerIcon.getBoundingClientRect();
            const mapRect = mapContainer.getBoundingClientRect();
            
            // Calculate marker center relative to map container
            const markerCenterX = markerRect.left + (markerRect.width / 2) - mapRect.left;
            const markerCenterY = markerRect.top + (markerRect.height / 2) - mapRect.top;
            
            // Get actual card dimensions
            const cardWidth = detailCard.offsetWidth || 380;
            const cardHeight = detailCard.offsetHeight || 300;
            const offsetX = 30; // Distance from marker center horizontally
            const offsetY = -60; // Offset above marker center (negative = above)
            
            // Calculate preferred position (to the right and above marker by default)
            let cardLeft = markerCenterX + offsetX;
            let cardTop = markerCenterY + offsetY;
            
            // Edge detection and adjustment
            const margin = 15; // Minimum margin from edges
            
            // Check right edge
            if (cardLeft + cardWidth + margin > mapRect.width) {
                // Show on left side of marker instead
                cardLeft = markerCenterX - cardWidth - offsetX;
            }
            
            // Check left edge
            if (cardLeft < margin) {
                cardLeft = margin;
            }
            
            // Check top edge
            if (cardTop < margin) {
                // If too close to top, position below marker
                cardTop = markerCenterY + Math.abs(offsetY) + 10;
            }
            
            // Check bottom edge
            if (cardTop + cardHeight + margin > mapRect.height) {
                // Position above with margin
                cardTop = mapRect.height - cardHeight - margin;
                
                // If still doesn't fit, position at top
                if (cardTop < margin) {
                    cardTop = margin;
                }
            }
            
            // Apply calculated position (keep scale transform for animation)
            detailCard.style.position = 'absolute';
            detailCard.style.left = Math.round(cardLeft) + 'px';
            detailCard.style.top = Math.round(cardTop) + 'px';
            detailCard.style.right = 'auto';
            detailCard.style.bottom = 'auto';
            detailCard.style.transform = '';
            // Don't override transform - let CSS handle scale animation
            detailCard.style.margin = '0';
        }

        /**
         * Close detail card
         */
        function closeDetailCard(wrapper) {
            // Clear any pending timeout
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
                hoverTimeout = null;
            }

            const detailCard = wrapper.querySelector('.custom-map-detail-card');
            if (detailCard) {
                detailCard.classList.remove('active');
                
                // On mobile, reset to center; on desktop, reset all position styles
                const isMobile = window.innerWidth <= 768;
                if (isMobile) {
                    // On mobile, keep centering transform but reset scale
                    detailCard.style.left = '50%';
                    detailCard.style.top = '50%';
                    detailCard.style.transform = 'translate(-50%, -50%) scale(0.95)';
                } else {
                    // On desktop, reset all position styles
                    detailCard.style.left = '';
                    detailCard.style.top = '';
                    detailCard.style.right = '';
                    detailCard.style.bottom = '';
                    detailCard.style.transform = '';
                }
                detailCard.style.margin = '';
                // Clear project ID tracking
                if (detailCard.dataset) {
                    detailCard.dataset.currentProjectId = '';
                }
            }
            
            // Remove marker highlights
            allMarkers.forEach(function(marker) {
                if (marker._icon) {
                    marker._icon.classList.remove('marker-active');
                }
            });
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
                const hasActiveFilters = (selectedLocationSlug !== 'all' || selectedProjectTypeSlug !== 'all');
                
                // On initial load with no filters, use initialZoom (respect Elementor control setting)
                // Don't use fitBounds which would override the user's initial zoom preference
                if (isInitialLoad && !hasActiveFilters) {
                    // Use the exact initial zoom setting on first load (respects Elementor control)
                    map.setView([avgLat, avgLng], initialZoom);
                    isInitialLoad = false; // Mark that initial load is complete
                } else {
                    // After initial load or when filters are active, use fitBounds
                    const group = new L.featureGroup(currentMarkers);
                    const fitBoundsOptions = {};
                    if (hasActiveFilters) {
                        // When filters are active, allow zooming in up to level 12
                        fitBoundsOptions.maxZoom = 12;
                    } else {
                        // After initial load, ensure we don't zoom out beyond the initial zoom level
                        fitBoundsOptions.maxZoom = initialZoom;
                    }
                    map.fitBounds(group.getBounds().pad(0.1), fitBoundsOptions);
                    if (isInitialLoad) {
                        isInitialLoad = false; // Mark that initial load is complete
                    }
                }
                // Hide no results fallback
                showNoResultsFallback(wrapper, false);
            } else {
                // Reset to default view if no markers match
                map.setView([avgLat, avgLng], initialZoom);
                if (isInitialLoad) {
                    isInitialLoad = false; // Mark that initial load is complete
                }
                // Show no results fallback
                showNoResultsFallback(wrapper, true);
            }

            // Close detail card when filtering
            closeDetailCard(wrapper);
        }

        /**
         * Show/hide no results fallback message
         */
        function showNoResultsFallback(wrapper, show) {
            const fallback = wrapper.querySelector('.map-no-results-fallback');
            if (fallback) {
                if (show) {
                    fallback.style.display = 'flex';
                } else {
                    fallback.style.display = 'none';
                }
            }

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

            // Fit bounds to all markers (but respect initialZoom on first load)
            if (currentMarkers.length > 0) {
                // On initial load, use initialZoom instead of fitBounds to respect user setting
                if (isInitialLoad) {
                    // Use the exact initial zoom setting on first load (respects Elementor control)
                    map.setView([avgLat, avgLng], initialZoom);
                    isInitialLoad = false; // Mark that initial load is complete
                } else {
                    // After initial load, use fitBounds but don't zoom out beyond initialZoom
                    const group = new L.featureGroup(currentMarkers);
                    map.fitBounds(group.getBounds().pad(0.1), {
                        maxZoom: initialZoom // Ensure we don't zoom out beyond initial zoom
                    });
                }
                // Hide no results fallback
                showNoResultsFallback(wrapper, false);
            } else {
                // Show no results fallback if no valid projects
                if (isInitialLoad) {
                    isInitialLoad = false; // Mark that initial load is complete
                }
                showNoResultsFallback(wrapper, true);
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
            
            // Remove existing scroll container if not expanded (when collapsing)
            if (!locationChipsExpanded) {
                const existingScrollContainer = wrapper.querySelector('.location-chips-scroll-container');
                if (existingScrollContainer) {
                    existingScrollContainer.remove();
                }
            }

            const maxInitialChips = 5;
            const shouldShowMoreButton = locations.length > maxInitialChips && !locationChipsExpanded;
            const chipsToShow = locations.slice(0, maxInitialChips);
            const remainingCount = locations.length - maxInitialChips;

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
                    
                    // Remove active class from all chips (including in scroll container)
                    wrapper.querySelectorAll('.location-chip').forEach(function(c) {
                        if (!c.classList.contains('location-chip-more') && !c.classList.contains('location-chip-toggle')) {
                            c.classList.remove('active');
                        }
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

            // Add "+X" button if there are more than 5 locations and not expanded
            if (shouldShowMoreButton && remainingCount > 0) {
                const moreChip = document.createElement('button');
                moreChip.type = 'button';
                moreChip.className = 'location-chip location-chip-more';
                moreChip.textContent = '+' + remainingCount;
                
                moreChip.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Expand to show all chips in scrollable container
                    expandLocationChips(locations, chipsContainer, mapId);
                });

                chipsContainer.appendChild(moreChip);
            }
            
            // Ensure container is visible
            chipsContainer.style.display = 'flex';
        }

        /**
         * Expand location chips to show all in a scrollable container
         */
        function expandLocationChips(allLocations, originalContainer, mapId) {
            // Check if scroll container already exists
            let scrollContainer = wrapper.querySelector('.location-chips-scroll-container');
            
            if (!scrollContainer) {
                // Store reference to original container's parent for restoration later
                const filterContainer = originalContainer.parentNode;
                
                // Create scrollable container that will REPLACE the original container's position
                scrollContainer = document.createElement('div');
                scrollContainer.className = 'location-chips-scroll-container';
                scrollContainer.setAttribute('data-original-container-id', originalContainer.id);
                
                // Create chips row wrapper for horizontal layout (this is the scrollable content)
                const chipsRow = document.createElement('div');
                chipsRow.className = 'location-chips-scroll-content';
                
                // Create all location chips
                allLocations.forEach(function(location) {
                    const chip = document.createElement('button');
                    chip.type = 'button';
                    chip.className = 'location-chip';
                    chip.setAttribute('data-location-slug', location.slug);
                    chip.textContent = location.name;
                    
                    // Check if this chip is currently active
                    if (selectedLocationSlug === location.slug) {
                        chip.classList.add('active');
                    }
                    
                    // Add click event
                    chip.addEventListener('click', function() {
                        const wasActive = chip.classList.contains('active');
                        
                        // Remove active class from all chips
                        wrapper.querySelectorAll('.location-chip').forEach(function(c) {
                            if (!c.classList.contains('location-chip-toggle')) {
                                c.classList.remove('active');
                            }
                        });
                        
                        if (wasActive) {
                            selectedLocationSlug = 'all';
                        } else {
                            chip.classList.add('active');
                            selectedLocationSlug = location.slug;
                        }
                        
                        // Filter markers
                        filterMarkers();
                    });

                    chipsRow.appendChild(chip);
                });
                
                // Add "Show Less" button INSIDE the scrollable chips row (at the end, will scroll with chips)
                const toggleButton = document.createElement('button');
                toggleButton.type = 'button';
                toggleButton.className = 'location-chip location-chip-toggle';
                toggleButton.textContent = 'Show Less';
                toggleButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    collapseLocationChips(originalContainer);
                });
                
                // Add Show Less button to the chips row so it scrolls with them
                chipsRow.appendChild(toggleButton);
                
                // Append the chips row (with all chips + Show Less button) to scroll container
                scrollContainer.appendChild(chipsRow);
                
                // REPLACE the original container with scroll container (maintains flex layout position)
                // This ensures dropdown alignment is preserved
                if (filterContainer && originalContainer.parentNode === filterContainer) {
                    filterContainer.replaceChild(scrollContainer, originalContainer);
                }
            }
            
            // Show the scroll container
            if (scrollContainer) {
                scrollContainer.classList.add('active');
                scrollContainer.style.display = 'block';
            }
            locationChipsExpanded = true;
        }

        /**
         * Collapse location chips back to initial view (max 5)
         */
        function collapseLocationChips(originalContainer) {
            const scrollContainer = wrapper.querySelector('.location-chips-scroll-container');
            const filterContainer = wrapper.querySelector('.custom-map-filters');
            
            locationChipsExpanded = false;
            
            // Check if original container still exists (it should be replaced, but check anyway)
            let chipsContainer = wrapper.querySelector('#location-chips-' + mapId);
            
            if (!chipsContainer && scrollContainer && filterContainer) {
                // Original container was replaced by scroll container, recreate it
                chipsContainer = document.createElement('div');
                chipsContainer.className = 'location-filter-chips';
                chipsContainer.id = 'location-chips-' + mapId;
                
                // Replace scroll container with the recreated original container
                filterContainer.replaceChild(chipsContainer, scrollContainer);
            } else if (scrollContainer && scrollContainer.parentNode) {
                // If both exist, just remove scroll container
                scrollContainer.classList.remove('active');
                scrollContainer.style.display = 'none';
                scrollContainer.parentNode.removeChild(scrollContainer);
            }
            
            // Ensure original container exists and is visible
            if (!chipsContainer) {
                chipsContainer = wrapper.querySelector('#location-chips-' + mapId);
            }
            
            if (chipsContainer) {
                chipsContainer.style.display = 'flex';
            }
            
            // Recreate chips to show max 5 again with "+X" button
            // createLocationChips() will populate the container we just restored/ensured exists
            createLocationChips();
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
         * Initialize detail card close button and hover behavior
         */
        function initDetailCard() {
            const detailCard = wrapper.querySelector('.custom-map-detail-card');
            if (!detailCard) return;

            // Close button
            const closeBtn = detailCard.querySelector('.detail-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    closeDetailCard(wrapper);
                });
            }

            // Keep card visible when hovering over it (prevents flickering)
            detailCard.addEventListener('mouseenter', function(e) {
                e.stopPropagation();
                if (hoverTimeout) {
                    clearTimeout(hoverTimeout);
                    hoverTimeout = null;
                }
            });

            detailCard.addEventListener('mouseleave', function(e) {
                e.stopPropagation();
                hoverTimeout = setTimeout(function() {
                    closeDetailCard(wrapper);
                }, 200);
            });

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

            // Initialize "Reset Filters" button (in no results fallback)
            const resetBtn = wrapper.querySelector('.no-results-reset');
            if (resetBtn) {
                // Remove any existing listeners by cloning
                const newResetBtn = resetBtn.cloneNode(true);
                resetBtn.parentNode.replaceChild(newResetBtn, resetBtn);
                
                newResetBtn.addEventListener('click', function() {
                    // Collapse expanded location chips if open
                    if (locationChipsExpanded) {
                        const originalContainer = wrapper.querySelector('#location-chips-' + mapId);
                        if (originalContainer) {
                            collapseLocationChips(originalContainer);
                        }
                    }
                    
                    // Reset location filter
                    selectedLocationSlug = 'all';
                    const locationChips = wrapper.querySelectorAll('.location-chip');
                    locationChips.forEach(function(chip) {
                        if (!chip.classList.contains('location-chip-more') && !chip.classList.contains('location-chip-toggle')) {
                            chip.classList.remove('active');
                        }
                    });

                    // Reset project type filter
                    selectedProjectTypeSlug = 'all';
                    const typeSelect = filterContainer ? filterContainer.querySelector('#type-filter-' + mapId) : null;
                    if (typeSelect) {
                        typeSelect.value = 'all';
                    }

                    // Filter to show all markers
                    filterMarkers();
                });
            }
        }

        // Initialize filters (will call filterMarkers or showAllMarkers)
        initFilters();

        // Initialize detail card
        initDetailCard();
    }

})();
