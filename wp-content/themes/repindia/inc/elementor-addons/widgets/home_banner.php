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
				'label' => 'Banner Slides',
			]
		);

		$repeater = new \Elementor\Repeater();

		// Desktop Background Type
		$repeater->add_control(
			'desktop_bg_type',
			[
				'label' => esc_html__('Desktop Background Type', 'repindia'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Video', 'repindia'),
				'label_off' => esc_html__('Image', 'repindia'),
				'return_value' => 'video',
				'default' => '',
			]
		);

		// Desktop Default Background Image
		$repeater->add_control(
			'desktop_bg_image',
			[
				'label' => esc_html__('Desktop Default Background Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'desktop_bg_type!' => 'video',
				],
			]
		);

		// Desktop Dark Theme Background Image
		$repeater->add_control(
			'desktop_bg_image_dark',
			[
				'label' => esc_html__('Desktop Dark Theme Background Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'condition' => [
					'desktop_bg_type!' => 'video',
				],
			]
		);

		// Desktop Default YouTube Video ID
		$repeater->add_control(
			'desktop_bg_video_id',
			[
				'label' => esc_html__('Desktop Default YouTube Video ID', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('e.g., jNQXAC9IVRw', 'repindia'),
				'description' => esc_html__('Enter only the video ID, not the full URL', 'repindia'),
				'condition' => [
					'desktop_bg_type' => 'video',
				],
			]
		);

		// Desktop Dark Theme YouTube Video ID
		$repeater->add_control(
			'desktop_bg_video_id_dark',
			[
				'label' => esc_html__('Desktop Dark Theme YouTube Video ID', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('e.g., jNQXAC9IVRw', 'repindia'),
				'description' => esc_html__('Enter only the video ID, not the full URL', 'repindia'),
				'condition' => [
					'desktop_bg_type' => 'video',
				],
			]
		);

		// Mobile Background Type
		$repeater->add_control(
			'mobile_bg_type',
			[
				'label' => esc_html__('Mobile Background Type', 'repindia'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Video', 'repindia'),
				'label_off' => esc_html__('Image', 'repindia'),
				'return_value' => 'video',
				'default' => '',
			]
		);

		// Mobile Default Background Image
		$repeater->add_control(
			'mobile_bg_image',
			[
				'label' => esc_html__('Mobile Default Background Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'description' => esc_html__('Leave empty to use desktop background', 'repindia'),
				'condition' => [
					'mobile_bg_type!' => 'video',
				],
			]
		);

		// Mobile Dark Theme Background Image
		$repeater->add_control(
			'mobile_bg_image_dark',
			[
				'label' => esc_html__('Mobile Dark Theme Background Image', 'repindia'),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'description' => esc_html__('Leave empty to use desktop background', 'repindia'),
				'condition' => [
					'mobile_bg_type!' => 'video',
				],
			]
		);

		// Mobile Default YouTube Video ID
		$repeater->add_control(
			'mobile_bg_video_id',
			[
				'label' => esc_html__('Mobile Default YouTube Video ID', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('e.g., jNQXAC9IVRw', 'repindia'),
				'description' => esc_html__('Enter only the video ID. Leave empty to use desktop background', 'repindia'),
				'condition' => [
					'mobile_bg_type' => 'video',
				],
			]
		);

		// Mobile Dark Theme YouTube Video ID
		$repeater->add_control(
			'mobile_bg_video_id_dark',
			[
				'label' => esc_html__('Mobile Dark Theme YouTube Video ID', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('e.g., jNQXAC9IVRw', 'repindia'),
				'description' => esc_html__('Enter only the video ID. Leave empty to use desktop background', 'repindia'),
				'condition' => [
					'mobile_bg_type' => 'video',
				],
			]
		);

		// Banner Title
		$repeater->add_control(
			'banner_title',
			[
				'label' => esc_html__('Banner Title', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		// Banner Description
		$repeater->add_control(
			'banner_description',
			[
				'label' => esc_html__('Banner Description', 'repindia'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
			]
		);

		// CTA One Text
		$repeater->add_control(
			'cta_one_text',
			[
				'label' => esc_html__('CTA One Text', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		// CTA One URL
		$repeater->add_control(
			'cta_one_url',
			[
				'label' => esc_html__('CTA One URL', 'repindia'),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);

		// CTA One Classes
		$repeater->add_control(
			'cta_one_classes',
			[
				'label' => esc_html__('CTA One Classes', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the CTA One link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		// CTA Two Text
		$repeater->add_control(
			'cta_two_text',
			[
				'label' => esc_html__('CTA Two Text', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		// CTA Two URL
		$repeater->add_control(
			'cta_two_url',
			[
				'label' => esc_html__('CTA Two URL', 'repindia'),
				'type' => Controls_Manager::URL,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);

		// CTA Two Classes
		$repeater->add_control(
			'cta_two_classes',
			[
				'label' => esc_html__('CTA Two Classes', 'repindia'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__('Add custom CSS classes for the CTA Two link (separate multiple classes with spaces)', 'repindia'),
				'label_block' => true,
			]
		);

		// Add Repeater Control
		$this->add_control(
			'banner_slides',
			[
				'label' => esc_html__('Banner Slides', 'repindia'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ banner_title }}}',
			]
		);
		
		$this->end_controls_section();

	}

	// Php Render
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('custom_class', 'basic');
		
		// Get banner slides from repeater
		$banner_slides = !empty($settings['banner_slides']) ? $settings['banner_slides'] : [];
		$is_single_slide = count($banner_slides) <= 1;
		
		// Helper function to generate YouTube embed URL from video ID
		$get_youtube_embed_url = function($video_id) {
			if (empty($video_id)) {
				return '';
			}
			// Clean video ID (remove any URL parts if accidentally included)
			$video_id = preg_replace('#^(?:https?://)?(?:www\.)?(?:youtube\.com/embed/|youtu\.be/|youtube\.com/watch\?v=)#', '', $video_id);
			$video_id = preg_replace('#[?&].*#', '', $video_id);
			
			// Construct YouTube embed URL with autoplay, mute, loop settings (matching existing format)
			return 'https://www.youtube.com/embed/' . esc_attr($video_id) . '?autoplay=1&mute=1&loop=1&playlist=' . esc_attr($video_id) . '&controls=0&showinfo=0&rel=0&iv_load_policy=3&start=0';
		};
		?>
		
		<div class="sectionshomebanner">
		<section class="hero-slider hero-style<?php echo $is_single_slide ? ' hero-single-slide' : ''; ?>">
      <div class="swiper-container hero-swiper-container" data-single-slide="<?php echo $is_single_slide ? '1' : '0'; ?>">
         <div class="swiper-wrapper">
            <?php if (!empty($banner_slides)) : ?>
               <?php foreach ($banner_slides as $slide) : ?>
                  <?php
                  // Get desktop background type
                  $desktop_bg_type = !empty($slide['desktop_bg_type']) && $slide['desktop_bg_type'] === 'video' ? 'video' : 'image';
                  
                  // Get desktop background data
                  $desktop_bg_image = !empty($slide['desktop_bg_image']['url']) ? $slide['desktop_bg_image']['url'] : '';
                  $desktop_bg_image_dark = !empty($slide['desktop_bg_image_dark']['url']) ? $slide['desktop_bg_image_dark']['url'] : $desktop_bg_image;
                  $desktop_bg_video_id = !empty($slide['desktop_bg_video_id']) ? $slide['desktop_bg_video_id'] : '';
                  $desktop_bg_video_id_dark = !empty($slide['desktop_bg_video_id_dark']) ? $slide['desktop_bg_video_id_dark'] : $desktop_bg_video_id;
                  
                  // Get mobile background type
                  $mobile_bg_type_setting = !empty($slide['mobile_bg_type']) && $slide['mobile_bg_type'] === 'video' ? 'video' : 'image';
                  
                  // Get mobile background data
                  $mobile_bg_image = !empty($slide['mobile_bg_image']['url']) ? $slide['mobile_bg_image']['url'] : '';
                  $mobile_bg_image_dark = !empty($slide['mobile_bg_image_dark']['url']) ? $slide['mobile_bg_image_dark']['url'] : '';
                  $mobile_bg_video_id = !empty($slide['mobile_bg_video_id']) ? $slide['mobile_bg_video_id'] : '';
                  $mobile_bg_video_id_dark = !empty($slide['mobile_bg_video_id_dark']) ? $slide['mobile_bg_video_id_dark'] : '';
                  
                  // Apply mobile fallback logic: if mobile background not provided, use desktop
                  $mobile_bg_type = $mobile_bg_type_setting;
                  if ($mobile_bg_type === 'image' && empty($mobile_bg_image)) {
                     // Fallback to desktop image
                     $mobile_bg_image = $desktop_bg_image;
                     $mobile_bg_image_dark = !empty($mobile_bg_image_dark) ? $mobile_bg_image_dark : $desktop_bg_image_dark;
                     $mobile_bg_type = $desktop_bg_type; // Use desktop type for fallback
                  }
                  if ($mobile_bg_type === 'video' && empty($mobile_bg_video_id)) {
                     // Fallback to desktop video
                     $mobile_bg_video_id = $desktop_bg_video_id;
                     $mobile_bg_video_id_dark = !empty($mobile_bg_video_id_dark) ? $mobile_bg_video_id_dark : $desktop_bg_video_id_dark;
                     $mobile_bg_type = $desktop_bg_type; // Use desktop type for fallback
                  }

                  // Mobile dark theme fallback when mobile light image is set
                  if ($mobile_bg_type === 'image' && !empty($mobile_bg_image) && empty($mobile_bg_image_dark)) {
                     $mobile_bg_image_dark = $desktop_bg_image_dark;
                  }
                  if ($mobile_bg_type === 'video' && !empty($mobile_bg_video_id) && empty($mobile_bg_video_id_dark)) {
                     $mobile_bg_video_id_dark = $desktop_bg_video_id_dark;
                  }

                  // Check if slide has its own mobile background (before fallback)
                  $has_separate_mobile = false;
                  if ($mobile_bg_type_setting === 'image' && !empty($slide['mobile_bg_image']['url'])) {
                     $has_separate_mobile = true;
                  } elseif ($mobile_bg_type_setting === 'video' && !empty($slide['mobile_bg_video_id'])) {
                     $has_separate_mobile = true;
                  }
                  
                  // Determine if slide uses image or video (for CSS class) - use desktop as primary
                  $slide_class = ($desktop_bg_type === 'image' && !empty($desktop_bg_image)) ? 'slide-bg-image' : '';
                  if ($has_separate_mobile) {
                     $slide_class .= ' has-mobile-bg';
                  }
                  
                  // Get content data
                  $banner_title = !empty($slide['banner_title']) ? $slide['banner_title'] : '';
                  $banner_description = !empty($slide['banner_description']) ? $slide['banner_description'] : '';
                  $cta_one_text = !empty($slide['cta_one_text']) ? $slide['cta_one_text'] : '';
                  $cta_one_url = !empty($slide['cta_one_url']['url']) ? $slide['cta_one_url']['url'] : '#';
                  $cta_one_target = !empty($slide['cta_one_url']['is_external']) ? 'target="_blank"' : '';
                  $cta_one_nofollow = !empty($slide['cta_one_url']['nofollow']) ? 'rel="nofollow"' : '';
                  $cta_one_classes = !empty($slide['cta_one_classes']) ? esc_attr($slide['cta_one_classes']) : '';
                  $cta_one_class_attr = !empty($cta_one_classes) ? ' ' . $cta_one_classes : '';
                  $cta_two_text = !empty($slide['cta_two_text']) ? $slide['cta_two_text'] : '';
                  $cta_two_url = !empty($slide['cta_two_url']['url']) ? $slide['cta_two_url']['url'] : '#';
                  $cta_two_target = !empty($slide['cta_two_url']['is_external']) ? 'target="_blank"' : '';
                  $cta_two_nofollow = !empty($slide['cta_two_url']['nofollow']) ? 'rel="nofollow"' : '';
                  $cta_two_classes = !empty($slide['cta_two_classes']) ? esc_attr($slide['cta_two_classes']) : '';
                  $cta_two_class_attr = !empty($cta_two_classes) ? ' ' . $cta_two_classes : '';
                  ?>
                  
                  <div class="swiper-slide">
                     <div class="slide-inner hero-slide-inner <?php echo esc_attr($slide_class); ?>">
                        <?php
                        // Render desktop backgrounds (default + dark theme)
                        if ($desktop_bg_type === 'image' && !empty($desktop_bg_image)) :
                           // Desktop Image Backgrounds
                           ?>
                           <div class="slide-bg-white white-theme-img" style="background-image: url('<?php echo esc_url($desktop_bg_image); ?>');"></div>
                           <?php if (!empty($desktop_bg_image_dark)) : ?>
                              <div class="slide-bg-dark black-theme-img" style="background-image: url('<?php echo esc_url($desktop_bg_image_dark); ?>');"></div>
                           <?php endif; ?>
                           <?php
                        elseif ($desktop_bg_type === 'video' && !empty($desktop_bg_video_id)) :
                           // Desktop Video Backgrounds
                           $desktop_video_url = $get_youtube_embed_url($desktop_bg_video_id);
                           $desktop_video_url_dark = $get_youtube_embed_url($desktop_bg_video_id_dark);
                           ?>
                           <?php if (!empty($desktop_video_url)) : ?>
                              <div class="slide-video-white white-theme-img">
                                 <iframe src="<?php echo esc_url($desktop_video_url); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                              </div>
                           <?php endif; ?>
                           <?php if (!empty($desktop_video_url_dark)) : ?>
                              <div class="slide-video-dark black-theme-img">
                                 <iframe src="<?php echo esc_url($desktop_video_url_dark); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                              </div>
                           <?php endif; ?>
                           <?php
                        endif;
                        
                        // Render mobile backgrounds (default + dark theme) - only if different from desktop
                        if ($has_separate_mobile && $mobile_bg_type === 'image' && !empty($mobile_bg_image)) :
                           // Mobile Image Backgrounds (separate from desktop)
                           ?>
                           <div class="slide-bg-white white-theme-img mobile-bg" style="background-image: url('<?php echo esc_url($mobile_bg_image); ?>');"></div>
                           <?php if (!empty($mobile_bg_image_dark)) : ?>
                              <div class="slide-bg-dark black-theme-img mobile-bg" style="background-image: url('<?php echo esc_url($mobile_bg_image_dark); ?>');"></div>
                           <?php endif; ?>
                           <?php
                        elseif ($has_separate_mobile && $mobile_bg_type === 'video' && !empty($mobile_bg_video_id)) :
                           // Mobile Video Backgrounds (separate from desktop)
                           $mobile_video_url = $get_youtube_embed_url($mobile_bg_video_id);
                           $mobile_video_url_dark = $get_youtube_embed_url($mobile_bg_video_id_dark);
                           ?>
                           <?php if (!empty($mobile_video_url)) : ?>
                              <div class="slide-video-white white-theme-img mobile-bg">
                                 <iframe src="<?php echo esc_url($mobile_video_url); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                              </div>
                           <?php endif; ?>
                           <?php if (!empty($mobile_video_url_dark)) : ?>
                              <div class="slide-video-dark black-theme-img mobile-bg">
                                 <iframe src="<?php echo esc_url($mobile_video_url_dark); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                              </div>
                           <?php endif; ?>
                           <?php
                        endif;
                        ?>
                        
                        <div class="text-container">
                           <?php if (!empty($banner_title)) : ?>
                              <div data-swiper-parallax="300" class="slide-title">
                                 <h2><?php echo wp_kses_post($banner_title); ?></h2>
                              </div>
                           <?php endif; ?>
                           
                           <?php if (!empty($banner_description)) : ?>
                              <div data-swiper-parallax="400" class="slide-text">
                              <p><?php echo wp_kses_post($banner_description); ?></p>
                              </div>
                           <?php endif; ?>
                           
                           <?php if (!empty($cta_one_text) || !empty($cta_two_text)) : ?>
                              <div class="clearfix"></div>
                              <div data-swiper-parallax="500" class="slide-btns">
                                 <?php if (!empty($cta_one_text)) : ?>
                                    <a href="<?php echo esc_url($cta_one_url); ?>" class="theme-btn xl-btn<?php echo $cta_one_class_attr; ?>" <?php echo esc_attr($cta_one_target); ?> <?php echo esc_attr($cta_one_nofollow); ?>><?php echo esc_html($cta_one_text); ?></a>
                                 <?php endif; ?>
                                 <?php if (!empty($cta_two_text)) : ?>
                                    <a href="<?php echo esc_url($cta_two_url); ?>" class="theme-btn xl-btn grey-btn<?php echo $cta_two_class_attr; ?>" <?php echo esc_attr($cta_two_target); ?> <?php echo esc_attr($cta_two_nofollow); ?>><?php echo esc_html($cta_two_text); ?></a>
                                 <?php endif; ?>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>
                     <!-- end slide-inner -->
                  </div>
                  <!-- end swiper-slide -->
               <?php endforeach; ?>
            <?php endif; ?>
         </div>
         <!-- end swiper-wrapper -->

         <?php if (!$is_single_slide) : ?>
         <!-- swiper controls (hidden when single slide) -->
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
         <?php endif; ?>
      </div>
   </section>
   <!-- end of hero slider -->
			
		</div>
	<?php
	}
} ?>