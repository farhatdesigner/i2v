<?php 
/**
 * The template for displaying 404 pages (not found).
 *
 * @package repindia
 */
repindia_get_header(); 
global $repindia_option;	?>
    <div class="error-area page-404">
        <div class="container">
            <div class="error-content">
                    <h1 class="error-title"><?php echo esc_html( "404", 'repindia' ); ?></h1>
                    <h2><?php echo esc_html( "Page Not Found", 'repindia' ); ?></h2>
					<div class="error_bitton">
						<a href="<?php echo esc_url(get_home_url('/')); ?>" class="button_404"><?php echo esc_html('Back To Home', 'repindia');?></a>
                    </div>		
            </div>
        </div>
    </div>
	<?php	
	get_footer(); 
	?>