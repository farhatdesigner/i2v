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


        <style>
            .ts_testimonial_section {
                background: #262A30;
                color: #ffffff;
                padding: 80px 0;
                overflow: hidden;
            }

            .ts_testimonial_container {
                margin: 0 auto;
                padding: 0 15px;
            }

            .ts_header_row {
                align-items: flex-start;
                margin-bottom: 48px;
            }

            .ts_main_title {
                font-size: 40px;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.90);
                margin: 0;
                line-height:
            }

            .ts_header_description {
                font-size: 16px;
                color: #b8c5d6;
                line-height: 1.6;
                margin: 0;
            }

            .ts_slider_wrapper {
                position: relative;
            }

            .ts_swiper {
                overflow: visible;
                padding: 10px 0;
            }

            .ts_slide_content {
                display: flex;
                gap: 30px;
                align-items: stretch;
            }

            .ts_testimonial_card {
                border-radius: 16px;
                padding: 40px;
                flex: 0 0 45%;
                max-width: 45%;
                display: flex;
                flex-direction: column;
            }

            .ts_company_logo {
                margin-bottom: 30px;
            }

            .ts_company_logo img {
                height: 32px;
                width: auto;
                filter: brightness(0) invert(1);
            }

            .ts_quote_icon {
                margin-bottom: 20px;
            }

            .ts_quote_icon svg {
                width: 40px;
                height: 30px;
                fill: #8793AF;
            }

            .ts_testimonial_text {
                font-size: 18px;
                color: #b8c5d6;
                line-height: 1.7;
                margin-bottom: 20px;
                flex-grow: 1;
            }

            .ts_author {
                font-size: 14px;
                color: #8899aa;
                margin-bottom: 30px;
            }

            .ts_stats_row {
                display: flex;
                gap: 15px;
                margin-top: auto;
            }

            .ts_stat_box {
                border-radius: var(--SM, 8px);
                background: var(--Golbal-backgrounds-secondary-bg-1, rgba(255, 255, 255, 0.10));
                padding: 20px;
                gap: 4px;
                width: 100%;
            }

            .ts_stat_number {
                font-size: 28px;
                font-weight: 700;
                color: #ffffff;
                margin-bottom: 5px;
            }

            .ts_stat_label {
                font-size: 13px;
                color: #8899aa;
                line-height: 1.4;
            }

            .ts_media_card {
                flex: 0 0 50%;
                max-width: 50%;
                border-radius: 16px;
                overflow: hidden;
                position: relative;
                min-height: 450px;
                background: linear-gradient(135deg, #2a3a4a 0%, #1a2a3a 100%);
            }

            .ts_media_card img,
            .ts_media_card video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
            }

            .ts_media_placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #5a6a7a;
                font-size: 16px;
                position: absolute;
                top: 0;
                left: 0;
                background: repeating-conic-gradient(#3a4a5a 0% 25%, #2a3a4a 0% 50%) 50% / 20px 20px;
            }

            /* Navigation Arrows */
            .ts_nav_arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 50px;
                height: 50px;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                transition: all 0.3s ease;
            }

            .ts_nav_arrow:hover {
                background: rgba(255, 255, 255, 0.2);
                border-color: rgba(255, 255, 255, 0.4);
            }

            .ts_nav_arrow svg {
                width: 20px;
                height: 20px;
                stroke: #ffffff;
                stroke-width: 2;
                fill: none;
            }

            .ts_nav_prev {
                left: -25px;
            }

            .ts_nav_next {
                right: -25px;
            }

            .ts_nav_arrow.swiper-button-disabled {
                opacity: 0.3;
                cursor: not-allowed;
            }

            /* Responsive */
            @media (max-width: 1200px) {
                .ts_nav_prev {
                    left: 10px;
                }

                .ts_nav_next {
                    right: 10px;
                }
            }

            @media (max-width: 991px) {
                .ts_header_row {
                    gap: 20px;
                }

                .ts_main_title {
                    font-size: 32px;
                }

                .ts_slide_content {
                    flex-direction: column;
                }

                .ts_testimonial_card,
                .ts_media_card {
                    flex: 0 0 100%;
                    max-width: 100%;
                }

                .ts_media_card {
                    min-height: 300px;
                }
            }

            @media (max-width: 576px) {
                .ts_testimonial_section {
                    padding: 50px 0;
                }

                .ts_main_title {
                    font-size: 26px;
                    padding-left: 15px;
                }

                .ts_testimonial_card {
                    padding: 25px;
                }

                .ts_testimonial_text {
                    font-size: 16px;
                }

                .ts_stats_row {
                    flex-direction: column;
                }

                .ts_stat_number {
                    font-size: 24px;
                }

                .ts_nav_arrow {
                    width: 40px;
                    height: 40px;
                }

                .ts_nav_prev {
                    left: 5px;
                }

                .ts_nav_next {
                    right: 5px;
                }
            }
        </style>

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
                                            <div class="ts_company_logo">
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                    alt="Hanwha Techwin">
                                            </div>
                                            <div class="ts_quote_icon">
                                                <svg viewBox="0 0 40 30" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0 30V18.75C0 15.4167 0.625 12.2917 1.875 9.375C3.125 6.45833 5.20833 3.54167 8.125 0.625L13.125 4.375C11.0417 6.70833 9.53125 8.90625 8.59375 10.9688C7.65625 13.0312 7.1875 15.2083 7.1875 17.5H12.5V30H0ZM20 30V18.75C20 15.4167 20.625 12.2917 21.875 9.375C23.125 6.45833 25.2083 3.54167 28.125 0.625L33.125 4.375C31.0417 6.70833 29.5312 8.90625 28.5938 10.9688C27.6562 13.0312 27.1875 15.2083 27.1875 17.5H32.5V30H20Z" />
                                                </svg>
                                            </div>
                                            <p class="ts_testimonial_text">
                                                With i2V's surveillance and analytics in place, we reduced unauthorized access
                                                incidents by over 60%. The system gives our team peace of mind knowing high-risk
                                                areas are always monitored.
                                            </p>
                                            <p class="ts_author">- Operations Head, Middle East Refinery</p>
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
                                            <div class="ts_company_logo">
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                    alt="Hanwha Techwin">
                                            </div>
                                            <div class="ts_quote_icon">
                                                <svg viewBox="0 0 40 30" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0 30V18.75C0 15.4167 0.625 12.2917 1.875 9.375C3.125 6.45833 5.20833 3.54167 8.125 0.625L13.125 4.375C11.0417 6.70833 9.53125 8.90625 8.59375 10.9688C7.65625 13.0312 7.1875 15.2083 7.1875 17.5H12.5V30H0ZM20 30V18.75C20 15.4167 20.625 12.2917 21.875 9.375C23.125 6.45833 25.2083 3.54167 28.125 0.625L33.125 4.375C31.0417 6.70833 29.5312 8.90625 28.5938 10.9688C27.6562 13.0312 27.1875 15.2083 27.1875 17.5H32.5V30H20Z" />
                                                </svg>
                                            </div>
                                            <p class="ts_testimonial_text">
                                                The AI-powered analytics transformed our security operations. We now detect
                                                threats
                                                in real-time and respond 50% faster than before implementing i2V's solutions.
                                            </p>
                                            <p class="ts_author">- Security Director, Smart City Project</p>
                                            <div class="ts_stats_row">
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">98.6% uptime</div>
                                                    <div class="ts_stat_label">Faster threat response time</div>
                                                </div>
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">24/7</div>
                                                    <div class="ts_stat_label">Continuous monitoring coverage</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ts_media_card">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025//11/Image-2-2.webp"
                                                alt="Testimonial Video">
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 3 -->
                                <div class="swiper-slide">
                                    <div class="ts_slide_content">
                                        <div class="ts_testimonial_card">
                                            <div class="ts_company_logo">
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector.svg"
                                                    alt="Hanwha Techwin">
                                            </div>
                                            <div class="ts_quote_icon">
                                                <svg viewBox="0 0 40 30" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M0 30V18.75C0 15.4167 0.625 12.2917 1.875 9.375C3.125 6.45833 5.20833 3.54167 8.125 0.625L13.125 4.375C11.0417 6.70833 9.53125 8.90625 8.59375 10.9688C7.65625 13.0312 7.1875 15.2083 7.1875 17.5H12.5V30H0ZM20 30V18.75C20 15.4167 20.625 12.2917 21.875 9.375C23.125 6.45833 25.2083 3.54167 28.125 0.625L33.125 4.375C31.0417 6.70833 29.5312 8.90625 28.5938 10.9688C27.6562 13.0312 27.1875 15.2083 27.1875 17.5H32.5V30H20Z" />
                                                </svg>
                                            </div>
                                            <p class="ts_testimonial_text">
                                                Implementing i2V's traffic management solution reduced congestion by 35% in our
                                                city. The real-time analytics help us make data-driven decisions for urban
                                                planning.
                                            </p>
                                            <p class="ts_author">- Commissioner, Municipal Corporation</p>
                                            <div class="ts_stats_row">
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">35%</div>
                                                    <div class="ts_stat_label">Reduction in traffic congestion</div>
                                                </div>
                                                <div class="ts_stat_box">
                                                    <div class="ts_stat_number">1000+</div>
                                                    <div class="ts_stat_label">Cameras integrated citywide</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ts_media_card">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Image-2-2.webp"
                                                alt="Testimonial Video">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Navigation Arrows -->
                        <div class="ts_nav_arrow ts_nav_prev">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 18L9 12L15 6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="ts_nav_arrow ts_nav_next">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 6L15 12L9 18" stroke-linecap="round" stroke-linejoin="round" />
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