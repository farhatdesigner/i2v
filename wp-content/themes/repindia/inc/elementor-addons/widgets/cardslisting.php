<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Cardslisting extends Widget_Base
{
    public function get_name()
    {
        return 'cardslisting';
    }
    public function get_title()
    {
        return 'Cards Listing';
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
            'card_title',
            [
                'label' => esc_html__('Card Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'card_description',
            [
                'label' => esc_html__('Card Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'card_image',
            [
                'label' => esc_html__('Card Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'cards_list',
            [
                'label' => esc_html__('Cards List', 'repindia'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'card_title' => '',
                    ],
                ],
                'title_field' => '{{{ card_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $cards = $settings['cards_list'];
?>

        <div class="cards-listing-section">
            <section>
                <div class="custom-container">
                    <ul class="grid-listing list-unstyled">

                        <!-- Card 1 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="Enterprise Video Management Software">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Enterprise Video Management Software (VMS)</h5>
                                    <p class="card-text text-muted">
                                        i2V’s VMS offers centralized surveillance, AI-powered search, and automated failover,
                                        delivering seamless video security for enterprises, public safety, and smart city infrastructure.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">Multi site management</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 2 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="AI-Based Video Analytics">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">AI-Based Video Analytics (VA / VCA)</h5>
                                    <p class="card-text text-muted">
                                        Analyze real-time footage with AI to detect motion, objects, and behaviors—enabling smart monitoring,
                                        automated alerts, and better situational awareness across environments.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 3 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 4 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_port.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 5 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_port.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 6 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 7 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Card 8 -->
                        <li>
                            <div class="card h-100 border-0 shadow-sm rounded-4">
                                <div class="card-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/crads_land.png" class="card-img-top rounded-top-4 h-100" alt="Integrated Command Center">
                                </div>
                                <div class="card-body p-4">
                                    <h5 class="card-title">Integrated/Traffic Command & Control Center (ICCC / PSIM)</h5>
                                    <p class="card-text text-muted">
                                        Integrates video, sensors, and alerts into a single dashboard,
                                        allowing city operators to monitor incidents, make decisions, and respond in real time.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                        <span class="badge-custom">Unified interface</span>
                                        <span class="badge-custom">AI driven insights</span>
                                        <span class="badge-custom">Multi site management</span>
                                        
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
