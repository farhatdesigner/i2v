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

});
