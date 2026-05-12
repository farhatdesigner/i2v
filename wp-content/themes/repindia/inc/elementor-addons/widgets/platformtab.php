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

class platformtab extends Widget_Base
{
    public function get_name()
    {
        return 'platformtab';
    }
    public function get_title()
    {
        return 'Slide button Tab';
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

        <div class="platformtab">


            <section class="microspace-inside">
                <div class="custom-container">


                    <div class="col-lg-8 col-xxl-7">
                        <h3 class="main_title quote">
                            One platform. Every feature you need.
                        </h3>
                        <div class="text-left">
                            <p>Live monitoring
                                System management & Setup
                                Intelligence & alerts
                                Recording & storage
                                Security & integration</p>
                        </div>
                    </div>






                    <div class="contentWrapper">
                        <div class="tabsWrapper">
                            <ul class="tabsautoscroll">
                                <li data-id="content0" class="tracking-wide active">Live monitoring</li>
                                <li data-id="content1">System management & Setup</li>
                                <li data-id="content2">Intelligence & alerts</li>
                                <li data-id="content3">Recording & storage</li>
                                <li data-id="content4">Security & integration</li>
                            </ul>
                        </div>
                        <div class="container-marketing">
                            <div class="row overflow-hidden">
                                <div class="tabContent position-relative" id="tabs-content">
                                    <div class="content0 tabdiv  active-tabcontent">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                8 columns
                                            </div>
                                            <div class="col-lg-4">
                                                4
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content1 tabdiv">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                8 columns
                                            </div>
                                            <div class="col-lg-4">
                                                4
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content2 tabdiv">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                8 columns
                                            </div>
                                            <div class="col-lg-4">
                                                4
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content3 tabdiv">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                8 columns
                                            </div>
                                            <div class="col-lg-4">
                                                4
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content4 tabdiv">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                8 columns
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