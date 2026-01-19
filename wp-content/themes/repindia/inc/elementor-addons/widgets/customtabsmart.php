<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH'))
	exit;

class Customtabsmart extends Widget_Base
{
	public function get_name()
	{
		return 'customtabsmart';
	}
	public function get_title()
	{
		return 'Custom Tab Smart';
	}
	public function get_icon()
	{
		return 'fa fa-newspaper-o';
	}
	public function get_category()
	{
		return ['general'];
	}
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => 'Content Settings',
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => esc_html__('Section Title', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Smart city solution ecosystem — connecting technology, people, and cities with i2V',
				'label_block' => true,
			]
		);

		$this->add_control(
			'section_description',
			[
				'label' => esc_html__('Section Description', 'repindia'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'label_block' => true,
			]
		);

		// Repeater for Tabs and Content
		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__('Tab Title', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Tab Title',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label' => esc_html__('Item Title', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Item Title',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label' => esc_html__('Item Description', 'repindia'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Item description text here.',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cta_one_text',
			[
				'label' => esc_html__('CTA 1 Text', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Request a VMS demo',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cta_one_url',
			[
				'label' => esc_html__('CTA 1 URL', 'repindia'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'repindia'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$repeater->add_control(
			'cta_one_classes',
			[
				'label' => esc_html__('CTA 1 Classes', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the CTA 1 link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cta_two_text',
			[
				'label' => esc_html__('CTA 2 Text', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Learn more about centralized VMS',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cta_two_url',
			[
				'label' => esc_html__('CTA 2 URL', 'repindia'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'repindia'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$repeater->add_control(
			'cta_two_classes',
			[
				'label' => esc_html__('CTA 2 Classes', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the CTA 2 link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_image_default',
			[
				'label' => esc_html__('Image (Default Theme)', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$repeater->add_control(
			'item_image_dark',
			[
				'label' => esc_html__('Image (Dark Theme)', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' => esc_html__('Tabs & Content', 'repindia'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => 'i2V VMS',
						'item_title' => 'Centralized visibility with i2V VMS',
						'item_description' => '<p>Our scalable Video Management System offers real-time monitoring and playback across all connected cameras, crucial for City-Wide Surveillance, Emergency Response, and coordinating across multiple zones.</p><p>It also supports Mobile View + Edge Recording for extended reach.</p>',
						'cta_one_text' => 'Request a VMS demo',
						'cta_one_url' => ['url' => '#'],
						'cta_two_text' => 'Learn more about centralized VMS',
						'cta_two_url' => ['url' => '#'],
					],
					[
						'tab_title' => 'AI based video analytics / VCA',
						'item_title' => 'Intelligence behind every camera',
						'item_description' => '<p>Our scalable Video Management System offers real-time monitoring and playback across all connected cameras, crucial for City-Wide Surveillance, Emergency Response, and coordinating across multiple zones.</p><p>It also supports Mobile View + Edge Recording for extended reach.</p>',
						'cta_one_text' => 'Request a VMS demo',
						'cta_one_url' => ['url' => '#'],
						'cta_two_text' => 'Learn more about centralized VMS',
						'cta_two_url' => ['url' => '#'],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		
		$this->end_controls_section();
	}

	// Php Render
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$tabs_list = isset($settings['tabs_list']) ? $settings['tabs_list'] : [];
		$section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
		$section_description = isset($settings['section_description']) ? $settings['section_description'] : '';

		// Helper function to get image URL
		$get_image_url = function($image, $default_image = '') {
			if (!empty($image['url'])) {
				return esc_url($image['url']);
			}
			return $default_image;
		};

		// Check for dark theme
		$is_dark_theme = false;
		if (isset($_GET['dark_mode']) || (function_exists('get_theme_mod') && get_theme_mod('dark_mode_enabled', false))) {
			$is_dark_theme = true;
		}

		$this->add_inline_editing_attributes('custom_class', 'basic'); ?>

		<div class="customtabsmart">
			<section class="smart-microspace-inside">
				<div class="custom-container">
					<?php if (!empty($section_title)): ?>
						<div class="col-lg-8 col-xxl-7">
							<h3 class="smart-main_title quote"><?php echo esc_html($section_title); ?></h3>
						</div>
					<?php endif; ?>
					<?php if (!empty($section_description)): ?>
						<div class="col-lg-8 col-xxl-7">
							<p><?php echo esc_html($section_description); ?></p>
						</div>
					<?php endif; ?>
					<div class="smart-contentWrapper">
						<div class="smart-filter-menu smart-tabsWrapper">
							<label class="smart-dropdown-label">Solutions</label>
							<?php if (!empty($tabs_list)): ?>
								<span class="smart-select-brand"><?php echo esc_html($tabs_list[0]['tab_title']); ?></span>
							<?php else: ?>
								<span class="smart-select-brand">i2V's VMS</span>
							<?php endif; ?>
							<?php if (!empty($tabs_list)): ?>
								<ul class="smart-tabsautoscroll smart-tabs-list" id="smartTab">
									<?php foreach ($tabs_list as $index => $tab): 
										$content_id = 'content' . $index;
										$is_first = ($index === 0);
									?>
										<li data-id="<?php echo esc_attr($content_id); ?>" class="tracking-wide <?php echo $is_first ? 'active' : ''; ?> smart-tab-item">
											<a class="smart-tab-link" href="#<?php echo esc_attr($content_id); ?>"><?php echo esc_html($tab['tab_title']); ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
						<div class="smart-container-marketing">
							<div class="row overflow-hidden">
								<div class="smart-tabContent position-relative" id="smart-tabs-content">
									<?php if (!empty($tabs_list)): ?>
										<?php foreach ($tabs_list as $index => $tab): 
											$content_id = 'content' . $index;
											$is_first = ($index === 0);
											
											// Get image URLs
											$default_image = isset($tab['item_image_default']) ? $tab['item_image_default'] : [];
											$dark_image = isset($tab['item_image_dark']) ? $tab['item_image_dark'] : [];
											
											$default_image_url = $get_image_url($default_image, esc_url(home_url('/')) . 'wp-content/uploads/2025/11/thumbnail.webp');
											$dark_image_url = $get_image_url($dark_image, $default_image_url);
											
											// Get CTA URLs
											$cta_one_url = isset($tab['cta_one_url']['url']) ? esc_url($tab['cta_one_url']['url']) : '#';
											$cta_one_target = isset($tab['cta_one_url']['is_external']) && $tab['cta_one_url']['is_external'] ? ' target="_blank"' : '';
											$cta_one_nofollow = isset($tab['cta_one_url']['nofollow']) && $tab['cta_one_url']['nofollow'] ? ' rel="nofollow"' : '';
											$cta_one_classes = isset($tab['cta_one_classes']) && !empty($tab['cta_one_classes']) ? ' ' . esc_attr($tab['cta_one_classes']) : '';
											
											$cta_two_url = isset($tab['cta_two_url']['url']) ? esc_url($tab['cta_two_url']['url']) : '#';
											$cta_two_target = isset($tab['cta_two_url']['is_external']) && $tab['cta_two_url']['is_external'] ? ' target="_blank"' : '';
											$cta_two_nofollow = isset($tab['cta_two_url']['nofollow']) && $tab['cta_two_url']['nofollow'] ? ' rel="nofollow"' : '';
											$cta_two_classes = isset($tab['cta_two_classes']) && !empty($tab['cta_two_classes']) ? ' ' . esc_attr($tab['cta_two_classes']) : '';
											
											$item_title = isset($tab['item_title']) ? $tab['item_title'] : '';
											$item_description = isset($tab['item_description']) ? $tab['item_description'] : '';
											$cta_one_text = isset($tab['cta_one_text']) ? $tab['cta_one_text'] : '';
											$cta_two_text = isset($tab['cta_two_text']) ? $tab['cta_two_text'] : '';
										?>
											<div class="<?php echo esc_attr($content_id); ?> smart-tabdiv <?php echo $is_first ? 'smart-active-tabcontent' : ''; ?>">
												<div class="smart-content-inner row g-0">
													<div class="smart-content-inner-image col-lg-7">
														<?php if (!empty($default_image_url)): ?>
															<img 
																class="img-fluid rounded-4 slide-image-default"
																src="<?php echo $default_image_url; ?>"
																alt="<?php echo esc_attr($item_title); ?>"
																<?php if (!empty($dark_image_url) && $dark_image_url !== $default_image_url): ?>
																	data-dark-src="<?php echo esc_attr($dark_image_url); ?>"
																<?php endif; ?>
															>
															<?php if (!empty($dark_image_url) && $dark_image_url !== $default_image_url): ?>
																<img 
																	class="img-fluid rounded-4 slide-image-dark"
																	src="<?php echo $dark_image_url; ?>"
																	alt="<?php echo esc_attr($item_title); ?>"
																	style="display: none;"
																>
															<?php endif; ?>
														<?php endif; ?>
													</div>
													<div class="smart-content-inner-text col-lg-5">
														<?php if (!empty($item_title)): ?>
															<h4 class="smart-sub_title"><?php echo esc_html($item_title); ?></h4>
														<?php endif; ?>
														<?php if (!empty($item_description)): ?>
															<?php echo wp_kses_post($item_description); ?>
														<?php endif; ?>
														<?php if (!empty($cta_one_text) || !empty($cta_two_text)): ?>
															<div class="btn-sec_gap">
																<?php if (!empty($cta_one_text)): ?>
																	<a class="theme-btn-white border-btn-grey<?php echo $cta_one_classes; ?>" href="<?php echo $cta_one_url; ?>"<?php echo $cta_one_target . $cta_one_nofollow; ?>><?php echo esc_html($cta_one_text); ?></a>
																<?php endif; ?>
																<?php if (!empty($cta_two_text)): ?>
																	<a href="<?php echo $cta_two_url; ?>" class="theme-btn bg-trans border_btnlight<?php echo $cta_two_classes; ?>"<?php echo $cta_two_target . $cta_two_nofollow; ?>><?php echo esc_html($cta_two_text); ?></a>
																<?php endif; ?>
															</div>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<style>
			/* Dark theme image switching */
			.customtabsmart .slide-image-dark {
				display: none !important;
			}

			body.dark-mode .customtabsmart .slide-image-default,
			body[data-theme="dark"] .customtabsmart .slide-image-default,
			html[data-theme="dark"] .customtabsmart .slide-image-default {
				display: none !important;
			}

			body.dark-mode .customtabsmart .slide-image-dark,
			body[data-theme="dark"] .customtabsmart .slide-image-dark,
			html[data-theme="dark"] .customtabsmart .slide-image-dark {
				display: block !important;
			}
		</style>
		<?php
	}
} ?>
