<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Testimonial_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'testimonial_slider';
    }

    public function get_title()
    {
        return 'Testimonial Slider';
    }

    public function get_icon()
    {
        return 'eicon-testimonial-carousel';
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
                'label' => 'Content Settings',
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Section Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Trusted by industry leaders',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__('Section Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Discover how organisations across sectors rely on i2V to secure operations, boost efficiency, and achieve peace of mind.',
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>


        <section class="ts_testimonial_section">
            <div class="custom-container">
                <div class="ts_testimonial_container">

                    <!-- Header -->
                    <div class="row ts_header_row g-0">
                        <div class="col-lg-6">
                            <h2 class="ts_main_title"><?php echo esc_html($settings['section_title']); ?></h2>
                        </div>
                        <div class="col-lg-6">
                            <p class="ts_header_description"><?php echo esc_html($settings['section_description']); ?></p>
                        </div>
                    </div>

                    <!-- Swiper Slider -->
                    <div class="ts_slider_wrapper">
                        <div class="swiper ts_swiper">
                            <div class="swiper-wrapper">

                                <!-- Slide 1 -->
                                <div class="swiper-slide">
                                    <div class="ts_slide_content">
                                        <div class="ts_testimonial_card">
                                            <div class="ts_testimonial_card_content">
                                                <div class="ts_company_logo">
                                                    <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                        alt="Hanwha Techwin">
                                                </div>
                                                <div class="ts_quote_icon">

                                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.32951 30.4779C4.45685 28.4559 3.33325 26.25 3.33325 22.5735C3.33325 16.1397 8.0149 10.4412 14.5692 7.5L16.2546 9.88971C10.0748 13.1985 8.76396 17.4265 8.38943 20.1838C9.32576 19.6324 10.6366 19.4485 11.9475 19.6324C15.3183 20 17.94 22.5735 17.94 26.0662C17.94 27.7206 17.1909 29.375 16.0673 30.6618C14.7565 31.9485 13.2583 32.5 11.3857 32.5C9.32576 32.5 7.4531 31.5809 6.32951 30.4779ZM25.0561 30.4779C23.1834 28.4559 22.0598 26.25 22.0598 22.5735C22.0598 16.1397 26.7415 10.4412 33.2958 7.5L34.9812 9.88971C28.8014 13.1985 27.4906 17.4265 27.116 20.1838C28.0524 19.6324 29.3632 19.4485 30.6741 19.6324C34.0449 20 36.6666 22.5735 36.6666 26.0662C36.6666 27.7206 35.9175 29.375 34.7939 30.6618C33.6703 31.9485 31.9849 32.5 30.1123 32.5C28.0524 32.5 26.1797 31.5809 25.0561 30.4779Z"
                                                            fill="#8793AF" />
                                                    </svg>

                                                </div>
                                                <p class="ts_testimonial_text">
                                                    With i2V's surveillance and analytics in place, we reduced unauthorized
                                                    access
                                                    incidents by over 60%. The system gives our team peace of mind knowing
                                                    high-risk
                                                    areas are always monitored.
                                                </p>
                                                <p class="ts_author">- Operations Head, Middle East Refinery</p>
                                            </div>
                                            <div class="ts_stats_row">
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">98.6% uptime</div>
                                                    <div class="ts_stat_label">Over 10 lakh violations processed monthly</div>
                                                </div>
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">40%</div>
                                                    <div class="ts_stat_label">Reduced violation-related incidents</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ts_media_card">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025//11/Image-2-2.webp"
                                                alt="Testimonial Video">
                                            <!-- Or use placeholder if no image -->
                                            <!-- <div class="ts_media_placeholder">Placeholder</div> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2 -->
                                <div class="swiper-slide">
                                    <div class="ts_slide_content">
                                        <div class="ts_testimonial_card">
                                            <div class="ts_testimonial_card_content">
                                                <div class="ts_company_logo">
                                                    <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                        alt="Hanwha Techwin">
                                                </div>
                                                <div class="ts_quote_icon">

                                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.32951 30.4779C4.45685 28.4559 3.33325 26.25 3.33325 22.5735C3.33325 16.1397 8.0149 10.4412 14.5692 7.5L16.2546 9.88971C10.0748 13.1985 8.76396 17.4265 8.38943 20.1838C9.32576 19.6324 10.6366 19.4485 11.9475 19.6324C15.3183 20 17.94 22.5735 17.94 26.0662C17.94 27.7206 17.1909 29.375 16.0673 30.6618C14.7565 31.9485 13.2583 32.5 11.3857 32.5C9.32576 32.5 7.4531 31.5809 6.32951 30.4779ZM25.0561 30.4779C23.1834 28.4559 22.0598 26.25 22.0598 22.5735C22.0598 16.1397 26.7415 10.4412 33.2958 7.5L34.9812 9.88971C28.8014 13.1985 27.4906 17.4265 27.116 20.1838C28.0524 19.6324 29.3632 19.4485 30.6741 19.6324C34.0449 20 36.6666 22.5735 36.6666 26.0662C36.6666 27.7206 35.9175 29.375 34.7939 30.6618C33.6703 31.9485 31.9849 32.5 30.1123 32.5C28.0524 32.5 26.1797 31.5809 25.0561 30.4779Z"
                                                            fill="#8793AF" />
                                                    </svg>

                                                </div>
                                                <p class="ts_testimonial_text">
                                                    With i2V's surveillance and analytics in place, we reduced unauthorized
                                                    access
                                                    incidents by over 60%. The system gives our team peace of mind knowing
                                                    high-risk
                                                    areas are always monitored.
                                                </p>
                                                <p class="ts_author">- Operations Head, Middle East Refinery</p>
                                            </div>
                                            <div class="ts_stats_row">
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">100% uptime</div>
                                                    <div class="ts_stat_label">Over 10 lakh violations processed monthly</div>
                                                </div>
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">40%</div>
                                                    <div class="ts_stat_label">Reduced violation-related incidents</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ts_media_card">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025//11/Image-2-2.webp"
                                                alt="Testimonial Video">
                                            <!-- Or use placeholder if no image -->
                                            <!-- <div class="ts_media_placeholder">Placeholder</div> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 3 -->
                                <div class="swiper-slide">
                                    <div class="ts_slide_content">
                                        <div class="ts_testimonial_card">
                                            <div class="ts_testimonial_card_content">
                                                <div class="ts_company_logo">
                                                    <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                        alt="Hanwha Techwin">
                                                </div>
                                                <div class="ts_quote_icon">

                                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.32951 30.4779C4.45685 28.4559 3.33325 26.25 3.33325 22.5735C3.33325 16.1397 8.0149 10.4412 14.5692 7.5L16.2546 9.88971C10.0748 13.1985 8.76396 17.4265 8.38943 20.1838C9.32576 19.6324 10.6366 19.4485 11.9475 19.6324C15.3183 20 17.94 22.5735 17.94 26.0662C17.94 27.7206 17.1909 29.375 16.0673 30.6618C14.7565 31.9485 13.2583 32.5 11.3857 32.5C9.32576 32.5 7.4531 31.5809 6.32951 30.4779ZM25.0561 30.4779C23.1834 28.4559 22.0598 26.25 22.0598 22.5735C22.0598 16.1397 26.7415 10.4412 33.2958 7.5L34.9812 9.88971C28.8014 13.1985 27.4906 17.4265 27.116 20.1838C28.0524 19.6324 29.3632 19.4485 30.6741 19.6324C34.0449 20 36.6666 22.5735 36.6666 26.0662C36.6666 27.7206 35.9175 29.375 34.7939 30.6618C33.6703 31.9485 31.9849 32.5 30.1123 32.5C28.0524 32.5 26.1797 31.5809 25.0561 30.4779Z"
                                                            fill="#8793AF" />
                                                    </svg>

                                                </div>
                                                <p class="ts_testimonial_text">
                                                    With i2V's surveillance and analytics in place, we reduced unauthorized
                                                    access
                                                    incidents by over 60%. The system gives our team peace of mind knowing
                                                    high-risk
                                                    areas are always monitored.
                                                </p>
                                                <p class="ts_author">- Operations Head, Middle East Refinery</p>
                                            </div>
                                            <div class="ts_stats_row">
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">98.6% uptime</div>
                                                    <div class="ts_stat_label">Over 10 lakh violations processed monthly</div>
                                                </div>
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">40%</div>
                                                    <div class="ts_stat_label">Reduced violation-related incidents</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ts_media_card">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025//11/Image-2-2.webp"
                                                alt="Testimonial Video">
                                            <!-- Or use placeholder if no image -->
                                            <!-- <div class="ts_media_placeholder">Placeholder</div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Navigation Arrows -->
                        <div class="ts_nav_arrow ts_nav_prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.0079 6.99145C13.4418 7.42537 13.4418 8.12889 13.0079 8.5628L9.34911 12.2216L20 12.2216C20.6136 12.2216 21.1111 12.719 21.1111 13.3327C21.1111 13.9463 20.6136 14.4438 20 14.4438L9.34911 14.4438L13.0079 18.1026C13.4418 18.5365 13.4418 19.24 13.0079 19.6739C12.574 20.1078 11.8704 20.1078 11.4365 19.6739L5.88098 14.1184C5.67261 13.91 5.55554 13.6274 5.55554 13.3327C5.55554 13.038 5.67261 12.7554 5.88098 12.547L11.4365 6.99145C11.8705 6.55754 12.574 6.55754 13.0079 6.99145Z"
                                    fill="white" fill-opacity="0.5" />
                            </svg>
                        </div>
                        <div class="ts_nav_arrow ts_nav_next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.6589 6.99145C14.0928 6.55754 14.7963 6.55754 15.2302 6.99145L20.7858 12.547C20.9942 12.7554 21.1112 13.038 21.1112 13.3327C21.1112 13.6274 20.9942 13.91 20.7858 14.1184L15.2302 19.6739C14.7963 20.1078 14.0928 20.1078 13.6589 19.6739C13.225 19.24 13.225 18.5365 13.6589 18.1026L17.3176 14.4438L6.66678 14.4438C6.05313 14.4438 5.55566 13.9463 5.55566 13.3327C5.55566 12.719 6.05313 12.2216 6.66678 12.2216L17.3176 12.2216L13.6589 8.5628C13.225 8.12889 13.225 7.42537 13.6589 6.99145Z"
                                    fill="#D7DBE4" />
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <script>
            (function () {
                function initTestimonialSlider() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initTestimonialSlider, 100);
                        return;
                    }

                    const tsSwiper = new Swiper('.ts_swiper', {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        loop: true,
                        speed: 600,

                        navigation: {
                            nextEl: '.ts_nav_next',
                            prevEl: '.ts_nav_prev',
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        },
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initTestimonialSlider);
                } else {
                    initTestimonialSlider();
                }
            })();
        </script>

        <?php
    }
}
?>