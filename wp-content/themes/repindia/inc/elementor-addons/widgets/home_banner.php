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

class home_banner extends Widget_Base
{
	public function get_name()
	{
		return 'home_banner';
	}
	public function get_title()
	{
		return 'Home Banner';
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
		
		<div class="sectionshomebanner">
		<section class="hero-slider hero-style">
      <div class="swiper-container hero-swiper-container">
         <div class="swiper-wrapper">
            <div class="swiper-slide">
               <div class="slide-inner hero-slide-inner slide-bg-image" data-background="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/homepage-banner.webp">
                  <div class="text-container">
                     <div data-swiper-parallax="300" class="slide-title">
                        <h2>i2V Systems – Driving the future of smart, secure, and scalable video surveillance</h2>
                     </div>
                     <div data-swiper-parallax="400" class="slide-text">
                        <p>AI-powered video management, analytics, and security solutions tailored for enterprises, public sector agencies, and critical infrastructure.</p>
                     </div>
                     <div class="clearfix"></div>
                     <div data-swiper-parallax="500" class="slide-btns">
                        <a href="#" class="theme-btn  xl-btn">Speak to our experts</a>
                        <a href="#" class="theme-btn xl-btn grey-btn">Explore our AI-powered platform</a>
                     </div>
                  </div>
               </div>
               <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->

            <div class="swiper-slide">
               <div class="slide-inner hero-slide-inner slide-bg-image" data-background="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/homepage-banner2.webp">
                  <div class="text-container">
                     <div data-swiper-parallax="300" class="slide-title">
                        <h2>A smarter way to secure what matters—reliable, scalable, and ready for the future</h2>
                     </div>
                     <div data-swiper-parallax="400" class="slide-text">
                        <p>Purpose-built for high-stakes environments, our platform provides real-time insights and total operational visibility.</p>
                     </div>
                     <div class="clearfix"></div>
                     <div data-swiper-parallax="500" class="slide-btns">
                        <a href="#" class="theme-btn  xl-btn">Book a free demo</a>
                        <a href="#" class="theme-btn xl-btn grey-btn">See it in action</a>
                     </div>
                  </div>
               </div>
               <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->


            <div class="swiper-slide">
               <div class="slide-inner hero-slide-inner slide-bg-image" data-background="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/homepage-banner3.webp">
                  <div class="text-container">
                     <div data-swiper-parallax="300" class="slide-title">
                        <h2>End-to-end video security built for every industry</h2>
                     </div>
                     <div data-swiper-parallax="400" class="slide-text">
                        <p>From intelligent VMS to advanced AI analytics, i2V offers flexible, high-performance solutions for diverse sectors and use cases.</p>
                     </div>
                     <div class="clearfix"></div>
                     <div data-swiper-parallax="500" class="slide-btns">
                        <a href="#" class="theme-btn  xl-btn">Request a demo today</a>
                        <a href="#" class="theme-btn xl-btn grey-btn">Explore our solutions</a>
                     </div>
                  </div>
               </div>
               <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->


            <div class="swiper-slide">
               <div class="slide-inner hero-slide-inner slide-bg-image" data-background="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/homepage-banner4.webp">
                  <div class="text-container">
                     <div data-swiper-parallax="300" class="slide-title">
                        <h2>Trusted AI video surveillance for government & enterprise</h2>
                     </div>
                     <div data-swiper-parallax="400" class="slide-text">
                        <p>Secure, intelligent, and built for scale—i2V delivers mission-ready surveillance solutions for public and enterprise operations.</p>
                     </div>
                     <div class="clearfix"></div>
                     <div data-swiper-parallax="500" class="slide-btns">
                        <a href="#" class="theme-btn  xl-btn">Strengthen your security</a>
                        <a href="#" class="theme-btn xl-btn grey-btn">Explore AI in action</a>
                     </div>
                  </div>
               </div>
               <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->


            <div class="swiper-slide">
               <div class="slide-inner hero-slide-inner slide-bg-image" data-background="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/homepage-banner5.webp">
                  <div class="text-container">
                     <div data-swiper-parallax="300" class="slide-title">
                        <h2>Next-gen security & video management—designed for performance, built for tomorrow</h2>
                     </div>
                     <div data-swiper-parallax="400" class="slide-text">
                        <p>Empowering enterprises and governments with intelligent security, AI-driven video management, and scalable solutions for seamless surveillance and future-ready protection.</p>
                     </div>
                     <div class="clearfix"></div>
                     <div data-swiper-parallax="500" class="slide-btns">
                        <a href="#" class="theme-btn  xl-btn">Upgrade your security</a>
                        <a href="#" class="theme-btn xl-btn grey-btn">Explore i2V's solutions</a>
                     </div>
                  </div>
               </div>
               <!-- end slide-inner -->
            </div>
            <!-- end swiper-slide -->

         </div>
         <!-- end swiper-wrapper -->

         <!-- swipper controls -->
         <div class="swiper-pagination"></div>
         <div class="text-container position-relative">
            <div class="swiper-button-container position-absolute">
               <div class="swiper-button-next">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/right-arrow.svg" alt="Next">
               </div>
               <div class="swiper-button-prev">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/left-arrow.svg" alt="Prev">
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- end of hero slider -->
			
		</div>
	<?php
	}
} ?>