<div class="search_result_form">
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off">
		<p><?php echo esc_html__( 'Search here: ', 'repindia' ); ?></p>  <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search_main" placeholder="<?php echo esc_html__( 'Search','repindia'); ?>"   required />
		<button type="submit" class="search_blog search_blog1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
<path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="white"/>
</svg></button>
	</form>
</div>