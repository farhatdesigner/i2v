document.addEventListener("DOMContentLoaded", function () {

    function setupStickyBehavior(sectionClass, titleClass, imgClass, descClass) {

        const section = document.querySelector("." + sectionClass);
        if (!section) return; // Section not found → do nothing

        const title = section.querySelector("." + titleClass);
        const img = section.querySelector("." + imgClass);
        const desc = section.querySelector("." + descClass);

        if (!title || !img || !desc) return; // Required elements missing

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        // DESC IS VISIBLE → ADD sticky
                        title.classList.add("sticky");
                        img.classList.add("sticky");
                    } else {
                        // DESC IS HIDDEN (top or bottom) → REMOVE sticky
                        title.classList.remove("sticky");
                        img.classList.remove("sticky");
                    }
                });
            },
            {
                root: null,
                threshold: 0.1, // triggers when at least 10% of desc is visible
            }
        );

        observer.observe(desc);
    }

    /* ---- Setup for Channel Partner ---- */
    setupStickyBehavior(
        "channel_partner",
        "partner_choose_title",
        "partner_choose_img",
        "partner_choose_desc"
    );

    /* ---- Setup for Technology Partner ---- */
    setupStickyBehavior(
        "technology_partner",
        "partner_tech_title",
        "partner_tech_img",
        "partner_tech_desc"
    );

});
