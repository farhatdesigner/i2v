<?php
/**
 * The template for displaying search results pages.
 *
 * @package repindia
 */
global $post, $paged, $wp;
repindia_get_header();

// Get search query
$search_query = get_search_query();
$search_keyword = sanitize_text_field($search_query);

// Get filter type from URL
$filter_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all';
$valid_types = array('all', 'industry', 'content', 'support');
if (!in_array($filter_type, $valid_types)) {
	$filter_type = 'all';
}

// Get current page
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if (!$paged) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
}

// Build query args based on filter type
$query_args = array(
	's' => $search_keyword,
	'paged' => $paged,
	'posts_per_page' => 10,
	'post_status' => 'publish',
	'ignore_sticky_posts' => true,
);

// Filter by post type based on tab selection
switch ($filter_type) {
	case 'industry':
		$query_args['post_type'] = array('industries');
		break;
	case 'content':
		$query_args['post_type'] = array('newsroom', 'post');
		break;
	case 'support':
		$query_args['post_type'] = array('resources');
		break;
	case 'all':
	default:
		$query_args['post_type'] = array('products', 'industries', 'newsroom', 'post', 'resources');
		break;
}

// Perform query
$search_query_obj = new WP_Query($query_args);

// Get total results count for "All results"
$all_results_count = 0;
if ($filter_type === 'all') {
	$all_results_count = $search_query_obj->found_posts;
} else {
	// Get count for all results
	$all_args = $query_args;
	$all_args['post_type'] = array('products', 'industries', 'newsroom', 'post', 'resources');
	$all_args['posts_per_page'] = 1;
	$all_args['paged'] = 1;
	$all_query = new WP_Query($all_args);
	$all_results_count = $all_query->found_posts;
	wp_reset_postdata();
}
?>
<?php if ($search_query_obj->have_posts()): ?>
	<div class="search_result_header"
		style="background-image: url('<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2024/03/home_banner.webp');">
		<div class="custom-container">
			<div class="search_result_header_content">
				<div class="inner_page_banner_content">
					<h1>
						<?php
						echo esc_html(
							sprintf(
								/* translators: %s: current search query */
								__('Search Results for "%s"', 'repindia'),
								get_search_query()
							)
						);
						?>
					</h1>
					<p><?php echo esc_html__('Browse through resources matching your search. Quickly find software downloads, manuals, brochures, or tutorials to get the information you need.', 'repindia'); ?>
					</p>
				</div>
				<div class="search_result_image">
					<img class="white_theme_img w-100" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2026/04/search-img.svg"
						alt="Search Result Image" width="100%" height="100%">
					<img class="black_theme_img w-100" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2026/04/search-img.svg"
						alt="Search Result Image" width="100%" height="100%">
				</div>
			</div>
		</div>
	<?php endif; ?>
	<style>
		html.lenis,
		body {
			overflow-x: visible;
		}
	</style>
	<div class="global_search search_layout">
		<div class="custom-container">
			<div class="search-results-wrapper">
				<!-- Search Tabs -->
				<?php if ($search_query_obj->have_posts()): ?>
					<div class="search-tabs-container">
						<ul class="search-tabs-list">
							<li>
								<a href="<?php echo esc_url(add_query_arg(array('s' => $search_keyword, 'type' => 'all'), home_url('/'))); ?>"
									class="search-tab <?php echo $filter_type === 'all' ? 'active' : ''; ?>"
									data-type="all">
									<?php echo esc_html__('All results', 'repindia'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(add_query_arg(array('s' => $search_keyword, 'type' => 'industry'), home_url('/'))); ?>"
									class="search-tab <?php echo $filter_type === 'industry' ? 'active' : ''; ?>"
									data-type="industry">
									<?php echo esc_html__('Industry', 'repindia'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(add_query_arg(array('s' => $search_keyword, 'type' => 'content'), home_url('/'))); ?>"
									class="search-tab <?php echo $filter_type === 'content' ? 'active' : ''; ?>"
									data-type="content">
									<?php echo esc_html__('Content category', 'repindia'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(add_query_arg(array('s' => $search_keyword, 'type' => 'support'), home_url('/'))); ?>"
									class="search-tab <?php echo $filter_type === 'support' ? 'active' : ''; ?>"
									data-type="support">
									<?php echo esc_html__('Support & documentation', 'repindia'); ?>
								</a>
							</li>
						</ul>
					</div>
				<?php endif; ?>

				<!-- Results Count -->
				<?php if ($search_query_obj->have_posts() || $all_results_count > 0): ?>
					<div class="search-results-count">
						<?php
						if ($filter_type === 'all') {
							printf(esc_html__('About %d results', 'repindia'), $all_results_count);
						} else {
							printf(esc_html__('About %d results', 'repindia'), $search_query_obj->found_posts);
						}
						?>
					</div>
				<?php endif; ?>

				<!-- Search Results -->
				<div id="result_primary" class="search-results-content">
					<?php if ($search_query_obj->have_posts()): ?>
						<?php while ($search_query_obj->have_posts()):
							$search_query_obj->the_post(); ?>
							<?php
							if (get_post_format($post->ID)) {
								get_template_part('content', get_post_format());
							} else {
								get_template_part('search', 'format');
							}
							?>
						<?php endwhile; ?>

						<!-- Pagination -->
						<?php if ($search_query_obj->max_num_pages > 1): ?>
							<div class="paginationWrapper">
								<div class="nubmerPagination">
									<?php
									// Build base URL for pagination
									$current_url = home_url('/');
									$query_params = array('s' => $search_keyword);
									if ($filter_type !== 'all') {
										$query_params['type'] = $filter_type;
									}
									$base_url = add_query_arg($query_params, $current_url);

									$pagination_args = array(
										'total' => $search_query_obj->max_num_pages,
										'current' => $paged,
										'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5172 17.7169C15.0726 17.1615 15.0726 16.261 14.5172 15.7055L9.83394 11.0223L14.5172 6.33909C15.0726 5.78368 15.0726 4.88317 14.5172 4.32776C13.9618 3.77235 13.0613 3.77235 12.5058 4.32776L6.81695 10.0166C6.26154 10.5721 6.26154 11.4726 6.81695 12.028L12.5058 17.7169C13.0613 18.2723 13.9618 18.2723 14.5172 17.7169Z" fill="#5F6F94"/></svg>',
										'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="15" viewBox="0 0 9 15" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.41656 0.416507C-0.138853 0.971919 -0.138853 1.87242 0.41656 2.42783L5.09978 7.11106L0.416559 11.7943C-0.138853 12.3497 -0.138853 13.2502 0.416559 13.8056C0.971971 14.361 1.87247 14.361 2.42788 13.8056L8.11677 8.11672C8.67219 7.56131 8.67219 6.66081 8.11677 6.1054L2.42789 0.416507C1.87247 -0.138905 0.971972 -0.138905 0.41656 0.416507Z" fill="#5F6F94"/></svg>',
										'type' => 'plain',
										'base' => $base_url . '%_%',
										'format' => '&paged=%#%',
									);

									echo paginate_links($pagination_args);
									?>
								</div>
							</div>
						<?php endif; ?>

					<?php elseif (is_search()): ?>
						<!-- No Results Found -->
						<div class="search-no-results">
							<div class="search-no-results-header">
								<p class="search-query-label">
									<?php printf(esc_html__('Search Results for: %s', 'repindia'), '<strong>' . esc_html($search_keyword) . '</strong>'); ?>
								</p>
								<h2 class="search-no-results-title">
									<?php echo esc_html__('No results found', 'repindia'); ?>
								</h2>
							</div>

							<div class="search-no-results-icon">
						<img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2026/02/no-result-placeholder1.gif" alt="No Results Found" width="120" height="120">
						<img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2026/05/no-result-placeholder1_dark.gif" alt="No Results Found" width="120" height="120">
							</div>

							<div class="search-no-results-message">
								<p class="search-no-results-text">
									<?php echo esc_html__('We couldn\'t find any resources matching your search.', 'repindia'); ?>
								</p>
								<p class="search-no-results-suggestion">
									<?php echo esc_html__('Try adjusting your keywords, or explore our categories to locate software downloads, manuals, brochures, or tutorials.', 'repindia'); ?>
								</p>
							</div>

							<div class="search-no-results-actions">
								<a href="<?php echo esc_url(home_url('/resources/')); ?>" class="theme-btn xl-btn">
									<?php echo esc_html__('Browse all resources', 'repindia'); ?>
								</a>
								<a href="<?php echo esc_url(home_url('/i2vs-products/')); ?>"
									class="theme-btn-white xl-btn border-btn-grey">
									<?php echo esc_html__('Explore our solutions', 'repindia'); ?>
								</a>
							</div>
						</div>
					<?php else: ?>
						<div class="error_search_msg">
							<h4><?php echo esc_html__('It seems we can not find what you\'re looking for. Perhaps searching can help.', 'repindia'); ?>
							</h4>
							<?php get_search_form(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php
	// Reset post data
	wp_reset_postdata();
	get_footer();
	?>