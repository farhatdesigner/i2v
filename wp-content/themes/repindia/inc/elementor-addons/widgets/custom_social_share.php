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
                .socialshare_section .shocial_media li a img,
                .socialshare_section .shocial_media li button img {
                    max-width: 100%;
                    height: auto;
                    display: inline-block;
                    vertical-align: middle;
                }
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
