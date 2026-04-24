<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		global $repindia_option,$post; 
		?>
        <style>
            .socialshare_section {
                display: none;
                flex-direction: column;
                gap: 20px;
                max-width: 56px;
                position: fixed;
                right: 80px;
                top: 128px;
                opacity: 0;
                z-index:2;
                transition: opacity 0.3s ease;
            }

            .socialshare_section.stick_social {
                display: flex;
                opacity: 1;
            }


            .reading-progress {
                position: relative;
                width: 56px;
                height: 56px;
                z-index: 999;
                min-width: 56px;
                background: #F2F5FA;
                border-radius: 100%;
            }
            .reading-progress svg { width: 100%;height: 100%; }
            .reading-progress .bg { fill: none;stroke: #D7DBE4;stroke-width: 3; }
            .reading-progress .progress {
                fill: none;
                stroke: #0099ED;
                stroke-width: 3;
                stroke-linecap: round;
                transition: stroke-dasharray 0.2s ease;
            }
            .reading-progress .percentage { font-size: 9px;fill: #333;font-weight: 600; }
            .auto_timer .elementor-shortcode {
                color: #5C5C5C;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .auto_timer .elementor-icon-wrapper { display: flex;align-items: center; }
            .news_detail_taxonomy h4 {
                display: flex;
                align-items: center;
                width: auto;
            }
            .news_detail_taxonomy h4 {
                border-radius: 100px;
                border: 1px solid #E6EBF2;
                background: #E5F6FF;
                display: inline-block;
                padding: 6px 16px;
            }
            .elementor-element.newsroom_detail_content {
                position: relative;
            }
            .js-dark .news_detail_taxonomy h4{
                border: 1px solid rgba(193, 196, 198, 0.1);
                background: #262a30;
                color: #d7dbe4;
            }
            .js-dark .e-con .elementor-widget.elementor-widget, .js-dark .auto_timer .elementor-shortcode,
            .js-dark p.elementor-icon-box-title span{
                color: #aeb6c9 !important;
            }
            .js-dark .elementor-element.newsroom_detail_content{ border-color: rgb(193 196 198 / 10%); }
            

        </style>
    <!-- <div class="custom-container">
            <?php
            // if ( function_exists('yoast_breadcrumb') ) {
            //     yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            // } 
            ?>
        </div> -->
    <div id="blog-detail-content"><?php the_content();  ?></div>
	<?php 
	}
	?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const triggerSection = document.querySelector(
                '.elementor-element.trigger_section' // ← section ABOVE
            );

            const parentSection = document.querySelector(
                '.elementor-element.newsroom_detail_content'
            );

            const social = document.querySelector('.socialshare_section');

            if (!triggerSection || !parentSection || !social) return;

            let triggerPassed = false;
            let insideParent = false;

            // Observer for trigger section
            const triggerObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        triggerPassed = !entry.isIntersecting;
                        toggleSocial();
                    });
                },
                {
                    root: null,
                    threshold: 0,
                }
            );

            // Observer for parent section
            const parentObserver = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        insideParent = entry.isIntersecting;
                        toggleSocial();
                    });
                },
                {
                    root: null,
                    threshold: 0,
                }
            );

            function toggleSocial() {
                if (triggerPassed && insideParent) {
                    social.classList.add('stick_social');
                } else {
                    social.classList.remove('stick_social');
                }
            }

            triggerObserver.observe(triggerSection);
            parentObserver.observe(parentSection);
        });
        </script>



<?php get_footer(); ?>
