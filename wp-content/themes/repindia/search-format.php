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
            <a class="global_btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__('Read More','repindia'); ?><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M12 12V0H0L12 12Z" fill="#EE7F2B"/></svg></a>
        </div>
    </div>
</div>