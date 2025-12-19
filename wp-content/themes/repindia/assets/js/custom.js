document.addEventListener("DOMContentLoaded", function () {

    function setupStickyBehavior(sectionClass, titleClass, imgClass, descClass) {

        const section = document.querySelector("." + sectionClass);
        if (!section) return;

        const title = section.querySelector("." + titleClass);
        const img = section.querySelector("." + imgClass);
        const desc = section.querySelector("." + descClass);

        if (!title || !img || !desc) return;

        function checkSticky() {
            const rect = desc.getBoundingClientRect();
            const descHeight = rect.height;

            // How much is visible inside viewport?
            const visibleHeight = Math.min(window.innerHeight, rect.bottom) - Math.max(0, rect.top);
            const visibilityPercent = (visibleHeight / descHeight) * 100;

            // ---- Smooth release before bottom to avoid jumping ----
            const bottomBuffer = 220; // release slightly earlier so fixed elements don't snap

            const conditionTopReached = rect.top <= 200;
            const conditionVisibleEnough = visibilityPercent >= 50;
            const conditionNotPastBottom = rect.bottom > bottomBuffer;

            // Apply sticky only when ALL 3 conditions are satisfied
            if (conditionTopReached && conditionVisibleEnough && conditionNotPastBottom) {
                title.classList.add("sticky");
                img.classList.add("sticky");
            } else {
                title.classList.remove("sticky");
                img.classList.remove("sticky");
            }
        }

        // Trigger on scroll + resize + initial load
        window.addEventListener("scroll", checkSticky, { passive: true });
        window.addEventListener("resize", checkSticky);
        checkSticky();
    }

    /* ---- Channel Partner ---- */
    setupStickyBehavior(
        "channel_partner",
        "partner_choose_title",
        "partner_choose_img",
        "partner_choose_desc"
    );

    /* ---- Technology Partner ---- */
    setupStickyBehavior(
        "technology_partner",
        "partner_tech_title",
        "partner_tech_img",
        "partner_tech_desc"
    );

    /* ---- Career Form File Upload ---- */
    const fileUploadBoxes = document.querySelectorAll('.styled-career-form .file-upload-box');
    
    fileUploadBoxes.forEach(function(uploadBox) {
        const fileInput = uploadBox.querySelector('input[type="file"]');
        if (!fileInput) return;
        
        // Make the entire box clickable
        uploadBox.addEventListener('click', function(e) {
            // Don't trigger if clicking on the browse link (it has its own handler)
            if (e.target.classList.contains('browse-link')) {
                return;
            }
            fileInput.click();
        });
        
        // Handle browse link click
        const browseLink = uploadBox.querySelector('.browse-link');
        if (browseLink) {
            browseLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
        }
        
        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                uploadBox.classList.add('has-file');
                const fileNameElement = uploadBox.querySelector('.file-name');
                if (fileNameElement) {
                    fileNameElement.textContent = fileName;
                }
            } else {
                uploadBox.classList.remove('has-file');
            }
        });
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Handle drag and drop
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadBox.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadBox.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            uploadBox.style.borderColor = '#4A90E2';
            uploadBox.style.backgroundColor = '#F2F5FA';
        }
        
        function unhighlight(e) {
            uploadBox.style.borderColor = '#C9CED3';
            uploadBox.style.backgroundColor = '';
        }
        
        uploadBox.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fileInput.files = files;
                const changeEvent = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(changeEvent);
            }
        }
    });

});
