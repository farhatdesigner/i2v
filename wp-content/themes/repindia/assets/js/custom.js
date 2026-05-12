// document.addEventListener("DOMContentLoaded", function () {

//     function setupStickyBehavior(sectionClass, titleClass, imgClass, descClass) {

//         const section = document.querySelector("." + sectionClass);
//         if (!section) return;

//         const title = section.querySelector("." + titleClass);
//         const img = section.querySelector("." + imgClass);
//         const desc = section.querySelector("." + descClass);

//         if (!title || !img || !desc) return;

//         let isSticky = false;
//         let titleWrapper = null;
//         let imgWrapper = null;

//         // Wrap elements to maintain layout when they become fixed
//         function wrapElements() {
//             if (!titleWrapper && title && title.parentNode) {
//                 titleWrapper = document.createElement('div');
//                 titleWrapper.className = 'sticky-wrapper-title';
//                 titleWrapper.style.cssText = `
//                     position: relative;
//                     width: 100%;
//                     min-height: 0;
//                 `;
//                 title.parentNode.insertBefore(titleWrapper, title);
//                 titleWrapper.appendChild(title);
//             }
            
//             if (!imgWrapper && img && img.parentNode) {
//                 imgWrapper = document.createElement('div');
//                 imgWrapper.className = 'sticky-wrapper-img';
//                 imgWrapper.style.cssText = `
//                     position: relative;
//                     width: 100%;
//                     min-height: 0;
//                 `;
//                 img.parentNode.insertBefore(imgWrapper, img);
//                 imgWrapper.appendChild(img);
//             }
//         }

//         function updateStickyState(shouldBeSticky) {
//             if (shouldBeSticky === isSticky) return;
            
//             isSticky = shouldBeSticky;
            
//             wrapElements();
            
//             if (isSticky) {
//                 // Set wrapper heights before applying sticky
//                 if (titleWrapper && title) {
//                     titleWrapper.style.minHeight = title.offsetHeight + 'px';
//                 }
//                 if (imgWrapper && img) {
//                     imgWrapper.style.minHeight = img.offsetHeight + 'px';
//                 }
                
//                 title.classList.add("sticky");
//                 img.classList.add("sticky");
                
//             } else {
//                 // When removing sticky, set wrapper height temporarily to prevent jump
//                 // Then reset it after a short delay to free up space
//                 if (titleWrapper && title) {
//                     titleWrapper.style.minHeight = title.offsetHeight + 'px';
//                 }
//                 if (imgWrapper && img) {
//                     imgWrapper.style.minHeight = img.offsetHeight + 'px';
//                 }
                
//                 title.classList.remove("sticky");
//                 img.classList.remove("sticky");
                
//                 // Reset wrapper heights after element returns to normal flow
//                 // This prevents the wrapper from taking up unnecessary space
//                 setTimeout(() => {
//                     if (!isSticky && titleWrapper) {
//                         titleWrapper.style.minHeight = '0';
//                     }
//                     if (!isSticky && imgWrapper) {
//                         imgWrapper.style.minHeight = '0';
//                     }
//                 }, 100); // Small delay to allow smooth transition
//             }
//         }

//         function checkSticky() {
//             if (!desc) return;
            
//             const rect = desc.getBoundingClientRect();
//             const descHeight = rect.height;

//             if (!descHeight || descHeight <= 0) return;

//             const visibleHeight = Math.min(window.innerHeight, rect.bottom) - Math.max(0, rect.top);
//             const visibilityPercent = (visibleHeight / descHeight) * 100;

//             const bottomBuffer = 220;
//             const conditionTopReached = rect.top <= 200;
//             const conditionVisibleEnough = visibilityPercent >= 50;
//             const conditionNotPastBottom = rect.bottom > bottomBuffer;

//             const shouldBeSticky = conditionTopReached && conditionVisibleEnough && conditionNotPastBottom;
            
//             updateStickyState(shouldBeSticky);
//         }

//         let ticking = false;
        
//         function throttledCheck() {
//             if (!ticking) {
//                 requestAnimationFrame(() => {
//                     checkSticky();
//                     ticking = false;
//                 });
//                 ticking = true;
//             }
//         }

//         window.addEventListener("scroll", throttledCheck, { passive: true });
//         window.addEventListener("resize", checkSticky, { passive: true });
        
//         checkSticky();
//     }

//     setupStickyBehavior("channel_partner", "partner_choose_title", "partner_choose_img", "partner_choose_desc");
//     setupStickyBehavior("technology_partner", "partner_tech_title", "partner_tech_img", "partner_tech_desc");
// });

/**
 * Global YouTube Video Popup
 * Single reusable popup for anchors with class .youtube-popup containing YouTube URLs.
 * Uses event delegation - one listener on document. Video stops when popup closes.
 */
