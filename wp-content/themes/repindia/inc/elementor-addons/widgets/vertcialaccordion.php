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

class Vertcialaccordion extends Widget_Base
{
    public function get_name()
    {
        return 'vertcialaccordion';
    }
    public function get_title()
    {
        return 'Vertical Accordion';
    }
    public function get_icon()
    {
        return 'fa fa-accordion';
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

        <div class="platformtab">


            <section class="microspace-inside">
                <div class="custom-container">
                    <div class="row">


                        <div class="col-lg-6 col-xxl-6">
                            <h3 class="main_title quote">
                                See how i2V Video Analytics makes surveillance smarter.
                            </h3>
                            <div class="text-left">
                                <p>A quick walkthrough of how our AI-powered system detects threats, triggers alerts, and enhances response — all without cloud dependency.</p>
                            </div>

                            <section class="accordion_wrap">
                                <div class="container">
                                    <div class="accordion_set">
                                        <div class="ac_icon_wrap lightback">
                                            <div class="ac_icon_border">
                                                <img class="ac_icon" alt="null" src="https://pivotcreat4stg.wpenginepowered.com/wp-content/uploads/2025/06/accordion_icon_one.webp">
                                            </div>
                                        </div>
                                        <button class="select_div" aria-label="expand accordion section for section" aria-expanded="false">
                                            <h2 class="ac_header">
                                                Label
                                            </h2>
                                            <div aria-hidden="true" class="line lineone"></div>
                                            <div aria-hidden="true" class="line linetwo"></div>
                                        </button>
                                        <div class="accontent">
                                            <h3>
                                                Header two
                                            </h3>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eveniet aliquam, molestias tempora modi recusandae non natus alias minus quibusdam ipsa tenetur vitae nostrum culpa voluptatum at minima. Quae, voluptas.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="accordion_set">
                                        <div class="ac_icon_wrap lightback">
                                            <div class="ac_icon_border">
                                                <img class="ac_icon" alt="null" src="https://pivotcreat4stg.wpenginepowered.com/wp-content/uploads/2025/06/accordion_icon_one.webp">
                                            </div>
                                        </div>
                                        <button class="select_div" aria-label="expand accordion section for section" aria-expanded="false">
                                            <h2 class="ac_header">
                                                Label
                                            </h2>
                                            <div aria-hidden="true" class="line lineone"></div>
                                            <div aria-hidden="true" class="line linetwo"></div>
                                        </button>
                                        <div class="accontent">
                                            <h3>
                                                Header
                                            </h3>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eveniet aliquam, molestias tempora modi recusandae non natus alias minus quibusdam ipsa tenetur vitae nostrum culpa voluptatum at minima. Quae, voluptas.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="accordion_set">
                                        <div class="ac_icon_wrap lightback">
                                            <div class="ac_icon_border">
                                                <img class="ac_icon" alt="null" src="https://pivotcreat4stg.wpenginepowered.com/wp-content/uploads/2025/06/accordion_icon_one.webp">
                                            </div>
                                        </div>
                                        <button class="select_div" aria-label="expand accordion section for '<?php echo $label; ?>'" aria-expanded="false">
                                            <h2 class="ac_header">
                                                Label
                                            </h2>
                                            <div aria-hidden="true" class="line lineone"></div>
                                            <div aria-hidden="true" class="line linetwo"></div>
                                        </button>
                                        <div class="accontent">
                                            <h3>
                                                Header
                                            </h3>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eveniet aliquam, molestias tempora modi recusandae non natus alias minus quibusdam ipsa tenetur vitae nostrum culpa voluptatum at minima. Quae, volupta.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>


                        </div>

                        <div class="col-lg-6 col-xxl-6">
                            <div class="video-container">
                                <div class="video-wrapper">
                                    <div class="video-inner">
                                        <video src="https://www.youtube.com/watch?v=dQw4w9WgXcQ" controls></video>
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