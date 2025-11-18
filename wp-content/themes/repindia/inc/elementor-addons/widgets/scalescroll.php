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

class Scalescroll extends Widget_Base
{
    public function get_name()
    {
        return 'scalescroll';
    }

    public function get_title()
    {
        return 'Scale Scroll';
    }

    public function get_icon()
    {
        return 'fa fa-arrows-alt';
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
                'label' => 'Content Settings',
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<h2>Scale on Scroll</h2><p>This content will scale as you scroll.</p>',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'min_scale',
            [
                'label' => esc_html__('Minimum Scale', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0.8,
                ],
                'description' => esc_html__('Minimum scale when element is out of view', 'repindia'),
            ]
        );

        $this->add_control(
            'max_scale',
            [
                'label' => esc_html__('Maximum Scale', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'description' => esc_html__('Maximum scale when element is in view', 'repindia'),
            ]
        );

        $this->add_control(
            'scroll_offset',
            [
                'label' => esc_html__('Scroll Offset', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'description' => esc_html__('Offset from viewport center for scaling effect', 'repindia'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'repindia'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'repindia'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'repindia'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'repindia'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .scale-scroll-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .scale-scroll-content',
            ]
        );

        $this->end_controls_section();
    }

    // PHP Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>

        <div class="sectionsscroll">
            <div class="container-page flex-center">
                <div class="contento  ">
                    <div class="imgicon"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"
                            fill="none">
                            <mask id="mask0_5355_1303" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                                width="60" height="60">
                                <path d="M60 0H0V60H60V0Z" fill="white" />
                            </mask>
                            <g mask="url(#mask0_5355_1303)">
                                <path
                                    d="M28.1103 42.1501C22.4403 42.1501 17.8203 37.5301 17.8203 31.8601C17.8203 26.1901 22.4403 21.5701 28.1103 21.5701C33.7803 21.5701 38.4003 26.1901 38.4003 31.8601C38.4003 37.5301 33.7803 42.1501 28.1103 42.1501ZM28.1103 24.6001C24.0903 24.6001 20.8203 27.8701 20.8203 31.8901C20.8203 35.9101 24.0903 39.1801 28.1103 39.1801C32.1303 39.1801 35.4003 35.9101 35.4003 31.8901C35.4003 27.8701 32.1303 24.6001 28.1103 24.6001Z"
                                    fill="#121212" />
                                <path
                                    d="M28.1103 50.94C17.5803 50.94 9.03027 42.39 9.03027 31.86C9.03027 21.33 17.5803 12.78 28.1103 12.78C38.6403 12.78 47.1903 21.33 47.1903 31.86C47.1903 42.39 38.6403 50.94 28.1103 50.94ZM28.1103 15.81C19.2303 15.81 12.0303 23.01 12.0303 31.89C12.0303 40.77 19.2303 47.97 28.1103 47.97C36.9903 47.97 44.1903 40.77 44.1903 31.89C44.1903 23.01 36.9903 15.81 28.1103 15.81Z"
                                    fill="#121212" />
                                <path
                                    d="M28.1102 59.73C12.7502 59.73 0.240234 47.22 0.240234 31.86C0.240234 16.5 12.7502 4.02002 28.1102 4.02002C33.2702 4.02002 38.3102 5.46002 42.6902 8.13002L41.1002 10.68C37.2002 8.28002 32.7002 6.99002 28.0802 6.99002C14.3702 6.99002 3.21023 18.15 3.21023 31.86C3.21023 45.57 14.3702 56.73 28.0802 56.73C41.7902 56.73 52.9502 45.57 52.9502 31.86C52.9502 27.24 51.6902 22.74 49.2602 18.84L51.8102 17.25C54.5102 21.63 55.9202 26.67 55.9202 31.83C55.9202 47.19 43.4102 59.7 28.0502 59.7L28.1102 59.73Z"
                                    fill="#121212" />
                                <path d="M39.5071 18.372L27.0762 30.803L29.1975 32.9243L41.6284 20.4934L39.5071 18.372Z"
                                    fill="#121212" />
                                <path
                                    d="M38.7898 21.2099L40.4998 8.69995L48.7498 0.449951L51.6598 8.30995L59.5198 11.22L51.2698 19.47L38.7598 21.18L38.7898 21.2099ZM43.3498 10.11L42.2998 17.7L49.8898 16.65L54.1198 12.42L49.3498 10.65L47.5798 5.87995L43.3498 10.11Z"
                                    fill="#121212" />
                            </g>
                        </svg></div>
                    <div class="txtflex">
                        <h2>Vision</h2>
                        <p>
                        <p class="para-text">Striving for global leadership through excellence, effective governance, customer
                            satisfaction, and nurturing enduring partnerships.</p>
                        </p>
                    </div>
                </div>
                <div class="contento  animate-left">
                    <div class="imgicon"><svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72"
                            fill="none">
                            <path
                                d="M35.9996 54.75C16.3796 54.75 6.62965 37.65 6.23965 36.9C5.93965 36.33 5.93965 35.64 6.23965 35.07C6.62965 34.35 16.3796 17.22 35.9996 17.22C55.6196 17.22 65.3697 34.32 65.7597 35.07C66.0597 35.64 66.0597 36.33 65.7597 36.9C65.3697 37.62 55.6196 54.75 35.9996 54.75ZM10.0796 36C12.2996 39.39 21.0596 51 35.9996 51C50.9396 51 59.6996 39.39 61.9196 36C59.6996 32.61 50.9396 21 35.9996 21C21.0596 21 12.2996 32.61 10.0796 36ZM35.9996 47.25C29.7896 47.25 24.7496 42.21 24.7496 36C24.7496 29.79 29.7896 24.75 35.9996 24.75C42.2096 24.75 47.2496 29.79 47.2496 36C47.2496 42.21 42.2096 47.25 35.9996 47.25ZM35.9996 28.5C31.8596 28.5 28.4996 31.86 28.4996 36C28.4996 40.14 31.8596 43.5 35.9996 43.5C40.1396 43.5 43.4996 40.14 43.4996 36C43.4996 31.86 40.1396 28.5 35.9996 28.5Z"
                                fill="#121212" />
                        </svg></div>
                    <div class="txtflex">
                        <h2>Mission</h2>
                        <p>
                        <p class="para-text">Spearheading the transformation of commodities into value-added products through
                            innovation and technology, driving meaningful progress.</p>
                        </p>
                    </div>
                </div>
                <div class="contento  animate-left">
                    <div class="imgicon"><svg xmlns="http://www.w3.org/2000/svg" width="80" height="76" viewBox="0 0 80 76"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M61.5993 17.1335C60.6117 17.1335 59.8327 17.9271 59.8327 18.9001V31.4001C59.8327 33.3803 59.0636 35.2881 57.6422 36.7096L51.0755 43.2763C50.5548 43.797 49.7106 43.797 49.1899 43.2763C48.6692 42.7556 48.6692 41.9114 49.1899 41.3907L55.3899 35.1907C56.0692 34.5114 56.0692 33.3889 55.3899 32.7096C54.7106 32.0303 53.5881 32.0303 52.9088 32.7096L43.9464 41.672C42.2864 43.3631 41.3327 45.6287 41.3327 48.0001V55.6668H53.066V51.8668C53.066 51.5554 53.175 51.2537 53.3742 51.0143L61.2742 41.5143L61.278 41.5096C62.6409 39.8858 63.366 37.8568 63.366 35.7668V18.9001C63.366 17.9032 62.5963 17.1335 61.5993 17.1335ZM57.166 30.7182V18.9001C57.166 16.4731 59.1203 14.4668 61.5993 14.4668C64.0691 14.4668 66.0327 16.4304 66.0327 18.9001V35.7668C66.0327 38.4758 65.0918 41.1125 63.3226 43.2216C63.322 43.2224 63.3233 43.2208 63.3226 43.2216L55.7327 52.3487V57.0001C55.7327 57.7365 55.1357 58.3335 54.3993 58.3335H39.9993C39.263 58.3335 38.666 57.7365 38.666 57.0001V48.0001C38.666 44.9067 39.9108 41.974 42.0484 39.7989L42.0565 39.7906L51.0232 30.824C52.7079 29.1393 55.4376 29.104 57.166 30.7182Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.9668 18.9001C13.9668 16.4304 15.9304 14.4668 18.4001 14.4668C20.8792 14.4668 22.8335 16.4731 22.8335 18.9001V30.7182C24.5619 29.104 27.2916 29.1393 28.9763 30.824L37.9511 39.7989C40.0888 41.974 41.3335 44.9067 41.3335 48.0001V57.0001C41.3335 57.7365 40.7365 58.3335 40.0001 58.3335H25.6001C24.8637 58.3335 24.2668 57.7365 24.2668 57.0001V52.3487L16.6788 43.224C16.6782 43.2232 16.6795 43.2247 16.6788 43.224C14.9097 41.1149 13.9668 38.4758 13.9668 35.7668V18.9001ZM24.6096 35.1907L30.8096 41.3907C31.3303 41.9114 31.3303 42.7556 30.8096 43.2763C30.2889 43.797 29.4447 43.797 28.924 43.2763L22.3573 36.7096C20.9359 35.2881 20.1668 33.3803 20.1668 31.4001V18.9001C20.1668 17.9271 19.3878 17.1335 18.4001 17.1335C17.4032 17.1335 16.6335 17.9032 16.6335 18.9001V35.7668C16.6335 37.8568 17.3586 39.8858 18.7214 41.5096L18.7253 41.5143L26.6253 51.0143C26.8244 51.2537 26.9335 51.5554 26.9335 51.8668V55.6668H38.6668V48.0001C38.6668 45.6287 37.713 43.3632 36.0531 41.672L27.0907 32.7096C26.4114 32.0303 25.2889 32.0303 24.6096 32.7096C23.9303 33.3889 23.9303 34.5114 24.6096 35.1907Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.2002 57.0333C22.2002 56.2969 22.7971 55.7 23.5335 55.7H56.4669C57.2032 55.7 57.8002 56.2969 57.8002 57.0333V63.2C57.8002 63.9363 57.2032 64.5333 56.4669 64.5333H23.5335C22.7971 64.5333 22.2002 63.9363 22.2002 63.2V57.0333ZM24.8669 58.3666V61.8666H38.6669V58.3666H24.8669ZM41.3335 58.3666V61.8666H55.1335V58.3666H41.3335Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M40.0001 7.6333C40.4454 7.6333 40.8518 7.88676 41.0478 8.28662L44.0437 14.4007L50.768 15.3788C51.2074 15.4427 51.5725 15.7505 51.7097 16.1728C51.8469 16.5952 51.7324 17.0587 51.4145 17.3687L46.5547 22.1062L47.7163 28.8005C47.7923 29.2388 47.6125 29.6822 47.2526 29.9437C46.8928 30.2053 46.4155 30.2394 46.0221 30.0317L40.0001 26.8526L33.9781 30.0317C33.5847 30.2394 33.1074 30.2053 32.7476 29.9437C32.3877 29.6822 32.2079 29.2388 32.2839 28.8005L33.4455 22.1062L28.5857 17.3687C28.2678 17.0587 28.1533 16.5952 28.2905 16.1728C28.4277 15.7505 28.7927 15.4427 29.2322 15.3788L35.9565 14.4007L38.9524 8.28662C39.1484 7.88676 39.5548 7.6333 40.0001 7.6333ZM40.0001 11.4514L37.7811 15.98C37.6116 16.3258 37.2825 16.5657 36.9014 16.6212L31.9068 17.3476L35.5145 20.8646C35.79 21.1332 35.9154 21.5203 35.8496 21.8994L34.9889 26.8595L39.4554 24.5016C39.7963 24.3216 40.2039 24.3216 40.5448 24.5016L45.0113 26.8595L44.1506 21.8994C44.0848 21.5203 44.2102 21.1332 44.4857 20.8646L48.0934 17.3476L43.0988 16.6212C42.7177 16.5657 42.3886 16.3258 42.2191 15.98L40.0001 11.4514Z"
                                fill="#1D1D1B" />
                        </svg></div>
                    <div class="txtflex">
                        <h2>Values</h2>
                        <p>
                        <p class="para-text">We uphold leadership by setting examples, demonstrating unwavering commitment,
                            fostering trust, promoting continuous innovation, and maintaining utmost integrity in all our
                            endeavours.</p>
                        </p>
                    </div>
                </div>
            </div>
            <div class="panels flex-center">
                <section class="panel ">
                    <img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/04/Vison-1.webp">
                    <div class="none-desktop">
                        <!-- <div class="imgicon"><img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/03/Vison.svg"></div> -->
                        <h2>Vision</h2>
                        <p>
                        <p class="para-text">Striving for global leadership through excellence, effective governance, customer
                            satisfaction, and nurturing enduring partnerships.</p>
                        </p>
                    </div>
                </section>
                <section class="panel animate-right">
                    <img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/04/mission-1-1.webp">
                    <div class="none-desktop">
                        <!-- <div class="imgicon"><img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/03/Clip-path-group.svg"></div> -->
                        <h2>Mission</h2>
                        <p>
                        <p class="para-text">Spearheading the transformation of commodities into value-added products through
                            innovation and technology, driving meaningful progress.</p>
                        </p>
                    </div>
                </section>
                <section class="panel animate-right">
                    <img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/04/valaue-1-1.webp">
                    <div class="none-desktop">
                        <!-- <div class="imgicon"><img decoding="async" src="https://aplapollocoatedsteel.com/wp-content/uploads/2024/03/Clip-path-group.svg"></div> -->
                        <h2>Values</h2>
                        <p>
                        <p class="para-text">We uphold leadership by setting examples, demonstrating unwavering commitment,
                            fostering trust, promoting continuous innovation, and maintaining utmost integrity in all our
                            endeavours.</p>
                        </p>
                    </div>
                </section>
            </div>
        </div>


<?php
    }
}
?>