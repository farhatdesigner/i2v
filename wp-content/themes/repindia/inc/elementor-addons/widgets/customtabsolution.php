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

class customtabsolution extends Widget_Base
{
	public function get_name()
	{
		return 'customtabsolution';
	}
	public function get_title()
	{
		return 'Tab Solution';
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
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'mission_title_img',
			[
				'label' => esc_html__('Mission Title Icon Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$repeater->add_control(
			'main_title',
			[
				'label' => esc_html__('Box Title', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_para',
			[
				'label' => esc_html__('Box Description', 'repindia'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_img',
			[
				'label' => esc_html__('Mission Box Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$this->add_control(
			'box_list',
			[
				'label' => esc_html__('Box List', 'repindia'),
				'type' => \Elementor\Controls_Manager::REPEATER,
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

		<div class="customtabsolution">


			<section class="microspace-inside">
				<div class="custom-container">


					<div class="col-lg-7">
						<h3 class="main_title quote">
							Integrated solutions to secure and streamline every facet of your operations
						</h3>
					</div>






					<div class="contentWrapper">
						<div class="tabsWrapper">
							<ul class="tabsautoscroll">
								<li data-id="content0" class="tracking-wide active">i2V’s VMS</li>
								<li data-id="content1">AI based video analytics / VCA</li>
								<li data-id="content2">Command and control (ICCC)</li>
								<li data-id="content3">CMS</li>
								<li data-id="content4">ITMS / ITS</li>
								<li data-id="content5">ANPR / LPR</li>
								<li data-id="content6">VIDS</li>
								<li data-id="content7">FRS</li>
							</ul>
						</div>
						<div class="container-marketing">
							<div class="row overflow-hidden">
								<div class="tabContent position-relative" id="tabs-content">
									<div class="content0 tabdiv  active-tabcontent">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo get_template_directory_uri(); ?>/assets/images/tab-image.png" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">i2V’s video management system (VMS)</h4>
												<p>i2V’s enterprise-grade Video Management System is a powerful IP-based solution engineered for large-scale, mission-critical environments. It offers seamless integration with unlimited cameras, servers, and users—delivering real-time monitoring, playback, and analytics from a single, unified platform.</p>
												<p>Whether you're managing a city-wide network or a multi-site enterprise, i2V’s VMS ensures secure, scalable surveillance with complete operational control.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn  bg-trans">Learn i2V VMS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo get_template_directory_uri(); ?>/assets/images/tabs/icons/client-icon.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn  bg-trans">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content1 tabdiv">
										2
									</div>
									<div class="content2 tabdiv">
										3
									</div>
									<div class="content3 tabdiv">
										4
									</div>
									<div class="content4 tabdiv">
										5
									</div>
									<div class="content5 tabdiv">
										5
									</div>
									<div class="content6 tabdiv">
										5
									</div>
									<div class="content7 tabdiv">
										5
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