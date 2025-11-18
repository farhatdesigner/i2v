<?php 
/**
 * The template for displaying search results pages.
 *
 * @package repindia
 */
global $post,$paged,$wp;
repindia_get_header();
?>
<div class="search_result_header" style="background-image: url('<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2024/03/home_banner.webp');" >
	<div class="container">
		<div class="inner_page_banner_content">
			<h1><?php echo esc_html__( 'Search Result', 'repindia' ) ?></h1>
		</div>
	</div>
</div>
<div class="global_search search_layout">
	<div class="container">
		<?php
		$search_format = array('post_type' =>  'any', 's' => $s, 'paged' => $paged); 
		query_posts($search_format);
		$posts_class = '';
		$paginate_links_data = paginate_links( array('type' => 'array') );
		if(empty( $paginate_links_data )) 
		{
			$posts_class .= ' no-paginate';
		} ?>
		<div id="result_primary" <?php post_class();?>>
			<?php
			if ( have_posts() ){ 
				while ( have_posts() ) : the_post(); 
					if ( get_post_format( $post->ID )):
						get_template_part( 'content', get_post_format() );
					else:
						get_template_part('search', 'format');
					endif;	
					wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'repindia' ),
					'after'  => '</div>',
					) );
				endwhile;
				?>
				<div class="paginationWrapper">
					<div class="nubmerPagination">
						<?php
							echo paginate_links( array(
								'type'      => 'a',
								'prev_text' => '<i class="fa fa-angle-left"></i>',
								'next_text' => '<i class="fa fa-angle-right"></i>',
							) );
						?>
					</div>
				</div>	
			<?php
			}elseif ( is_search() ) { ?>
			    <div class="error_search_msg">
					<h4><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'repindia' ); ?></h4>
					<?php 
					get_search_form(); ?>
				</div>
				<?php
			}else{ ?>
			    <div class="error_search_msg">
					<h4><?php echo esc_html__( 'It seems we can not find what you&rsquo;re looking for. Perhaps searching can help.', 'repindia' ); ?></h4> 
					<?php	
					get_search_form(); ?>
				</div>
				<?php
			} ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>