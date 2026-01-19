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

class Customtabsolution extends Widget_Base
{
	public function get_name()
	{
		return 'customtabsolution';
	}
	public function get_title()
	{
		return 'Custom Tab Solution';
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
				'label' => 'Solution Tabs',
			]
		);

		// Main repeater for tabs
		$repeater = new \Elementor\Repeater();

		// Tab Title (for tab header)
		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__('Tab Title', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		// Tab Image Section
		$repeater->add_control(
			'tab_image',
			[
				'label' => esc_html__('Default Theme Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$repeater->add_control(
			'tab_image_dark',
			[
				'label' => esc_html__('Dark Theme Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
			]
		);

		// Description Content
		$repeater->add_control(
			'tab_content_title',
			[
				'label' => esc_html__('Title', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content_description',
			[
				'label' => esc_html__('Short Description', 'repindia'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
			]
		);

		// Nested Repeater for List Content
		$list_repeater = new \Elementor\Repeater();
		$list_repeater->add_control(
			'list_item_text',
			[
				'label' => esc_html__('List Item Text', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_items',
			[
				'label' => esc_html__('List Content', 'repindia'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $list_repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ list_item_text }}}',
			]
		);

		// Primary CTA
		$repeater->add_control(
			'primary_cta_text',
			[
				'label' => esc_html__('Primary CTA Text', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'primary_cta_url',
			[
				'label' => esc_html__('Primary CTA URL', 'repindia'),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'primary_cta_classes',
			[
				'label' => esc_html__('Primary CTA Classes', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the Primary CTA link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		// Nested Repeater for Properties
		$properties_repeater = new \Elementor\Repeater();
		$properties_repeater->add_control(
			'property_icon_default',
			[
				'label' => esc_html__('Icon/Image Default Theme', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$properties_repeater->add_control(
			'property_icon_dark',
			[
				'label' => esc_html__('Icon/Image Dark Theme', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				'description' => esc_html__('Leave empty to use default icon for dark theme', 'repindia'),
			]
		);

		$properties_repeater->add_control(
			'property_title',
			[
				'label' => esc_html__('Property Title', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'properties',
			[
				'label' => esc_html__('Properties', 'repindia'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $properties_repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ property_title }}}',
			]
		);

		// Secondary CTA
		$repeater->add_control(
			'secondary_cta_text',
			[
				'label' => esc_html__('Secondary CTA Text', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'secondary_cta_url',
			[
				'label' => esc_html__('Secondary CTA URL', 'repindia'),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'secondary_cta_classes',
			[
				'label' => esc_html__('Secondary CTA Classes', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the Secondary CTA link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'solution_tabs',
			[
				'label' => esc_html__('Solution Tabs', 'repindia'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();
	}

	// Php Render
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('custom_class', 'basic');
		
		// Get solution tabs from repeater
		$solution_tabs = !empty($settings['solution_tabs']) ? $settings['solution_tabs'] : [];
		
		// Get first tab title for dropdown label (or use default)
		$first_tab_title = !empty($solution_tabs[0]['tab_title']) ? $solution_tabs[0]['tab_title'] : 'i2V\'s VMS';
		?>

		<div class="customtabsolution">
			<section class="microspace-inside">
				<div class="custom-container">
					<div class="col-lg-8 col-xxl-7">
						<h3 class="main_title quote">Integrated solutions to secure and streamline every facet of your operations </h3>
					</div>
					<div class="contentWrapper">
						<div class="filter-menu tabsWrapper">
							<label class="dropdown-label">Solutions</label>
							<span class="select-brand"><?php echo esc_html($first_tab_title); ?></span>
							<ul class="tabsautoscroll custom-tabs-list" id="solutionTab">
								<?php if (!empty($solution_tabs)) : ?>
									<?php foreach ($solution_tabs as $index => $tab) : ?>
										<?php
										$tab_id = 'content' . $index;
										$tab_title = !empty($tab['tab_title']) ? $tab['tab_title'] : '';
										$is_first = $index === 0;
										$tab_classes = $is_first ? 'tracking-wide active custom-tab-item' : 'custom-tab-item';
										?>
										<li data-id="<?php echo esc_attr($tab_id); ?>" class="<?php echo esc_attr($tab_classes); ?>">
											<a class="custom-tab-link" href="#<?php echo esc_attr($tab_id); ?>"><?php echo esc_html($tab_title); ?></a>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
						<div class="container-marketing">
							<div class="row overflow-hidden">
								<div class="tabContent position-relative" id="tabs-content">
									<?php if (!empty($solution_tabs)) : ?>
										<?php foreach ($solution_tabs as $index => $tab) : ?>
											<?php
											$tab_id = 'content' . $index;
											$is_first = $index === 0;
											$tab_div_class = $is_first ? 'tabdiv active-tabcontent' : 'tabdiv';
											
											// Get tab data
											$tab_image = !empty($tab['tab_image']['url']) ? $tab['tab_image']['url'] : '';
											$tab_image_dark = !empty($tab['tab_image_dark']['url']) ? $tab['tab_image_dark']['url'] : $tab_image;
											$tab_image_alt = !empty($tab['tab_image']['alt']) ? $tab['tab_image']['alt'] : '';
											
											$tab_content_title = !empty($tab['tab_content_title']) ? $tab['tab_content_title'] : '';
											$tab_content_description = !empty($tab['tab_content_description']) ? $tab['tab_content_description'] : '';
											$list_items = !empty($tab['list_items']) ? $tab['list_items'] : [];
											$properties = !empty($tab['properties']) ? $tab['properties'] : [];
											
											$primary_cta_text = !empty($tab['primary_cta_text']) ? $tab['primary_cta_text'] : '';
											$primary_cta_url = !empty($tab['primary_cta_url']['url']) ? $tab['primary_cta_url']['url'] : '#';
											$primary_cta_target = !empty($tab['primary_cta_url']['is_external']) ? 'target="_blank"' : '';
											$primary_cta_nofollow = !empty($tab['primary_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
											$primary_cta_classes = !empty($tab['primary_cta_classes']) ? ' ' . esc_attr($tab['primary_cta_classes']) : '';
											
											$secondary_cta_text = !empty($tab['secondary_cta_text']) ? $tab['secondary_cta_text'] : '';
											$secondary_cta_url = !empty($tab['secondary_cta_url']['url']) ? $tab['secondary_cta_url']['url'] : '#';
											$secondary_cta_target = !empty($tab['secondary_cta_url']['is_external']) ? 'target="_blank"' : '';
											$secondary_cta_nofollow = !empty($tab['secondary_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
											$secondary_cta_classes = !empty($tab['secondary_cta_classes']) ? ' ' . esc_attr($tab['secondary_cta_classes']) : '';
											
											// SVG checkmark icon
											$checkmark_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg>';
											?>
											<div class="<?php echo esc_attr($tab_id . ' ' . $tab_div_class); ?>">
												<div class="content-inner row">
													<?php if (!empty($tab_image)) : ?>
														<div class="content-inner-image col-lg-6 col-md-12 col-12">
															<img class="img-fluid rounded-4 white_theme_img" src="<?php echo esc_url($tab_image); ?>" alt="<?php echo esc_attr($tab_image_alt); ?>">
															<img class="img-fluid rounded-4 black_theme_img" src="<?php echo esc_url($tab_image_dark); ?>" alt="<?php echo esc_attr($tab_image_alt); ?>">
														</div>
													<?php endif; ?>
													
													<div class="content-inner-text col-lg-6 col-md-12 col-12">
														<?php if (!empty($tab_content_title)) : ?>
															<h4 class="sub_title"><?php echo wp_kses_post($tab_content_title); ?></h4>
														<?php endif; ?>
														
														<?php if (!empty($tab_content_description)) : ?>
															<?php echo wp_kses_post($tab_content_description); ?>
														<?php endif; ?>
														
														<?php if (!empty($list_items)) : ?>
															<ul class="p-0 right_list">
																<?php foreach ($list_items as $list_item) : ?>
																	<?php $list_text = !empty($list_item['list_item_text']) ? $list_item['list_item_text'] : ''; ?>
																	<?php if (!empty($list_text)) : ?>
																		<li>
																			<span><?php echo $checkmark_svg; ?></span>
																			<p><?php echo wp_kses_post($list_text); ?></p>
																		</li>
																	<?php endif; ?>
																<?php endforeach; ?>
															</ul>
														<?php endif; ?>
														
														<?php if (!empty($primary_cta_text)) : ?>
															<div class="text-left">
																<a href="<?php echo esc_url($primary_cta_url); ?>" class="theme-btn bg-trans border_btnlight<?php echo $primary_cta_classes; ?>" <?php echo esc_attr($primary_cta_target); ?> <?php echo esc_attr($primary_cta_nofollow); ?>><?php echo esc_html($primary_cta_text); ?></a>
															</div>
														<?php endif; ?>
													</div>
													
													<?php if (!empty($properties)) : ?>
														<div class="content-inner-icons col-12">
															<ul>
																<?php foreach ($properties as $property) : ?>
																	<?php
																	$prop_icon_default = !empty($property['property_icon_default']['url']) ? $property['property_icon_default']['url'] : '';
																	$prop_icon_dark = !empty($property['property_icon_dark']['url']) ? $property['property_icon_dark']['url'] : $prop_icon_default;
																	$prop_icon_alt = !empty($property['property_icon_default']['alt']) ? $property['property_icon_default']['alt'] : '';
																	$prop_title = !empty($property['property_title']) ? $property['property_title'] : '';
																	?>
																	<?php if (!empty($prop_icon_default) || !empty($prop_title)) : ?>
																		<li>
																			<?php if (!empty($prop_icon_default)) : ?>
																				<img class="white_theme_img" src="<?php echo esc_url($prop_icon_default); ?>" alt="<?php echo esc_attr($prop_icon_alt); ?>">
																				<img class="black_theme_img" src="<?php echo esc_url($prop_icon_dark); ?>" alt="<?php echo esc_attr($prop_icon_alt); ?>">
																			<?php endif; ?>
																			<?php if (!empty($prop_title)) : ?>
																				<span><?php echo wp_kses_post($prop_title); ?></span>
																			<?php endif; ?>
																		</li>
																	<?php endif; ?>
																<?php endforeach; ?>
																
															</ul>
															<?php if (!empty($secondary_cta_text)) : ?>
																	<div class="text-left pt-4">
																		<a href="<?php echo esc_url($secondary_cta_url); ?>" class="theme-btn bg-trans border_btnlight<?php echo $secondary_cta_classes; ?>" <?php echo esc_attr($secondary_cta_target); ?> <?php echo esc_attr($secondary_cta_nofollow); ?>><?php echo esc_html($secondary_cta_text); ?></a>
																	</div>
																<?php endif; ?>
														</div>
													<?php endif; ?>
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
<?php
	}
} ?>