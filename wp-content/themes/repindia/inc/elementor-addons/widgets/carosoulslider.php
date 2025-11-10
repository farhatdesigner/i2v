<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (! defined('ABSPATH')) {
    exit;
}

class Carosoulslider extends Widget_Base
{

    public function get_name()
    {
        return 'carosoulslider';
    }

    public function get_title()
    {
        return esc_html__('Carousel Slider', 'repindia');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Slides', 'repindia'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slide_title',
            [
                'label'       => esc_html__('Title', 'repindia'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_content',
            [
                'label'       => esc_html__('Content', 'repindia'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_author',
            [
                'label'       => esc_html__('Author', 'repindia'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_image',
            [
                'label'   => esc_html__('Image', 'repindia'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => esc_html__('Slides', 'repindia'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [],
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slides   = $settings['slides'];

        if (empty($slides)) {
            return;
        }
?>

        <!-- Swiper -->
        <div class="custom-container">
            <div class="swiper testimonialSwiper">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-profile">
                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Ellipse-9.svg" alt="profile" />
                            </div>
                            <div class="testimonial-content">
                                <p>“We needed a surveillance platform that could handle complex deployments across departments, integrate with traffic systems, and remain responsive 24/7. i2V delivered.”</p>
                                <span>— Deputy Commissioner, Urban Traffic & Transport Authority</span>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-profile">
                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Ellipse-11.svg" alt="profile" />
                            </div>
                            <div class="testimonial-content">
                                <p>“i2V has helped us manage thousands of live feeds across multiple control centers with zero downtime. The system is reliable, easy to scale, and integrates well with our existing infrastructure.”</p>
                                <span>— City Surveillance Command Head, Major Smart City Project, India</span>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-profile">
                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Ellipse-9.svg" alt="profile" />
                            </div>
                            <div class="testimonial-content">
                                <p>“We needed a surveillance platform that could handle complex deployments across departments, integrate with traffic systems, and remain responsive 24/7. i2V delivered.”</p>
                                <span>— Deputy Commissioner, Urban Traffic & Transport Authority</span>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-profile">
                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Ellipse-11.svg" alt="profile" />
                            </div>
                            <div class="testimonial-content">
                                <p>“i2V has helped us manage thousands of live feeds across multiple control centers with zero downtime. The system is reliable, easy to scale, and integrates well with our existing infrastructure.”</p>
                                <span>— City Surveillance Command Head, Major Smart City Project, India</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination text-center"></div>
            </div>
        </div>
<?php
    }
}
