<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Singlescrollcards extends Widget_Base
{
    public function get_name()
    {
        return 'singlescrollcards';
    }

    public function get_title()
    {
        return 'Single Scroll Cards';
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
                'label' => 'Content Settings',
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => 'Content',
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>


        <div class="custom-container_small">
            <div class="sectionsscroll">
                <div class="sections_cards_relative system_setup">
                    <div class="panels flex-center flex-cards">

                        <section class="panel">
                            <div class="card-wrapper_single">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="card-contents">
                                            <h3>Configuration client</h3>
                                            <p>i2V Configuration Client offers a unified interface to manage devices, servers, storage, and alerts—both locally and remotely. It supports real-time testing, system health checks, structured device grouping, and reporting—making setup, maintenance, and troubleshooting efficient and user-friendly.</p>
                                            <ul class="p-0 m-0">
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Centralized configuration</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Remote & local setup</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Device management</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Search & documentation</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>System health monitoring</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Live testing & diagnostics and more</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="card-img_single">
                                            <img src="http://localhost/i2v/wp-content/uploads/2025/11/camera-management.webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="panel animate-right">
                            <div class="card-wrapper_single">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="card-contents">
                                            <h3>User management</h3>
                                            <p>i2V Configuration Client offers a unified interface to manage devices, servers, storage, and alerts—both locally and remotely. It supports real-time testing, system health checks, structured device grouping, and reporting—making setup, maintenance, and troubleshooting efficient and user-friendly.</p>
                                            <ul class="p-0 m-0">
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Centralized configuration</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Remote & local setup</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Device management</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Search & documentation</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>System health monitoring</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Live testing & diagnostics and more</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="card-img_single">
                                            <img src="http://localhost/i2v/wp-content/uploads/2025/11/camera-management.webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="panel animate-right">
                            <div class="card-wrapper_single">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="card-contents">
                                            <h3>Camera management</h3>
                                            <p>i2V Configuration Client offers a unified interface to manage devices, servers, storage, and alerts—both locally and remotely. It supports real-time testing, system health checks, structured device grouping, and reporting—making setup, maintenance, and troubleshooting efficient and user-friendly.</p>
                                            <ul class="p-0 m-0">
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Centralized configuration</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Remote & local setup</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Device management</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Search & documentation</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>System health monitoring</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Live testing & diagnostics and more</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="card-img_single">
                                            <img src="http://localhost/i2v/wp-content/uploads/2025/11/camera-management.webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="panel animate-right">
                            <div class="card-wrapper_single">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="card-contents">
                                            <h3>Failover/Redundancy</h3>
                                            <p>i2V Configuration Client offers a unified interface to manage devices, servers, storage, and alerts—both locally and remotely. It supports real-time testing, system health checks, structured device grouping, and reporting—making setup, maintenance, and troubleshooting efficient and user-friendly.</p>
                                            <ul class="p-0 m-0">
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Centralized configuration</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Remote & local setup</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Device management</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Search & documentation</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>System health monitoring</li>
                                                <li><span><img src="http://localhost/i2v/wp-content/uploads/2025/11/check.svg"></span>Live testing & diagnostics and more</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="card-img_single">
                                            <img src="http://localhost/i2v/wp-content/uploads/2025/11/camera-management.webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                </div>
            </div>
        </div>


<?php
    }
}
