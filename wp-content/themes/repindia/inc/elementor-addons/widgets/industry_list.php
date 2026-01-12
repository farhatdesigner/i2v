<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Industry_List extends Widget_Base
{
    public function get_name()
    {
        return 'industry_list';
    }
    public function get_title()
    {
        return 'Industry List';
    }
    public function get_icon()
    {
        return 'fa fa-th';
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
            'industry_title',
            [
                'label' => esc_html__('Industry Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'industry_description',
            [
                'label' => esc_html__('Industry Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'industry_image',
            [
                'label' => esc_html__('Industry Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'industry_list',
            [
                'label' => esc_html__('Industry List', 'repindia'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'industry_title' => '',
                    ],
                ],
                'title_field' => '{{{ industry_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $industries = $settings['industry_list'];
        ?>

        <div class="industry-list-section">
            <section>
                <div class="custom-container">
                    <ul class="grid-industry_list list-unstyled">

                        <!-- Card 1 -->
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 2 -->
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 3 -->
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <!-- Card 4 -->
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 5 -->


                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>    <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>   
                         <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card_industry h-100 border-0" style="
">
                                <div class="card-image_industry">
                                    <img decoding="async" class="white-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                    <img decoding="async" class="black-theme-img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/no-helmet-detection.webp"
                                        alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body_industry">
                                    <h5 class="card-title_industry position-relative">Oil and Gas</h5>
                                    <p class="card-text_industry">
                                        Ensure safety and efficiency across wind, solar, coal, hydro, and power plants with scalable monitoring and early risk detection.


                                    </p>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <a class="theme-btn bg-trans border_btnlight" href="#">Explore Oil &amp; Gas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
            </section>

        </div>
        <?php
    }
}

