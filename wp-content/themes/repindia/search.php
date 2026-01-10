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
<div class="search_result_header" style="background-image: url('<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2024/03/home_banner.webp');" >
	<div class="container">
		<div class="inner_page_banner_content">
			<h1><?php echo esc_html__( 'Search result', 'repindia' ) ?></h1>
			<p><?php echo esc_html__( 'Browse through resources matching your search. Quickly find software downloads, manuals, brochures, or tutorials to get the information you need.', 'repindia' ); ?></p>
		</div>
	</div>
</div>
<div class="global_search search_layout">
	<div class="container">
		<div class="search-results-wrapper">
			<!-- Search Tabs -->
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

			<!-- Results Count -->
			<?php if ($search_query_obj->have_posts() || $all_results_count > 0) : ?>
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
				<?php if ($search_query_obj->have_posts()) : ?>
					<?php while ($search_query_obj->have_posts()) : $search_query_obj->the_post(); ?>
						<?php
						if (get_post_format($post->ID)) {
							get_template_part('content', get_post_format());
						} else {
							get_template_part('search', 'format');
						}
						?>
					<?php endwhile; ?>

					<!-- Pagination -->
					<?php if ($search_query_obj->max_num_pages > 1) : ?>
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
									'prev_text' => '<i class="fa fa-angle-left"></i>',
									'next_text' => '<i class="fa fa-angle-right"></i>',
									'type' => 'plain',
									'base' => $base_url . '%_%',
									'format' => '?paged=%#%',
								);
								
								echo paginate_links($pagination_args);
								?>
							</div>
						</div>
					<?php endif; ?>

				<?php elseif (is_search()) : ?>
					<!-- No Results Found -->
					<div class="search-no-results">
						<div class="search-no-results-header">
							<p class="search-query-label">
								<?php printf(esc_html__('Search Results for: %s', 'repindia'), '<strong>' . esc_html($search_keyword) . '</strong>'); ?>
							</p>
							<h2 class="search-no-results-title"><?php echo esc_html__('No results found', 'repindia'); ?></h2>
						</div>
						
						<div class="search-no-results-icon">
							<svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="120" height="120" rx="8" fill="white"/>
								<path d="M30 20H90V100H30V20Z" stroke="#333" stroke-width="2" fill="none"/>
								<line x1="35" y1="35" x2="85" y2="35" stroke="#333" stroke-width="2"/>
								<line x1="35" y1="50" x2="85" y2="50" stroke="#333" stroke-width="2"/>
								<line x1="35" y1="65" x2="70" y2="65" stroke="#333" stroke-width="2"/>
								<circle cx="75" cy="75" r="15" stroke="#333" stroke-width="2" fill="none"/>
								<line x1="85" y1="85" x2="95" y2="95" stroke="#333" stroke-width="2" stroke-linecap="round"/>
								<circle cx="75" cy="75" r="5" fill="#0066CC"/>
								<line x1="77" y1="77" x2="82" y2="82" stroke="white" stroke-width="2" stroke-linecap="round"/>
							</svg>
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
							<a href="<?php echo esc_url(home_url('/resources/')); ?>" class="search-btn-primary">
								<?php echo esc_html__('Browse all resources', 'repindia'); ?>
							</a>
							<a href="<?php echo esc_url(home_url('/i2vs-products/')); ?>" class="search-btn-secondary">
								<?php echo esc_html__('Explore our solutions', 'repindia'); ?>
							</a>
						</div>
					</div>
				<?php else : ?>
					<div class="error_search_msg">
						<h4><?php echo esc_html__('It seems we can not find what you\'re looking for. Perhaps searching can help.', 'repindia'); ?></h4> 
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
