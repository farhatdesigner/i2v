
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