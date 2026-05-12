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

        // Main repeater for slider items
        $repeater = new \Elementor\Repeater();

        // Title
        $repeater->add_control(
            'slider_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Default Theme Image
        $repeater->add_control(
            'slider_image_default',
            [
                'label' => esc_html__('Default Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Dark Theme Image
        $repeater->add_control(
            'slider_image_dark',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        // Description
        $repeater->add_control(
            'slider_description',
            [
                'label' => esc_html__('Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Nested Repeater for List Items
        $list_repeater = new \Elementor\Repeater();
        $list_repeater->add_control(
            'list_item_text',
            [
                'label' => esc_html__('List Item Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_items',
            [
                'label' => esc_html__('List Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $list_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ list_item_text }}}',
            ]
        );

        $this->add_control(
            'slider_items',
            [
                'label' => esc_html__('Slider Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ slider_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slider_items = !empty($settings['slider_items']) ? $settings['slider_items'] : [];
        // Static SVG checkmark icon for list items
        $checkmark_svg_default = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z" fill="#8793AF" /></svg>';
        
        ?>


        <div class="custom-container_small">
          
            <div class="wrapper">
                <div class="cards-custom-body">
                    <?php if (!empty($slider_items)) : ?>
                        <?php foreach ($slider_items as $item) : ?>
                            <?php
                            $title = !empty($item['slider_title']) ? $item['slider_title'] : '';
                            $image_default = !empty($item['slider_image_default']['url']) ? $item['slider_image_default']['url'] : '';
                            $image_default_alt = !empty($item['slider_image_default']['alt']) ? $item['slider_image_default']['alt'] : $title;
                            $image_dark = !empty($item['slider_image_dark']['url']) ? $item['slider_image_dark']['url'] : $image_default;
                            $image_dark_alt = !empty($item['slider_image_dark']['alt']) ? $item['slider_image_dark']['alt'] : $image_default_alt;
                            $description = !empty($item['slider_description']) ? $item['slider_description'] : '';
                            $list_items = !empty($item['list_items']) ? $item['list_items'] : [];
                            ?>
                            <div class="card-wrapper">
                                <div class="card_display red">
                                    <div class="card-wrapper_single">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="card-contents">
                                                    <?php if (!empty($title)) : ?>
                                                        <h3><?php echo esc_html($title); ?></h3>
                                                    <?php endif; ?>
                                                    <?php if (!empty($description)) : ?>
                                                        <p><?php echo wp_kses_post($description); ?></p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($list_items)) : ?>
                                                        <ul class="p-0 m-0">
                                                            <?php foreach ($list_items as $list_item) : ?>
                                                                <?php $list_text = !empty($list_item['list_item_text']) ? $list_item['list_item_text'] : ''; ?>
                                                                <?php if (!empty($list_text)) : ?>
                                                                    <li>
                                                                        <span><?php echo $checkmark_svg_default; ?></span>
                                                                        <?php echo esc_html($list_text); ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <?php if (!empty($image_default)) : ?>
                                                    <div class="card-img_single">
                                                        <img class="white_theme_img" src="<?php echo esc_url($image_default); ?>" alt="<?php echo esc_attr($image_default_alt); ?>">
                                                        <img class="black_theme_img" src="<?php echo esc_url($image_dark); ?>" alt="<?php echo esc_attr($image_dark_alt); ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                </div>
            </div>
            <div class="distancer500"></div>



        </div>
<?php
    }
    
}
?>