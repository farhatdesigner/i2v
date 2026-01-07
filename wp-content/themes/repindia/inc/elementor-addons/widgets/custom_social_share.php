<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Social_Share extends Widget_Base {

    public function get_name() {
        return 'custom_social_share';
    }

    public function get_title() {
        return 'Custom Social Share';
    }

    public function get_icon() {
        return 'fa fa-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => __('Dyanmic Social Share', 'repindia')]);

        $this->add_control(
            'facebook_icon',
            [
                'label' => __('Facebook Icon', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'twitter_icon',
            [
                'label' => __('Twitter Icon', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'linkedin_icon',
            [
                'label' => __('LinkedIn Icon', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'copy_icon',
            [
                'label' => __('Copy/File Icon', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $url   = urlencode( get_permalink() );
        $title = urlencode( get_the_title() );
        ?>
        <div class="socialshare_section">
            <style>
                .socialshare_section ul.shocial_media{
                    max-width: 62px;
                    width: 62px;
                    background: #fff;
                    display: flex;
                    flex-direction: column;
                    padding: 20px;
                    border-radius: 100px;
                    margin: 0;
                    gap: 20px;
                }
                .socialshare_section .shocial_media li a img,
                .socialshare_section .shocial_media li button img {
                    max-width: 22px;
                    width: 22px;
                    height: 22px;
                    display: inline-block;
                    vertical-align: middle;
                }
                .socialshare_section li.tooltip.dropdown-item {
                    display: inline-block;
                    width: auto;
                }
                .socialshare_section button#copyButton {
                    display: inline-block;
                    width: auto;
                    border: 0;
                    background: transparent;
                    padding: 0;
                    max-width: 22px;
                }
                .socialshare_section ul.shocial_media li {
                    width: 23px;
                    max-width: 23px;
                    height: 22px;
                }
                .socialshare_section .tooltip { position: relative;display: inline-block;opacity: 1;z-index: 2; }
                .socialshare_section .tooltip .tooltiptext { visibility: hidden;width: 140px;background-color: #555;color: #fff;text-align: center;border-radius: 6px;padding: 5px;position: absolute;z-index: 1;bottom: 80%;left: 50%;margin-left: -75px;opacity: 0;transition: opacity 0.3s; }
                .socialshare_section .tooltip .tooltiptext::after { content: "";position: absolute;top: 100%;left: 50%;margin-left: -5px;border-width: 5px;border-style: solid;border-color: #555 transparent transparent transparent; }
                .socialshare_section .tooltip:hover .tooltiptext { visibility: visible;opacity: 1; }
                .socialshare_section .share .dropdown-menu button { padding: 0;background: transparent;border: 0; }
            </style>
            <ul class="shocial_media" aria-labelledby="dropdownMenuLink">
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
                    target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($settings['facebook_icon']['url'])): ?>
                            <img src="<?php echo esc_url($settings['facebook_icon']['url']); ?>" alt="Facebook Share" />
                        <?php else: ?>
                            facebook
                        <?php endif; ?>
                    </a>
                </li>

                <li>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>"
                    target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($settings['twitter_icon']['url'])): ?>
                            <img src="<?php echo esc_url($settings['twitter_icon']['url']); ?>" alt="Twitter Share" />
                        <?php else: ?>
                            Twitter
                        <?php endif; ?>
                    </a>
                </li>

                <li>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $url; ?>"
                    target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($settings['linkedin_icon']['url'])): ?>
                            <img src="<?php echo esc_url($settings['linkedin_icon']['url']); ?>" alt="LinkedIn Share" />
                        <?php else: ?>
                            Linkedin
                        <?php endif; ?>
                    </a>
                </li>
                <li class="tooltip dropdown-item"><input style="display: none;" type="text"
                        value="{{ urlencode(url()->current()) }}" id="clipinput">
                    <button id="copyButton" onmouseout="outFunc()"><span class="tooltiptext"
                            id="producttooltip">Click to copy</span>
                        <?php if (!empty($settings['copy_icon']['url'])): ?>
                            <img src="<?php echo esc_url($settings['copy_icon']['url']); ?>" alt="Copy Link" />
                        <?php else: ?>
                            file
                        <?php endif; ?>
                    </button>
                </li>
            </ul>

            <div class="reading-progress">
                <svg viewBox="0 0 36 36">
                    <path class="bg"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="progress"
                        stroke-dasharray="0,100"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <text x="18" y="20"
                        text-anchor="middle"
                        class="percentage">0%</text>
                </svg>
            </div>

            
        </div>
        <script>
            document.getElementById("copyButton").addEventListener("click", function() {
                // Get the current URL
                var url = window.location.href;
                // Create a temporary input element
                var input = document.createElement('input');
                input.setAttribute('value', url);
                document.body.appendChild(input);
                // Select the input content
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices
                // Copy the selected content
                document.execCommand('copy');
                // Remove the temporary input
                document.body.removeChild(input);
                // msg
                var tooltipsuccess = document.getElementById("producttooltip");
                tooltipsuccess.innerHTML = 'Copied';
            });

            function outFunc(tooltext) {
                var tooltip = document.getElementById("producttooltip");
                tooltip.innerHTML = 'Click to copy';
            }
        </script>
        
    <?php 
    }
}
