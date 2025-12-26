document.addEventListener("DOMContentLoaded", function () {

    function setupStickyBehavior(sectionClass, titleClass, imgClass, descClass) {

        const section = document.querySelector("." + sectionClass);
        if (!section) return;

        const title = section.querySelector("." + titleClass);
        const img = section.querySelector("." + imgClass);
        const desc = section.querySelector("." + descClass);

        if (!title || !img || !desc) return;

        let isSticky = false;
        let titleWrapper = null;
        let imgWrapper = null;

        // Wrap elements to maintain layout when they become fixed
        function wrapElements() {
            if (!titleWrapper && title && title.parentNode) {
                titleWrapper = document.createElement('div');
                titleWrapper.className = 'sticky-wrapper-title';
                titleWrapper.style.cssText = `
                    position: relative;
                    width: 100%;
                    min-height: 0;
                `;
                title.parentNode.insertBefore(titleWrapper, title);
                titleWrapper.appendChild(title);
            }
            
            if (!imgWrapper && img && img.parentNode) {
                imgWrapper = document.createElement('div');
                imgWrapper.className = 'sticky-wrapper-img';
                imgWrapper.style.cssText = `
                    position: relative;
                    width: 100%;
                    min-height: 0;
                `;
                img.parentNode.insertBefore(imgWrapper, img);
                imgWrapper.appendChild(img);
            }
        }

        function updateStickyState(shouldBeSticky) {
            if (shouldBeSticky === isSticky) return;
            
            isSticky = shouldBeSticky;
            
            wrapElements();
            
            if (isSticky) {
                // Set wrapper heights before applying sticky
                if (titleWrapper && title) {
                    titleWrapper.style.minHeight = title.offsetHeight + 'px';
                }
                if (imgWrapper && img) {
                    imgWrapper.style.minHeight = img.offsetHeight + 'px';
                }
                
                title.classList.add("sticky");
                img.classList.add("sticky");
                
            } else {
                // When removing sticky, set wrapper height temporarily to prevent jump
                // Then reset it after a short delay to free up space
                if (titleWrapper && title) {
                    titleWrapper.style.minHeight = title.offsetHeight + 'px';
                }
                if (imgWrapper && img) {
                    imgWrapper.style.minHeight = img.offsetHeight + 'px';
                }
                
                title.classList.remove("sticky");
                img.classList.remove("sticky");
                
                // Reset wrapper heights after element returns to normal flow
                // This prevents the wrapper from taking up unnecessary space
                setTimeout(() => {
                    if (!isSticky && titleWrapper) {
                        titleWrapper.style.minHeight = '0';
                    }
                    if (!isSticky && imgWrapper) {
                        imgWrapper.style.minHeight = '0';
                    }
                }, 100); // Small delay to allow smooth transition
            }
        }

        function checkSticky() {
            if (!desc) return;
            
            const rect = desc.getBoundingClientRect();
            const descHeight = rect.height;

            if (!descHeight || descHeight <= 0) return;

            const visibleHeight = Math.min(window.innerHeight, rect.bottom) - Math.max(0, rect.top);
            const visibilityPercent = (visibleHeight / descHeight) * 100;

            const bottomBuffer = 220;
            const conditionTopReached = rect.top <= 200;
            const conditionVisibleEnough = visibilityPercent >= 50;
            const conditionNotPastBottom = rect.bottom > bottomBuffer;

            const shouldBeSticky = conditionTopReached && conditionVisibleEnough && conditionNotPastBottom;
            
            updateStickyState(shouldBeSticky);
        }

        let ticking = false;
        
        function throttledCheck() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    checkSticky();
                    ticking = false;
                });
                ticking = true;
            }
        }

        window.addEventListener("scroll", throttledCheck, { passive: true });
        window.addEventListener("resize", checkSticky, { passive: true });
        
        checkSticky();
    }

    setupStickyBehavior("channel_partner", "partner_choose_title", "partner_choose_img", "partner_choose_desc");
    setupStickyBehavior("technology_partner", "partner_tech_title", "partner_tech_img", "partner_tech_desc");
});
