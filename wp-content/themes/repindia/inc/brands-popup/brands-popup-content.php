<?php
if (!defined('ABSPATH')) {
	exit;
}

$brands_query = new WP_Query(array(
	'post_type' => 'brands',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'no_found_rows' => true,
	'orderby' => 'title',
	'order' => 'ASC',
	'fields' => 'ids',
));

$brand_ids = !empty($brands_query->posts) ? $brands_query->posts : array();
wp_reset_postdata();
?>

<?php if (!empty($brand_ids)) : ?>
	<div class="brands-tech-tab-container" data-brands-popup-tabs>
		<div class="brands-tech-tabs-nav">
			<ul>
				<li>
					<button class="brands-tech-tab-btn active" type="button" data-brand-tab="all" data-text="All">All</button>
				</li>
				<?php foreach ($brand_ids as $index => $brand_id) :
					$brand_title = get_the_title($brand_id);
					if (empty($brand_title)) {
						continue;
					}
					$tab_slug = sanitize_title($brand_title . '-' . $brand_id);
				?>
					<li>
						<button class="brands-tech-tab-btn"
							type="button"
							data-brand-tab="<?php echo esc_attr($tab_slug); ?>"
							data-text="<?php echo esc_attr($brand_title); ?>">
							<?php echo esc_html($brand_title); ?>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<select class="brands-tech-tabs-dropdown" aria-label="<?php esc_attr_e('Select brand', 'repindia'); ?>">
			<option value="all"><?php esc_html_e('All', 'repindia'); ?></option>
			<?php foreach ($brand_ids as $index => $brand_id) :
				$brand_title = get_the_title($brand_id);
				if (empty($brand_title)) {
					continue;
				}
				$tab_slug = sanitize_title($brand_title . '-' . $brand_id);
			?>
				<option value="<?php echo esc_attr($tab_slug); ?>">
					<?php echo esc_html($brand_title); ?>
				</option>
			<?php endforeach; ?>
		</select>

		<div class="brands-tech-images-grid">
			<?php
			foreach ($brand_ids as $brand_id) :
				$brand_title = get_the_title($brand_id);
				if (empty($brand_title)) {
					continue;
				}
				$tab_slug = sanitize_title($brand_title . '-' . $brand_id);

				$light_gallery = function_exists('get_field') ? get_field('brand_light_gallery', $brand_id) : array();
				$dark_gallery = function_exists('get_field') ? get_field('brand_dark_gallery', $brand_id) : array();

				$has_dark_images = !empty($dark_gallery);

				if (empty($light_gallery) && empty($dark_gallery)) {
					continue;
				}

				if (!empty($light_gallery)) :
					foreach ($light_gallery as $img) :
						$img_url = '';
						$img_alt = $brand_title;
						$attachment_id = 0;

						// ACF gallery return format can be: array (image array), int (attachment ID), or URL string.
						if (is_array($img)) {
							if (!empty($img['url'])) {
								$img_url = $img['url'];
							}
							if (!empty($img['alt'])) {
								$img_alt = $img['alt'];
							}
							if (!empty($img['ID'])) {
								$attachment_id = (int) $img['ID'];
							} elseif (!empty($img['id'])) {
								$attachment_id = (int) $img['id'];
							}
						} elseif (is_numeric($img)) {
							$attachment_id = (int) $img;
						} elseif (is_string($img) && !empty($img)) {
							$img_url = $img;
						}

						if (empty($img_url) && $attachment_id) {
							$img_url = wp_get_attachment_image_url($attachment_id, 'full');
						}
						if (($img_alt === $brand_title || $img_alt === '') && $attachment_id) {
							$stored_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
							if (!empty($stored_alt)) {
								$img_alt = $stored_alt;
							}
						}
						if (empty($img_url)) {
							continue;
						}
			?>
						<div class="brands-tech-image-item brands-tech-image-light<?php echo !$has_dark_images ? ' brands-tech-image-fallback' : ''; ?>"
							data-brand-tab="<?php echo esc_attr($tab_slug); ?>" data-has-dark="<?php echo $has_dark_images ? '1' : '0'; ?>">
							<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" decoding="async">
						</div>
			<?php
					endforeach;
				endif;

				if (!empty($dark_gallery)) :
					foreach ($dark_gallery as $img) :
						$img_url = '';
						$img_alt = $brand_title;
						$attachment_id = 0;

						if (is_array($img)) {
							if (!empty($img['url'])) {
								$img_url = $img['url'];
							}
							if (!empty($img['alt'])) {
								$img_alt = $img['alt'];
							}
							if (!empty($img['ID'])) {
								$attachment_id = (int) $img['ID'];
							} elseif (!empty($img['id'])) {
								$attachment_id = (int) $img['id'];
							}
						} elseif (is_numeric($img)) {
							$attachment_id = (int) $img;
						} elseif (is_string($img) && !empty($img)) {
							$img_url = $img;
						}

						if (empty($img_url) && $attachment_id) {
							$img_url = wp_get_attachment_image_url($attachment_id, 'full');
						}
						if (($img_alt === $brand_title || $img_alt === '') && $attachment_id) {
							$stored_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
							if (!empty($stored_alt)) {
								$img_alt = $stored_alt;
							}
						}
						if (empty($img_url)) {
							continue;
						}
			?>
						<div class="brands-tech-image-item brands-tech-image-dark"
							data-brand-tab="<?php echo esc_attr($tab_slug); ?>">
							<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" decoding="async">
						</div>
			<?php
					endforeach;
				endif;
			endforeach;
			?>
		</div>
	</div>
<?php else : ?>
	<p class="mb-0"><?php esc_html_e('No brands found.', 'repindia'); ?></p>
<?php endif; ?>

