<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		global $repindia_option,$post; 
		?>

    <?php the_content();  ?>
	<?php 
	}
	?>
<?php get_footer(); ?>
