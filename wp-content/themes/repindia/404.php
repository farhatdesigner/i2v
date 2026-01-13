<?php 
/**
 * Template Name: 404 Page
 *
 * @package repindia
 */
repindia_get_header(); 
global $repindia_option;	?>
<?php get_header(); ?>

<?php
$page = get_page_by_path('error-404'); // your page slug

if ($page) {
    echo \Elementor\Plugin::instance()
        ->frontend
        ->get_builder_content_for_display($page->ID);
} else {
    echo '<h1>404 - Page Not Found</h1>';
}
?>

<?php get_footer(); ?>



