/**
 * Custom Search System
 * Handles search popup, recent searches, popular searches, and tab switching
 */

(function() {
    'use strict';

    // Constants
    const RECENT_SEARCHES_KEY = 'repindia_recent_searches';
    const MAX_RECENT_SEARCHES = 5;
    const SEARCH_POPUP_ID = 'search-popup';
    const SEARCH_TRIGGER_CLASS = 'search-popup-trigger';
    const SEARCH_CLOSE_CLASS = 'search-popup-close';
    const SEARCH_INPUT_CLASS = 'search-popup-input';
    const RECENT_SEARCHES_LIST_ID = 'recent-searches-list';
    const POPULAR_SEARCHES_LIST_ID = 'popular-searches-list';
    const SEARCH_TAB_CLASS = 'search-tab';
    const SEARCH_TAB_ACTIVE_CLASS = 'active';

    // DOM Elements
    let popup = null;
    let trigger = null;
    let closeBtn = null;
    let searchInput = null;
    let recentList = null;
    let popularList = null;
    let searchTabs = null;

    /**
     * Initialize search system
     */
    function init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setup);
        } else {
            setup();
        }
    }

    /**
     * Setup all search functionality
     */
    function setup() {
        // Get DOM elements
        popup = document.getElementById(SEARCH_POPUP_ID);
        trigger = document.querySelector('.' + SEARCH_TRIGGER_CLASS);
        closeBtn = popup ? popup.querySelector('.' + SEARCH_CLOSE_CLASS) : null;
        searchInput = popup ? popup.querySelector('.' + SEARCH_INPUT_CLASS) : null;
        recentList = document.getElementById(RECENT_SEARCHES_LIST_ID);
        popularList = document.getElementById(POPULAR_SEARCHES_LIST_ID);
        searchTabs = document.querySelectorAll('.' + SEARCH_TAB_CLASS);

        if (!popup || !trigger) {
            return; // Search popup not available
        }

        // Setup popup behavior
        setupPopup();
        
        // Setup recent searches
        setupRecentSearches();
        
        // Load popular searches
        loadPopularSearches();
        
        // Setup search tabs (if on search page)
        if (searchTabs.length > 0) {
            setupSearchTabs();
        }
    }

    /**
     * Setup popup open/close behavior
     */
    function setupPopup() {
        // Open popup
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            openPopup();
        });

        // Close popup
        if (closeBtn) {
            closeBtn.addEventListener('click', closePopup);
        }

        // Close on overlay click
        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                closePopup();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && popup.style.display !== 'none') {
                closePopup();
            }
        });

        // Focus input when popup opens
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    if (popup.style.display !== 'none') {
                        setTimeout(function() {
                            if (searchInput) {
                                searchInput.focus();
                            }
                        }, 100);
                    }
                }
            });
        });
        observer.observe(popup, { attributes: true, attributeFilter: ['style'] });

        // Handle form submission
        const form = popup.querySelector('.search-popup-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const query = searchInput ? searchInput.value.trim() : '';
                if (query) {
                    saveRecentSearch(query);
                    // Form will submit naturally to search results page
                } else {
                    e.preventDefault();
                }
            });
        }
    }

    /**
     * Open search popup
     */
    function openPopup() {
        popup.style.display = 'block';
        document.body.style.overflow = 'hidden';
        if (searchInput) {
            setTimeout(function() {
                searchInput.focus();
            }, 100);
        }
    }

    /**
     * Close search popup
     */
    function closePopup() {
        popup.style.display = 'none';
        document.body.style.overflow = '';
        if (searchInput) {
            searchInput.value = '';
        }
    }

    /**
     * Setup recent searches from localStorage
     */
    function setupRecentSearches() {
        if (!recentList) return;
        
        renderRecentSearches();
    }

    /**
     * Get recent searches from localStorage
     */
    function getRecentSearches() {
        try {
            const stored = localStorage.getItem(RECENT_SEARCHES_KEY);
            return stored ? JSON.parse(stored) : [];
        } catch (e) {
            return [];
        }
    }

    /**
     * Save search term to recent searches
     */
    function saveRecentSearch(term) {
        if (!term || term.trim() === '') return;
        
        term = term.trim();
        let recent = getRecentSearches();
        
        // Remove if already exists
        recent = recent.filter(function(item) {
            return item.toLowerCase() !== term.toLowerCase();
        });
        
        // Add to beginning
        recent.unshift(term);
        
        // Limit to max
        if (recent.length > MAX_RECENT_SEARCHES) {
            recent = recent.slice(0, MAX_RECENT_SEARCHES);
        }
        
        // Save to localStorage
        try {
            localStorage.setItem(RECENT_SEARCHES_KEY, JSON.stringify(recent));
            renderRecentSearches();
        } catch (e) {
            console.error('Failed to save recent search:', e);
        }
    }

    /**
     * Render recent searches list
     */
    function renderRecentSearches() {
        if (!recentList) return;
        
        const recent = getRecentSearches();
        
        if (recent.length === 0) {
            recentList.innerHTML = '<li class="search-popup-empty">No recent searches</li>';
            return;
        }
        
        recentList.innerHTML = recent.map(function(term) {
            const url = getSearchUrl(term);
            return '<li><a href="' + escapeHtml(url) + '" class="search-popup-term">' + escapeHtml(term) + '</a></li>';
        }).join('');
        
        // Add click handlers
        recentList.querySelectorAll('.search-popup-term').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const term = this.textContent.trim();
                saveRecentSearch(term);
            });
        });
    }

    /**
     * Load popular searches via AJAX
     */
    function loadPopularSearches() {
        if (!popularList) return;
        
        // Check if we have cached data
        const cached = sessionStorage.getItem('repindia_popular_searches');
        if (cached) {
            try {
                const data = JSON.parse(cached);
                renderPopularSearches(data);
                return;
            } catch (e) {
                // Invalid cache, continue to fetch
            }
        }
        
        // Fetch from server
        fetch(repindiaSearch.ajaxUrl + '?action=repindia_get_popular_searches&nonce=' + repindiaSearch.nonce)
            .then(function(response) {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(function(data) {
                if (data.success && data.data) {
                    // Cache for session
                    try {
                        sessionStorage.setItem('repindia_popular_searches', JSON.stringify(data.data));
                    } catch (e) {
                        // Ignore cache errors
                    }
                    renderPopularSearches(data.data);
                } else {
                    renderPopularSearches([]);
                }
            })
            .catch(function(error) {
                console.error('Failed to load popular searches:', error);
                renderPopularSearches([]);
            });
    }

    /**
     * Render popular searches list
     */
    function renderPopularSearches(searches) {
        if (!popularList) return;
        
        if (!searches || searches.length === 0) {
            popularList.innerHTML = '<li class="search-popup-empty">No popular searches</li>';
            return;
        }
        
        popularList.innerHTML = searches.map(function(item) {
            const term = item.term || item;
            const url = getSearchUrl(term);
            return '<li><a href="' + escapeHtml(url) + '" class="search-popup-term">' + escapeHtml(term) + '</a></li>';
        }).join('');
        
        // Add click handlers
        popularList.querySelectorAll('.search-popup-term').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const term = this.textContent.trim();
                saveRecentSearch(term);
            });
        });
    }

    /**
     * Get search URL for a term
     */
    function getSearchUrl(term) {
        const baseUrl = window.location.origin;
        const searchPath = '/?s=' + encodeURIComponent(term);
        return baseUrl + searchPath;
    }

    /**
     * Setup search tabs (on search results page)
     */
    function setupSearchTabs() {
        if (!searchTabs || searchTabs.length === 0) return;
        
        // Get current type from URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentType = urlParams.get('type') || 'all';
        
        // Set active tab
        searchTabs.forEach(function(tab) {
            const tabType = tab.getAttribute('data-type') || 'all';
            if (tabType === currentType) {
                tab.classList.add(SEARCH_TAB_ACTIVE_CLASS);
            } else {
                tab.classList.remove(SEARCH_TAB_ACTIVE_CLASS);
            }
            
            // Add click handler
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                switchTab(tabType);
            });
        });
    }

    /**
     * Switch search tab
     */
    function switchTab(type) {
        const url = new URL(window.location);
        
        if (type === 'all') {
            url.searchParams.delete('type');
        } else {
            url.searchParams.set('type', type);
        }
        
        // Remove page parameter when switching tabs
        url.searchParams.delete('paged');
        
        // Update URL and reload (graceful fallback if JS fails)
        if (window.history && window.history.pushState) {
            window.history.pushState({}, '', url);
            window.location.reload();
        } else {
            window.location.href = url.toString();
        }
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initialize on load
    init();

    // Save search term when arriving from search popup (if on search page)
    if (window.location.search.indexOf('s=') !== -1) {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('s');
        if (searchTerm) {
            saveRecentSearch(searchTerm);
        }
    }

})();
