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

    /**
     * Single industry card markup. Pass WP_Post explicitly so titles, excerpts, and
     * thumbnails stay correct in Elementor (global $post is the page, not each CPT).
     *
     * @param \WP_Post $post Industry post object from WP_Query.
     */
    protected function render_industry_list_item($post)
    {
        if (!($post instanceof \WP_Post)) {
            return;
        }
        $post_id = (int) $post->ID;
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
        <?php
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
            'order' => 'ASC',
            'ignore_sticky_posts' => true,
        ];
        
        $query = new \WP_Query($args);
        $posts = $query->posts;
        $total_items = count($posts);
        // When a 3-per-row count would leave exactly one item alone, show the last four as one equal-width row; all rows above keep the default wide/narrow pattern.
        $merge_trailing = ($total_items >= 4 && ($total_items % 3) === 1);
        $head_posts = $merge_trailing ? array_slice($posts, 0, -4) : $posts;
        $tail_posts = $merge_trailing ? array_slice($posts, -4) : [];
        ?>

        <div class="industry-list-section">
            <section>
                <div class="">
                    <?php if ($total_items > 0) : ?>
                        <?php if (!empty($head_posts)) : ?>
                    <ul class="grid-industry_list list-unstyled">
                        <?php
                        foreach ($head_posts as $industry_post) {
                            $this->render_industry_list_item($industry_post);
                        }
                        ?>
                    </ul>
                        <?php endif; ?>

                        <?php if (!empty($tail_posts)) : ?>
                    <ul class="grid-industry_list grid-industry_list--last-row-four list-unstyled">
                        <?php
                        foreach ($tail_posts as $industry_post) {
                            $this->render_industry_list_item($industry_post);
                        }
                        ?>
                    </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>

        </div>
        <?php
    }
}

