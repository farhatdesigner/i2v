<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		global $repindia_option,$post; 
		?>
    <div class="custom-container">
            <?php
            // if ( function_exists('yoast_breadcrumb') ) {
            //     yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            // } 
            ?>
        </div>
    <?php the_content();  ?>
    
    <?php 
    // Include brochure popup component
    get_template_part('template-parts/brochure-popup');
    ?>
	<?php 
	}
	?>
<?php get_footer(); ?>