(function() {
    'use strict';

    var popupInitialized = false;

    function getYoutubeVideoId(url) {
        if (!url || typeof url !== 'string') return null;
        var id = null;
        if (url.indexOf('youtube.com/watch') !== -1) {
            var match = url.match(/[?&]v=([^&]+)/);
            id = match ? match[1] : null;
        } else if (url.indexOf('youtu.be/') !== -1) {
            var shortMatch = url.match(/youtu\.be\/([^?&#]+)/);
            id = shortMatch ? shortMatch[1] : null;
        } else if (url.indexOf('youtube.com/embed/') !== -1) {
            var embedMatch = url.match(/youtube\.com\/embed\/([^?&#]+)/);
            id = embedMatch ? embedMatch[1] : null;
        }
        return id ? id : null;
    }

    function initGlobalYoutubePopup() {
        if (popupInitialized) return;
        var popup = document.getElementById('global-youtube-popup');
        var iframe = document.getElementById('global-youtube-popup-iframe');
        if (!popup || !iframe) return;

        popupInitialized = true;

        function closePopup() {
            iframe.src = '';
            popup.classList.remove('active');
            popup.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function openPopup(videoId, link) {
            var titleEl = popup.querySelector('.global-youtube-popup__title');
            if (titleEl && link) {
                var title = link.getAttribute('data-title') || link.getAttribute('title') || link.textContent.trim();
                titleEl.textContent = title || 'Video';
            }
            iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            popup.classList.add('active');
            popup.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        popup.querySelector('.global-youtube-popup__close').addEventListener('click', closePopup);
        popup.querySelector('.global-youtube-popup__backdrop').addEventListener('click', closePopup);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && popup.classList.contains('active')) {
                closePopup();
            }
        });

        document.addEventListener('click', function(e) {
            var link = e.target.closest('a.youtube-popup');
            if (!link) return;
            e.preventDefault();
            var href = link.getAttribute('href') || '';
            var videoId = getYoutubeVideoId(href);
            if (videoId) {
                openPopup(videoId, link);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGlobalYoutubePopup);
    } else {
        initGlobalYoutubePopup();
    }
})();

// Blog Listing Tab
(function() {
    'use strict';
    
    // Only run if newsroom tab functionality is present on the page
    document.addEventListener('DOMContentLoaded', function () {
        var repindiaNewsroomTabWrapper = document.querySelector('.newsroomtab');
        if (!repindiaNewsroomTabWrapper) return;

        var repindiaNewsroomTabs = repindiaNewsroomTabWrapper.querySelectorAll('.elementor-icon-list-item');
        if (!repindiaNewsroomTabs || repindiaNewsroomTabs.length === 0) return;

        var repindiaNewsroomSections = {
            newsroom: document.querySelector('.defaultallnews'),
            news: document.querySelector('.newstab_section'),
            stories: document.querySelector('.storytab_section'),
            blogs: document.querySelector('.blog_filtertab_section'),
        };

        // Check if at least one section exists
        var hasSections = false;
        for (var key in repindiaNewsroomSections) {
            if (repindiaNewsroomSections[key]) {
                hasSections = true;
                break;
            }
        }
        if (!hasSections) return;

        function repindiaNewsroomHideAll() {
            for (var sectionKey in repindiaNewsroomSections) {
                if (repindiaNewsroomSections[sectionKey]) {
                    repindiaNewsroomSections[sectionKey].classList.remove('active-section');
                }
            }
            for (var i = 0; i < repindiaNewsroomTabs.length; i++) {
                repindiaNewsroomTabs[i].classList.remove('active');
            }
        }

        function repindiaNewsroomActivate(tabKey, tabIndex) {
            repindiaNewsroomHideAll();
            if (repindiaNewsroomSections[tabKey]) {
                repindiaNewsroomSections[tabKey].classList.add('active-section');
            }
            if (repindiaNewsroomTabs[tabIndex]) {
                repindiaNewsroomTabs[tabIndex].classList.add('active');
            }
        }

        // Default state - only if newsroom section exists
        if (repindiaNewsroomSections.newsroom) {
            repindiaNewsroomActivate('newsroom', 0);
        }

        // Tab click handling
        for (var i = 0; i < repindiaNewsroomTabs.length; i++) {
            (function(index) {
                repindiaNewsroomTabs[index].addEventListener('click', function (e) {
                    e.preventDefault();

                    if (index === 0 && repindiaNewsroomSections.newsroom) {
                        repindiaNewsroomActivate('newsroom', 0);
                    } else if (index === 1 && repindiaNewsroomSections.news) {
                        repindiaNewsroomActivate('news', 1);
                    } else if (index === 2 && repindiaNewsroomSections.stories) {
                        repindiaNewsroomActivate('stories', 2);
                    } else if (index === 3 && repindiaNewsroomSections.blogs) {
                        repindiaNewsroomActivate('blogs', 3);
                    }
                });
            })(i);
        }

        // CTA Redirect support - only if sections exist
        var repindiaNewsroomParams = new URLSearchParams(window.location.search);
        var repindiaNewsroomTabParam = repindiaNewsroomParams.get('tab');

        if (repindiaNewsroomTabParam === 'news' && repindiaNewsroomSections.news) {
            repindiaNewsroomActivate('news', 1);
        } else if (repindiaNewsroomTabParam === 'stories' && repindiaNewsroomSections.stories) {
            repindiaNewsroomActivate('stories', 2);
        } else if (repindiaNewsroomTabParam === 'blogs' && repindiaNewsroomSections.blogs) {
            repindiaNewsroomActivate('blogs', 3);
        }
    });
})();