<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		global $repindia_option,$post; 
		?>
        <style>
            .reading-progress {
                position: fixed;
                right: 24px;
                bottom: 120px;
                width: 72px;
                height: 72px;
                z-index: 999;
            }
            .reading-progress svg { width: 100%;height: 100%; }
            .reading-progress .bg { fill: none;stroke: #e6e6e6;stroke-width: 3; }
            .reading-progress .progress {
                fill: none;
                stroke: #007bff;
                stroke-width: 3;
                stroke-linecap: round;
                transition: stroke-dasharray 0.2s ease;
            }
            .reading-progress .percentage { font-size: 6px;fill: #333;font-weight: 600; }
            .auto_timer .elementor-shortcode {
                color: #5C5C5C;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .auto_timer .elementor-icon-wrapper { display: flex;align-items: center; }

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
<?php get_footer(); ?>
