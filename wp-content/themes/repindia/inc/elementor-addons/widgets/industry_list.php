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
        
        // Posts Per Page
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => -1,
                'min' => -1,
                'description' => __('Set -1 to show all posts', 'repindia'),
            ]
        );
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        // Build query arguments
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : -1;
        
        $args = [
            'post_type' => 'industries',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
        ];
        
        $query = new \WP_Query($args);
        ?>
        <style>
            .card-body_industry p{
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                padding-bottom: 0;
                min-height: unset;
            }
            .card_industry {
                display: inline-block;
            }
            .card-body_industry .card-title{
                font-size: 24px;
                font-weight: 600;
                color: #06283D;
            }
            .js-dark .card_industry {
                background: #262a30;
            }
            @media(max-width: 768px){
                .card_industry{ width: 100%!important; }
                .grid-industry_list li {
                    width: 100% !important;
                }
            }
        </style>
        <div class="industry-list-section">
            <section>
                <div class="">
                    <ul class="grid-industry_list list-unstyled">

                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                            $post_id = get_the_ID();
                            $post_title = get_the_title($post_id);
                            $post_excerpt = get_the_excerpt($post_id);
                            $featured_image = get_the_post_thumbnail_url($post_id, 'full');
                            $attachment_id = get_post_thumbnail_id($post_id);
                            $featured_image_alt = '';
                            if ($attachment_id) {
                                $featured_image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                            }
                            if (empty($featured_image_alt)) {
                                $featured_image_alt = $post_title;
                            }
                            
                            // Get all terms from product_tags taxonomy
                            $product_link = get_permalink($post_id);
                            ?>
                        <li>
                            <a href="<?php echo esc_url($product_link); ?>" class="card_industry h-100 border-0" >
                                <?php if (!empty($featured_image)) : ?>
                                    <div class="card-image_industry">
                                        <img decoding="async" class="white-theme-img" src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_image_alt); ?>">
                                        <img decoding="async" class="black-theme-img" src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_image_alt); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="card-body_industry">
                                    <?php if (!empty($post_title)) : ?>
                                        <h5 class="card-title position-relative"><?php echo esc_html($post_title); ?></h5>
                                    <?php endif; ?>
                                    <?php if (!empty($post_excerpt)) : ?>
                                        <p class="card-text">
                                            <?php echo wp_kses_post($post_excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="d-flex flex-wrap mt-1">
                                        <div class="text-left">
                                            <span class="theme-btn bg-trans border_btnlight" href="#">Explore Details</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php endwhile; ?>
                        <?php endif; ?>


                    </ul>
                </div>
            </section>

        </div>
        <?php
    }
}

