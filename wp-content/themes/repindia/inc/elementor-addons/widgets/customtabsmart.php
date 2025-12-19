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
				'label' => 'Settings',
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'mission_title_img',
			[
				'label' => esc_html__('Mission Title Icon Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$repeater->add_control(
			'main_title',
			[
				'label' => esc_html__('Box Title', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_para',
			[
				'label' => esc_html__('Box Description', 'repindia'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_img',
			[
				'label' => esc_html__('Mission Box Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$this->add_control(
			'box_list',
			[
				'label' => esc_html__('Box List', 'repindia'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'main_title' => '',
					],
				],
				'title_field' => '{{{ main_title }}}',
			]
		);
		$this->end_controls_section();
	}

	// Php Render
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('custom_class', 'basic'); ?>

		<div class="customtabsmart">
			<section class="smart-microspace-inside">
				<div class="custom-container">
					<div class="col-lg-8 col-xxl-7">
						<h3 class="smart-main_title quote">Smart city solution ecosystem — connecting
							technology, people, and cities with i2V</h3>
					</div>
					<div class="smart-contentWrapper">
						<div class="smart-filter-menu smart-tabsWrapper">
							<label class="smart-dropdown-label">Solutions</label>
							<span class="smart-select-brand">i2V's VMS</span>
							<ul class="smart-tabsautoscroll smart-tabs-list" id="smartTab">
								<li data-id="content0" class="tracking-wide active smart-tab-item">
									<a class="smart-tab-link" href="#content0">i2V VMS</a>
								</li>
								<li data-id="content1" class="smart-tab-item">
									<a class="smart-tab-link" href="#content1">AI based video analytics / VCA</a>
								</li>
								<li data-id="content2" class="smart-tab-item">
									<a class="smart-tab-link" href="#content2">Command and control (ICCC/PSCM)</a>
								</li>
								<li data-id="content3" class="smart-tab-item">
									<a class="smart-tab-link" href="#content3">CMS</a>
								</li>
								<li data-id="content4" class="smart-tab-item">
									<a class="smart-tab-link" href="#content4">ITMS / ITS</a>
								</li>
								<li data-id="content5" class="smart-tab-item">
									<a class="smart-tab-link" href="#content5">ANPR / LPR</a>
								</li>
								<li data-id="content6" class="smart-tab-item">
									<a class="smart-tab-link" href="#content6">VIDS</a>
								</li>
								<li data-id="content7" class="smart-tab-item">
									<a class="smart-tab-link" href="#content7">FRS</a>
								</li>
							</ul>
						</div>
						<div class="smart-container-marketing">
							<div class="row overflow-hidden">
								<div class="smart-tabContent position-relative" id="smart-tabs-content">
									<div class="content0 smart-tabdiv  smart-active-tabcontent">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content1 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Intelligence behind every camera</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content2 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">The nerve center of urban safety</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content3 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content4 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content5 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content6 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>
									<div class="content7 smart-tabdiv">
										<div class="smart-content-inner row g-0">
											<div class="smart-content-inner-image col-lg-7">
												<img class="img-fluid rounded-4"
													src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp"
													alt="i2V’s VMS">
											</div>
											<div class="smart-content-inner-text col-lg-5">
												<h4 class="smart-sub_title">Centralized visibility with i2V VMS</h4>
												<p>Our scalable Video Management System offers real-time monitoring and playback
													across all connected cameras, crucial for City-Wide Surveillance, Emergency
													Response, and coordinating across multiple zones.</p>
												<p>It also supports Mobile View + Edge Recording for extended reach.</p>
												<div class="btn-sec_gap">
													<a class="theme-btn-white  border-btn-grey" href="#">Request a VMS demo</a>
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn more about centralized VMS</a>
												</div>
											</div>

										</div>
									</div>

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