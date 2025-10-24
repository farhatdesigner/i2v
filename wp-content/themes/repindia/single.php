<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		$heighlightarg = array(
			'post_type'        =>  'post',
			'post_status'      =>  'publish',
			'order'            => 'DESC',
			'posts_per_page'   => '4',
		);
		$heighlightarg['tax_query'][] = [
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => $newscategories[0]->slug,
		];
		$related_blogs = new WP_Query( $heighlightarg );
		global $repindia_option,$post; ?>

        <?php if($newscategories[0]->slug == 'event'){ 
			$template_file = locate_template('category-event.php');
			if ($template_file) {
				include($template_file);
			} else {
				echo '<p>Template file for this category not found.</p>';
			}
		}else{ ?>
			<div class="blogdetailcontainer">
				<div class="blogleftbox">
					<?php 
					if( has_post_thumbnail( ) ) 
					{ 
						$singlepost_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
						?>
						<div class="blog_detail_banner" style="background: url(<?php echo $singlepost_img_url; ?>);">
							<?php //echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'blog_banner_img' ) ); ?>
							<div class="breadcrumb_box">
							<span><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Home', 'repindia' ); ?></a></span> &gt; <span><a href="<?php echo esc_url( home_url( '/' ) ); ?>news-media"><?php echo esc_html__( 'News & Media', 'repindia' ); ?></a></span> &gt; <span class="breadcrumb_last" aria-current="page"><?php the_title(); ?></span></span>
							</div>
						</div>
					<?php 
					} ?>
					<!-- <div class="sectionpadding"> -->
					<div class="container">
						<div class="blog_detail">
							<div class="blog_detail_title_section">
								<h1><?php the_title(); ?></h1>
								<div class="blog_social_links">
									<span class="blogdate"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5.01988 22H18.9799C20.4399 22 21.6299 20.81 21.6299 19.35V6.13C21.6299 4.67 20.4399 3.48 18.9799 3.48H17.9299V2.74C17.9299 2.33 17.5999 2 17.1899 2C16.7799 2 16.4499 2.33 16.4499 2.74V3.48H7.55988V2.74C7.55988 2.33 7.22988 2 6.81988 2C6.40988 2 6.07988 2.33 6.07988 2.74V3.48H5.02988C3.56988 3.48 2.37988 4.67 2.37988 6.13V19.34C2.37988 20.8 3.56988 21.99 5.02988 21.99L5.01988 22ZM3.84988 6.13C3.84988 5.49 4.37988 4.96 5.01988 4.96H6.06988V5.7C6.06988 6.11 6.39988 6.44 6.80988 6.44C7.21988 6.44 7.54988 6.11 7.54988 5.7V4.96H16.4399V5.7C16.4399 6.11 16.7699 6.44 17.1799 6.44C17.5899 6.44 17.9199 6.11 17.9199 5.7V4.96H18.9699C19.6099 4.96 20.1399 5.49 20.1399 6.13V8.29H3.84988V6.13ZM3.84988 9.78H20.1499V19.35C20.1499 19.99 19.6199 20.52 18.9799 20.52H5.01988C4.37988 20.52 3.84988 19.99 3.84988 19.35V9.78Z" fill="#757575"/></svg> <?php echo get_the_date( 'F j, Y', $post->ID ); ?></span>
									<ul>
										<li class="sharetitle"><?php echo esc_html__('Share', 'repindia'); ?></li>
										<!-- <li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php  echo home_url().'/'.$post->post_name; ?>" title="Share on Facebook" data-ico-fa="" class="icon_holder" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
										</li>
										<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?url=<?php  echo home_url().'/'.$post->post_name; ?>" title="Share on Linkedin" data-ico-fa="" class="icon_holder" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
										</li>
										<li class="instagram"><a href="https://www.instagram.com/<?php  echo home_url().'/'.$post->post_name; ?>" title="Share on Instagram" data-ico-fa="" class="icon_holder" target="_blank"><i class="fa fa-instagram"></i></a>
										</li> -->
										<li class="tooltip">
										<input style="display: none;" type="text" value="<?php echo get_permalink(); ?>" id="clipinput">
										<button id="copyButton" onmouseout="outFunc()">
										<span class="tooltiptext" id="blogtooltip"><?php echo esc_html__('Copy to clipboard', 'repindia'); ?></span>
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7.4098 21.7001C6.0398 21.7001 4.7598 21.17 3.7998 20.21C2.8398 19.25 2.2998 17.96 2.2998 16.6C2.2998 15.24 2.8298 13.95 3.7998 12.99L6.85981 9.93005C7.00981 9.78005 7.1998 9.70005 7.4098 9.70005C7.6198 9.70005 7.8098 9.78005 7.9598 9.93005C8.2598 10.24 8.2598 10.73 7.9598 11.04L4.8998 14.1C4.2298 14.77 3.8598 15.66 3.8598 16.61C3.8598 17.56 4.2298 18.4501 4.8998 19.1201C5.5698 19.7901 6.4598 20.16 7.4098 20.16C8.3598 20.16 9.2498 19.7901 9.9198 19.1201L12.9798 16.06C13.1298 15.91 13.3198 15.83 13.5298 15.83C13.7398 15.83 13.9398 15.91 14.0798 16.06C14.2298 16.21 14.3098 16.4 14.3098 16.61C14.3098 16.82 14.2298 17.01 14.0798 17.16L11.0198 20.22C10.0598 21.18 8.7698 21.71 7.4098 21.71V21.7001ZM16.5898 14.31C16.3798 14.31 16.1798 14.23 16.0398 14.08C15.7398 13.78 15.7398 13.28 16.0398 12.97L19.0998 9.91005C19.7698 9.24005 20.1398 8.35005 20.1398 7.40005C20.1398 6.45005 19.7698 5.56005 19.0998 4.89005C18.4298 4.22005 17.5398 3.85005 16.5898 3.85005C15.6398 3.85005 14.7498 4.22005 14.0798 4.89005L11.0198 7.95005C10.8698 8.10005 10.6798 8.18005 10.4698 8.18005C10.2598 8.18005 10.0598 8.10005 9.9198 7.95005C9.7698 7.80005 9.6898 7.61005 9.6898 7.40005C9.6898 7.19005 9.7698 6.99005 9.9198 6.85005L12.9798 3.79005C13.9398 2.83005 15.2298 2.30005 16.5898 2.30005C17.9498 2.30005 19.2398 2.83005 20.1998 3.79005C21.1598 4.76005 21.6998 6.04005 21.6998 7.40005C21.6998 8.76005 21.1698 10.05 20.1998 11.01L17.1398 14.07C16.9898 14.22 16.7998 14.3 16.5898 14.3V14.31Z" fill="#121212"/><path d="M8.94016 15.84C8.73016 15.84 8.54016 15.76 8.39016 15.61C8.24016 15.46 8.16016 15.27 8.16016 15.06C8.16016 14.85 8.24016 14.65 8.39016 14.51L14.5102 8.39003C14.6602 8.24003 14.8502 8.16003 15.0602 8.16003C15.2702 8.16003 15.4602 8.24003 15.6102 8.39003C15.7602 8.54003 15.8402 8.73003 15.8402 8.94003C15.8402 9.15003 15.7602 9.35003 15.6102 9.49003L9.49016 15.61C9.34016 15.76 9.15016 15.84 8.94016 15.84Z" fill="#121212"/></svg>
										<!-- <img src="<?php //echo esc_url( home_url( '/' ) ); ?>wp-content/themes/repindia/assets/images/clipboard.svg" alt="Clipboard"> -->
										</button>
										</li>
									</ul>
								</div>
							</div>
							<div class="blog-list__content"><?php the_content();  ?></div>
						</div>
					</div>
				</div>
				<div class="blogrightbox">
					<?php
					$heighlightarg = array(
						'post_type'        =>  'post',
						'post_status'      =>  'publish',
						'order'            => 'DESC',
						'posts_per_page'   => '4',
					);
					if( !empty(get_field('highlighted_news_taxonomy')) ){ 
						$highlighted_news = get_field('highlighted_news_taxonomy');
						$heighlightarg['tax_query'][] = [
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' => $highlighted_news[0]->slug,
						];
					}
					$heighlighted_blogs = new WP_Query( $heighlightarg ); 
					?>
					<div class="news_section latestnewssidebar">
						<ul class="news_box_row">
							<li class="sidebartitle"><?php echo esc_html__('Highlights', 'repindia'); ?></li>
							<?php
							while ($heighlighted_blogs->have_posts()) : $heighlighted_blogs->the_post();
								$latestfeatured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
								$latestnewscategories = get_the_category();
								if($latestnewscategories[0]->slug == 'event'){
								?>
								<li class="news_box news_box_overlay" style="background: url(<?php echo $latestfeatured_img_url; ?>);">
									<a href="<?php echo get_permalink(); ?>">
										<div class="newscat"><h4><?php echo $latestnewscategories[0]->cat_name; ?></h4></div>
										<div class="newsbox_content">
											<h3><?php the_title(); ?></h3>
											<div class="content-bottom-box">
												<span><?php echo get_the_date( 'j F Y', get_the_ID() ); ?></span>
												<span class="btn-more"><?php echo esc_html__('Read More', 'repindia'); ?> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none"><path d="M3.72127 11.8004L10.1029 5.45374L10.0854 11.3921C10.0854 11.7246 10.3538 11.9987 10.6863 11.9987C10.8438 11.9987 11.0013 11.9346 11.1121 11.8237C11.2229 11.7129 11.2871 11.5671 11.2929 11.3979L11.3104 4.00707C11.3104 3.67457 11.0421 3.40624 10.7096 3.40041L3.31877 3.38291C2.98627 3.37707 2.7121 3.63957 2.70627 3.97207C2.70044 4.30457 2.96294 4.57874 3.29544 4.58457C3.30127 4.58457 3.3071 4.58457 3.31877 4.58457L9.2571 4.60207L2.87544 10.9487C2.6421 11.1821 2.63627 11.5671 2.87544 11.8004C3.1146 12.0337 3.49377 12.0396 3.7271 11.8004H3.72127Z" fill="#121212"/></svg></span>
											</div>
										</div>
									</a>
								</li>
							<?php }else{ ?>
								<li class="news_box newsbox_grid">
									<a href="<?php echo get_permalink(); ?>">
										<div class="newsgridimg">
										<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'news_thumb_img' ) ); ?>
										</div>
										<div class="newscat"><h4><?php echo $latestnewscategories[0]->cat_name; ?></h4></div>
										<div class="newsbox_content">
											<h3><?php the_title(); ?></h3>
											<div class="content-bottom-box">
												<span><?php echo get_the_date( 'j F Y', get_the_ID() ); ?></span>
												<span class="btn-more" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More', 'repindia'); ?> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none"><path d="M3.72127 11.8004L10.1029 5.45374L10.0854 11.3921C10.0854 11.7246 10.3538 11.9987 10.6863 11.9987C10.8438 11.9987 11.0013 11.9346 11.1121 11.8237C11.2229 11.7129 11.2871 11.5671 11.2929 11.3979L11.3104 4.00707C11.3104 3.67457 11.0421 3.40624 10.7096 3.40041L3.31877 3.38291C2.98627 3.37707 2.7121 3.63957 2.70627 3.97207C2.70044 4.30457 2.96294 4.57874 3.29544 4.58457C3.30127 4.58457 3.3071 4.58457 3.31877 4.58457L9.2571 4.60207L2.87544 10.9487C2.6421 11.1821 2.63627 11.5671 2.87544 11.8004C3.1146 12.0337 3.49377 12.0396 3.7271 11.8004H3.72127Z" fill="#121212"/></svg></span>
											</div>
										</div>
									</a>
								</li>
							<?php
								}
							endwhile;
							wp_reset_query();
							?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Related Blog data -->
			<div class="news_section related_news_section">
				<h4 class="relatedblog_section_title"><?php echo esc_html__('You may also like', 'repindia'); ?></h4>
				<ul class="news_box_row">
					<?php
					while ($related_blogs->have_posts()) : $related_blogs->the_post();
						$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
						if($newscategories[0]->slug == 'event'){
						?>
							<li class="news_box news_box_overlay" style="background: url(<?php echo $featured_img_url; ?>);">
								<a href="<?php echo get_permalink(); ?>">
									<div class="newscat"><h4><?php echo $newscategories[0]->cat_name; ?></h4></div>
									<div class="newsbox_content">
										<h3><?php the_title(); ?></h3>
										<div class="content-bottom-box">
											<span><?php echo get_the_date( 'j F Y', get_the_ID() ); ?></span>
											<span class="btn-more" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More', 'repindia'); ?> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none"><path d="M3.72127 11.8004L10.1029 5.45374L10.0854 11.3921C10.0854 11.7246 10.3538 11.9987 10.6863 11.9987C10.8438 11.9987 11.0013 11.9346 11.1121 11.8237C11.2229 11.7129 11.2871 11.5671 11.2929 11.3979L11.3104 4.00707C11.3104 3.67457 11.0421 3.40624 10.7096 3.40041L3.31877 3.38291C2.98627 3.37707 2.7121 3.63957 2.70627 3.97207C2.70044 4.30457 2.96294 4.57874 3.29544 4.58457C3.30127 4.58457 3.3071 4.58457 3.31877 4.58457L9.2571 4.60207L2.87544 10.9487C2.6421 11.1821 2.63627 11.5671 2.87544 11.8004C3.1146 12.0337 3.49377 12.0396 3.7271 11.8004H3.72127Z" fill="#121212"/></svg></span>
										</div>
									</div>
								</a>
							</li>
						<?php }else{ ?>
							<li class="news_box newsbox_grid">
								<a href="<?php echo get_permalink(); ?>">
									<div class="newsgridimg">
									<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'news_thumb_img' ) ); ?>
									</div>
									<div class="newscat"><h4><?php echo $newscategories[0]->cat_name; ?></h4></div>
									<div class="newsbox_content">
										<h3><?php the_title(); ?></h3>
										<div class="content-bottom-box">
											<span><?php echo get_the_date( 'j F Y', get_the_ID() ); ?></span>
											<span class="btn-more" href="<?php echo get_permalink(); ?>"><?php echo esc_html__('Read More', 'repindia'); ?> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15" fill="none"><path d="M3.72127 11.8004L10.1029 5.45374L10.0854 11.3921C10.0854 11.7246 10.3538 11.9987 10.6863 11.9987C10.8438 11.9987 11.0013 11.9346 11.1121 11.8237C11.2229 11.7129 11.2871 11.5671 11.2929 11.3979L11.3104 4.00707C11.3104 3.67457 11.0421 3.40624 10.7096 3.40041L3.31877 3.38291C2.98627 3.37707 2.7121 3.63957 2.70627 3.97207C2.70044 4.30457 2.96294 4.57874 3.29544 4.58457C3.30127 4.58457 3.3071 4.58457 3.31877 4.58457L9.2571 4.60207L2.87544 10.9487C2.6421 11.1821 2.63627 11.5671 2.87544 11.8004C3.1146 12.0337 3.49377 12.0396 3.7271 11.8004H3.72127Z" fill="#121212"/></svg></span>
										</div>
									</div>
								</a>
							</li>
					<?php
						}
					endwhile;
					wp_reset_query();
					?>
				</ul>
			</div>
	<?php
	    }
	}
	?>
	<script>
		document.getElementById("copyButton").addEventListener("click", function() {
			// Get the current URL
			var url = window.location.href;
			// Create a temporary input element
			var input = document.createElement('input');
			input.setAttribute('value', url);
			document.body.appendChild(input);
			// Select the input content
			input.select();
			input.setSelectionRange(0, 99999); // For mobile devices
			// Copy the selected content
			document.execCommand('copy');
			// Remove the temporary input
			document.body.removeChild(input);
			// msg
			var tooltipsuccess = document.getElementById("blogtooltip");
			tooltipsuccess.innerHTML = 'Copied';
		});
		
		function outFunc(tooltext) {
			var tooltip = document.getElementById("blogtooltip");
			tooltip.innerHTML = 'Copy to clipboard';
		}
	</script>
<?php get_footer(); ?>
