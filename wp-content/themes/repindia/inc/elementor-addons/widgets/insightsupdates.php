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

class insightsupdates extends Widget_Base
{
   public function get_name()
   {
      return 'insightsupdates';
   }
   public function get_title()
   {
      return 'Blog Insight Updates';
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

      <div class="sectionsinsightsupdates grey-light">




         <section class="microspace-custom_outside custom-container">
            <div class="mx-auto">


               <div class="col-lg-12 text-center">
                  <h3 class="main_title quote">
                     Insights & Updates
                  </h3>
                  <div class="text-left">
                     <p>Explore the latest from i2V — blogs, press releases, webinars, events, and industry insights.</p>
                  </div>
               </div>


               <div class="insights-updates">
                  <div class="row">
                     <div class="col-xl-7">
                        <div class="insights-updates-item">
                           <div class="insights-updates-item-image">
                              <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/i2v-enhances-security-center-saa-s-with-the-addition-of-intrusion-security-and-loitering-management.webp" alt="insights-updates-item">
                           </div>
                           <div class="insights-updates-item-text_left">
                              <ul class="p-0 insights-updates-item-text_left-list">
                                 <li>
                                    <a href="#">Intrusion Detection</a>
                                    <a href="#">Security Management</a>
                                    <a href="#">Loitering Analytics</a>
                                 </li>
                              </ul>
                              <h4 class="brand_heading_color">i2V enhances security center SaaS with the addition of intrusion, security and loitering management</h4>
                              <div class="text-features">
                                 <p>These features enhance real-time monitoring, enabling businesses to detect and respond to threats proactively. Intrusion detection ensures unauthorized access is flagged instantly, while security management centralizes control over multiple security layers. Loitering analytics use AI to identify suspicious behavior, helping prevent potential security risks. With seamless integration and automation, i2V’s latest enhancements empower organizations to maintain a safer environment with improved efficiency. This upgrade reinforces i2V’s commitment to delivering cutting-edge, AI-powered security solutions for smarter, proactive surveillance management.</p>
                              </div>
                              <div class="date-author-txt">
                                 <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Admin</span></p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-5">
                        <div class="lisitng-inner">
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Physical-Security-Trends-for-2025.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>Physical Security Trends for 2025</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Amod Kudesia</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/4-tips-for-managing-access-rights-in-a-hybrid-work-environment.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>4 Tips for Managing Access Rights in a Hybrid Work Environment</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Chintamani Pavithran</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/A-Closer-Look-at-Physical-Security-System-Vulnerabilities.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>A Closer Look at Physical Security System Vulnerabilities</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Admin</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/what-you-need-to-know-about-data-privacy.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>What You Need to Know About Data Privacy</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Dattatreya Saidullah</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/the-importance-of-encryption-in-security-systems.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>The Importance of Encryption in Security Systems</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Atharvan Maruti</span></p>
                                 </div>
                              </div>
                           </div>
                           <div class="d-flex align-items-center gap-4">
                              <div class="insights-updates-item-small-icon">
                                 <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/a-journey-to-hybrid-cloud.webp" alt="blog">
                              </div>
                              <div class="insights-updates-item-text">
                                 <h5>The Importance of Encryption in Security Systems</h5>
                                 <div class="date-author-txt">
                                    <p><span>Jan 30, 2022</span> <span><small><img src="<?php echo get_template_directory_uri(); ?>/assets/images/update/avtar.svg" alt="tertiary"></small> Atharvan Maruti</span></p>
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