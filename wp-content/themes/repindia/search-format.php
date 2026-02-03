<?php 
global $repindia_option;
$thumbsize = 'repindia-blog-large';
?>
<div class="search_result_box" id="post-<?php the_ID(); ?>">
    <div class="search_result_content">
		<div class="search-img-hov">
			<h3 class="result_title"><?php echo esc_html(the_title()); ?></h3>
		</div>
	    <?php echo the_excerpt(); ?>
        <div class="search_result_button">
            <a class="theme-btn bg-trans border_btnlight global_btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__('Read More','repindia'); ?></a>
        </div>
    </div>
</div>