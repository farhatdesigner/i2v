<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH'))
    exit;

class Video_Analytics extends Widget_Base
{
    public function get_name()
    {
        return 'video_analytics';
    }

    public function get_title()
    {
        return 'Video Analytics';
    }

    public function get_icon()
    {
        return 'fa fa-video-camera';
    }

    public function get_category()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        // No controls - all static
    }

    protected function render()
    {
        ?>

        <div class="video-analytics-widget">
            <div class="video-analytics-container">
                <!-- Connection Lines SVG -->
                <div class="connection-lines">
                    <!-- Main prominent horizontal line -->
                    <!-- Dashed lines from left dots to center (7 dots total, 4th one uses prominent line) -->
                    <svg class="connection-line-1" xmlns="http://www.w3.org/2000/svg" width="315" height="238"
                        viewBox="0 0 315 238" fill="none">
                        <path id="path-line-1" d="M0 0.5H109.748C144.133 0.5 176.106 18.1657 194.407 47.2755L314 237.5"
                            stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="6s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-1" />
                            </animateMotion>
                        </circle>
                    </svg>
                    <svg class="connection-line-2" xmlns="http://www.w3.org/2000/svg" width="315" height="170"
                        viewBox="0 0 315 170" fill="none">
                        <path id="path-line-2" d="M0 0.5H142.425C156.777 0.5 170.438 6.66777 179.93 17.4336L314 169.5"
                            stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="5s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-2" />
                            </animateMotion>
                        </circle>
                    </svg>
                    <svg class="connection-line-3" xmlns="http://www.w3.org/2000/svg" width="315" height="85"
                        viewBox="0 0 315 85" fill="none">
                        <path id="path-line-3" d="M0 0.5H139.177C156.432 0.5 173.393 4.96473 188.412 13.4601L314 84.5"
                            stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="4s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-3" />
                            </animateMotion>
                        </circle>
                    </svg>

                    <svg class="connection-line-4" xmlns="http://www.w3.org/2000/svg" width="331" height="1" viewBox="0 0 331 1"
                        fill="none">
                        <path id="path-line-4" d="M0 0.5H331" stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="3s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-4" />
                            </animateMotion>
                        </circle>
                    </svg>

                    <svg class="connection-line-5" xmlns="http://www.w3.org/2000/svg" width="315" height="75"
                        viewBox="0 0 315 75" fill="none">
                        <path id="path-line-5"
                            d="M0 74.4478H141.964C157.443 74.4478 172.711 70.8544 186.565 63.9505L314 0.447266" stroke="#D7DBE4"
                            stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="5.5s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-5" />
                            </animateMotion>
                        </circle>
                    </svg>

                    <svg class="connection-line-6" xmlns="http://www.w3.org/2000/svg" width="315" height="141"
                        viewBox="0 0 315 141" fill="none">
                        <path id="path-line-6"
                            d="M0 140.365H125.891C151.335 140.365 175.823 130.666 194.366 113.243L314.5 0.365234"
                            stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="4.5s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-6" />
                            </animateMotion>
                        </circle>
                    </svg>

                    <svg class="connection-line-7" xmlns="http://www.w3.org/2000/svg" width="329" height="224"
                        viewBox="0 0 329 224" fill="none">
                        <path id="path-line-7"
                            d="M0 222.75H115.449C146.954 222.75 176.616 207.904 195.498 182.685L313 25.75L327.722 0.25"
                            stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="7s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-line-7" />
                            </animateMotion>
                        </circle>
                    </svg>

                </div>

                <!-- Center Oval -->
                <div class="center-oval">
                    <div class="center-content">
                        <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon-Container-3.svg"
                            alt="i2V" class="logo-i-image">
                        <div class="subtitle">i2V's Video Analytics</div>
                    </div>
                </div>


                <div class="right-connection_lines">
                    <svg width="100%" height="31" viewBox="0 0 210 31" fill="none" xmlns="http://www.w3.org/2000/svg"
                        style="min-width: 210px;">
                        <path id="path-right-top" d="M210 0.5L0 0.5" stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <path id="path-right-bottom" d="M210 30.5L0 30.5" stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <!-- Circle for top path -->
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="3s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-right-top" />
                            </animateMotion>
                        </circle>
                        <!-- Circle for bottom path -->
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="3s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1" begin="1.5s">
                                <mpath href="#path-right-bottom" />
                            </animateMotion>
                        </circle>
                    </svg>
                </div>

                     <div class="right-connection_lines vertical_line">
                    <svg width="100%" height="31" viewBox="0 0 210 31" fill="none" xmlns="http://www.w3.org/2000/svg"
                        style="min-width: 210px;">
                        <path id="path-right-top" d="M210 0.5L0 0.5" stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <path id="path-right-bottom" d="M210 30.5L0 30.5" stroke="#D7DBE4" stroke-dasharray="8 8" />
                        <!-- Circle for top path -->
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="3s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1">
                                <mpath href="#path-right-top" />
                            </animateMotion>
                        </circle>
                        <!-- Circle for bottom path -->
                        <circle r="5" fill="#0066cc" stroke="white" stroke-width="2">
                            <animateMotion dur="3s" repeatCount="indefinite" calcMode="linear" keyPoints="0;1;0"
                                keyTimes="0;0.5;1" begin="1.5s">
                                <mpath href="#path-right-bottom" />
                            </animateMotion>
                        </circle>
                    </svg>
                </div>

            </div>
        </div>

        <?php
    }
}
