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
					<div class="col-lg-8 col-xxl-7">
						<h3 class="main_title quote">Integrated solutions to secure and streamline every facet of your operations </h3>
					</div>
					<div class="contentWrapper">
						<div class="tabsWrapper">
							<ul class="tabsautoscroll">
								<li data-id="content0" class="tracking-wide active">i2V’s VMS</li>
								<li data-id="content1">AI based video analytics / VCA</li>
								<li data-id="content2">Command and control (ICCC/PSCM)</li>
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
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/thumbnail.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">i2V’s video management system (VMS)</h4>
												<p>i2V’s enterprise-grade Video Management System is a powerful IP-based solution engineered for large-scale, mission-critical environments. It offers seamless integration with unlimited cameras, servers, and users—delivering real-time monitoring, playback, and analytics from a single, unified platform.</p>
												<p>Whether you're managing a city-wide network or a multi-site enterprise, i2V’s VMS ensures secure, scalable surveillance with complete operational control.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Manage more cameras with less hardware, cutting costs and energy.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Run seamlessly on both Windows and Linux for flexibility.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Real-time monitoring with smart AI analytics and fewer false alerts.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Built for heavy workloads and mission-critical deployments.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Connect with third-party NVRs without replacing existing systems.</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg></span>
														<p>Simple interface to manage cameras, alerts, and playback.</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V VMS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon-3.svg" alt="i2V’s VMS">
														<span>Configuration Client</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/live-view-and-playback-client.svg" alt="i2V’s VMS">
														<span>Live View and Playback Client</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/e-map-client.svg" alt="i2V’s VMS">
														<span>eMap </br> Client</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon.svg" alt="i2V’s VMS">
														<span>Auto PTZ </br> tracking</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/playback-client.svg" alt="i2V’s VMS">
														<span>Playback </br> Client</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon-1.svg" alt="i2V’s VMS">
														<span>Recordings and Storage</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/alarm-management.svg" alt="i2V’s VMS">
														<span>Alarm management</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon-2.svg" alt="i2V’s VMS">
														<span>Multi monitoring and video wall</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content1 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-1.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">AI-Powered video analytics for next-gen surveillance</h4>
												<p>i2V’s AI-powered video analytics transforms traditional surveillance into an intelligent system that enables real-time detection, automated alerts, and deep insights—ideal for smart cities, transportation, and large-scale enterprise deployments with unlimited cameras and users.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Scalable architecture for unlimited devices</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Edge and server-side AI processing</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Smart search and forensic analysis</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Custom rule engine for event-based automation</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Integration with third-party systems</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Failover, redundancy and health monitoring</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V video analytics solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/REAL-T1.svg" alt="i2V’s VMS">
														<span>Real-time object detection and tracking</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/FACE-R1.svg" alt="i2V’s VMS">
														<span>Face recognition with blacklist matching</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/LICENS1.svg" alt="i2V’s VMS">
														<span>License plate recognition (ANPR)</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/INTRUS1.svg" alt="i2V’s VMS">
														<span>Intrusion and perimeter violation alerts</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/ABANDO1.svg" alt="i2V’s VMS">
														<span>Abandoned or missing object detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/CROWD-1.svg" alt="i2V’s VMS">
														<span>Crowd density and queue management</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/VEHICL1.svg" alt="i2V’s VMS">
														<span>Vehicle and people counting</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/TAMPER1.svg" alt="i2V’s VMS">
														<span>Tamper and camera sabotage detection</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content2 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-3.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">Empowering public safety through integrated command and control</h4>
												<p>i2V’s Integrated Command Center offers a unified platform to monitor, manage, and respond to events across cities. It consolidates surveillance, emergency response, traffic, and civic operations into one intelligent, scalable, real-time control system.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Scalable for multi-city or statewide deployments</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Cross-platform integration</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Role-based access control</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Command escalation workflows</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Automated alerts and triggers</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Health monitoring of connected systems</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V ICCC solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/GIS-AN1.svg" alt="i2V’s VMS">
														<span>GIS and map integration</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/CUSTOM1.svg" alt="i2V’s VMS">
														<span>Custom SOP engine</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/MULTI-1.svg" alt="i2V’s VMS">
														<span>Multi-channel alerts</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/INCIDE1.svg" alt="i2V’s VMS">
														<span>Incident escalation matrix</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/ALARM-1.svg" alt="i2V’s VMS">
														<span>Alarm video verification</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/MASSIV1.svg" alt="i2V’s VMS">
														<span>Massive site support</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/OPEN-D1.svg" alt="i2V’s VMS">
														<span>Open device compatibility</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/CENTRA1.svg" alt="i2V’s VMS">
														<span>Central monitoring views</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content3 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-6.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">Centralized monitoring system for multi-site surveillance</h4>
												<p>i2V Central Monitoring System allows organizations to monitor multiple branches or sites from a single platform, enabling real-time video, alerts, health checks, and evidence review to ensure security, compliance, and operational efficiency.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Scalable to hundreds of sites</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Integrated with alarms and analytics</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Audit trail and reports</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Low-bandwidth streaming</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>GPS and map views</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Customizable notification methods</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V CMS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/multi-site-monitoring.svg" alt="i2V’s VMS">
														<span>Multi-site monitoring</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/smart-alert-handling.svg" alt="i2V’s VMS">
														<span>Smart alert handling</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/event-based-video-popup.svg" alt="i2V’s VMS">
														<span>Event-based video popup</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/health-status-monitoring.svg" alt="i2V’s VMS">
														<span>Health status monitoring</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video-evidence-retrieval.svg" alt="i2V’s VMS">
														<span>Video evidence retrieval</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/escalation-workflows.svg" alt="i2V’s VMS">
														<span>Escalation workflows</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/user-role-management.svg" alt="i2V’s VMS">
														<span>User role management</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/unified-dashboard-view.svg" alt="i2V’s VMS">
														<span>Unified dashboard view</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content4 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">End-to-end intelligent traffic control solution</h4>
												<p>i2V Intelligent Traffic System uses AI to monitor, analyze, and enforce traffic rules in real time. From red-light violations to speed monitoring, it improves road safety, traffic flow, and incident response through automation and video analytics.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Integrated enforcement backend</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Works in all light/weather</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Map and GPS overlays</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Centralized monitoring hub</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Auto alert and ticketing</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Compatible with existing infrastructure</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V ITMS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/red-light-violation-detection-rlvd.svg" alt="i2V’s VMS">
														<span>Red light violation detection (RLVD)</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/speed-violation-detection.svg" alt="i2V’s VMS">
														<span>Speed violation detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/number-plate-recognition.svg" alt="i2V’s VMS">
														<span>Number plate recognition</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/lane-discipline-monitoring.svg" alt="i2V’s VMS">
														<span>Lane discipline monitoring</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.svg" alt="i2V’s VMS">
														<span>No helmet detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/triple-riding-detection.svg" alt="i2V’s VMS">
														<span>Triple riding detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/real-time-traffic-analytics.svg" alt="i2V’s VMS">
														<span>Real-time traffic analytics</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/violation-evidence-dashboard.svg" alt="i2V’s VMS">
														<span>Violation evidence dashboard</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content5 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-2.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">Advanced ANPR system for real-time detection and logging</h4>
												<p>i2V’s ANPR solution automatically detects and logs vehicle license plates in real time, enabling enforcement, access control, and vehicle tracking. It works seamlessly with IP cameras, analytics, and back-end systems for reliable identification and reporting.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Seamless integration with ITS systems</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Access control automation</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Edge and server deployment</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Reporting and evidence generation</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Low bandwidth optimization</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Multi-camera coordination</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V ANPR solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/real-time-plate-detection.svg" alt="i2V’s VMS">
														<span>Real-time plate detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/high-accuracy-recognition.svg" alt="i2V’s VMS">
														<span>High-accuracy recognition</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/ip-and-analog-support.svg" alt="i2V’s VMS">
														<span>IP and analog support</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/centralized-number-plate-logging.svg" alt="i2V’s VMS">
														<span>Centralized number plate logging</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/watchlist-and-whitelist-matching.svg" alt="i2V’s VMS">
														<span>Watchlist and whitelist matching</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/smart-search-and-filtering.svg" alt="i2V’s VMS">
														<span>Smart search and filtering</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/violation-based-triggers.svg" alt="i2V’s VMS">
														<span>Violation-based triggers</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/multi-region-plate-support.svg" alt="i2V’s VMS">
														<span>Multi-region plate support</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content6 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-4.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">Automated video-based incident alerting and response platform</h4>
												<p>i2V’s Video Incident Detection System (VIDS) uses AI to monitor highways, tunnels, and expressways for real-time incidents like stopped vehicles, wrong-way driving, and smoke—enabling faster response, reduced accidents, and improved public safety.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Optimized for tunnels and highways</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Continuous 24x7 automated monitoring</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Instant alerts to control rooms</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Multi-level incident escalation</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Unified video analytics engine</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Rapid response coordination</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V VIDS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/stopped-vehicle-detection.svg" alt="i2V’s VMS">
														<span>Stopped vehicle detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/wrong-direction-detection.svg" alt="i2V’s VMS">
														<span>Wrong direction detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/smoke-and-fire-detection.svg" alt="i2V’s VMS">
														<span>Smoke and fire detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/slow-traffic-alerting.svg" alt="i2V’s VMS">
														<span>Slow traffic </br> alerting</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/congestion-traffic-alerting.svg" alt="i2V’s VMS">
														<span>Congestion traffic alerting</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/speed-variation-detection.svg" alt="i2V’s VMS">
														<span>Speed variation detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/24x7-automated-monitoring.svg" alt="i2V’s VMS">
														<span>24x7 automated monitoring</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/visual-and-audio-alarms.svg" alt="i2V’s VMS">
														<span>Visual and audio alarms</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
											</div>
										</div>
									</div>
									<div class="content7 tabdiv">
										<div class="content-inner row">
											<div class="content-inner-image col-lg-6">
												<img class="img-fluid rounded-4" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/image-5.webp" alt="i2V’s VMS">
											</div>
											<div class="content-inner-text col-lg-6">
												<h4 class="sub_title">Real-time face recognition system for surveillance, access, identity verification and more</h4>
												<p>i2V’s face recognition system detects and identifies faces in real time from live camera feeds. It supports access control, watchlist alerts, identity matching, and analytics with high accuracy, even in varied lighting and crowded scenes.</p>
												<ul class="p-0 right_list">
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>High-accuracy recognition in real-world conditions</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Supports access, attendance, and security use cases</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Role-based system access control</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Face data privacy and encryption</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Integration with existing systems</p>
													</li>
													<li>
														<span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" />
															</svg></span>
														<p>Scalable for multi-site deployment</p>
													</li>
												</ul>
												<div class="text-left">
													<a href="#" class="theme-btn bg-trans border_btnlight">Learn i2V FRS solutions</a>
												</div>
											</div>
											<div class="content-inner-icons col-12">
												<ul>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/real-time-face-detection.svg" alt="i2V’s VMS">
														<span>Real-time face detection</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/watchlist-based-alerting.svg" alt="i2V’s VMS">
														<span>Watchlist-based alerting</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/multiple-face-matching.svg" alt="i2V’s VMS">
														<span>Multiple face matching</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/access-control-integration.svg" alt="i2V’s VMS">
														<span>Access control integration</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/camera-agnostic-compatibility.svg" alt="i2V’s VMS">
														<span>Camera-agnostic compatibility</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/centralized-face-database.svg" alt="i2V’s VMS">
														<span>Centralized face database</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/real-time-face-logging.svg" alt="i2V’s VMS">
														<span>Real-time face logging</span>
													</li>
													<li>
														<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/cross-location-recognition.svg" alt="i2V’s VMS">
														<span>Cross-location recognition</span>
													</li>
													<div class="text-left pt-4">
														<a href="#" class="theme-btn bg-trans border_btnlight">View all features</a>
													</div>
												</ul>
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