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

        $this->end_controls_section();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        // Don't run query in Elementor editor preview unnecessarily
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="cards-listing-section">';
            echo '<p>' . esc_html__('Product cards will appear here on the frontend.', 'repindia') . '</p>';
            echo '</div>';
            return;
        }
        
        // Build query arguments
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : -1;
        
        $args = [
            'post_type' => 'products',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'order' => 'ASC',
            'ignore_sticky_posts' => true,
        ];
        
        $query = new \WP_Query($args);
        ?>
        <style>
            .cards-listing-section .card-body p{
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                padding-bottom: 0;
                min-height: unset;
            }
        </style>
        <div class="cards-listing-section">
            <section>
                <div class="custom-container">
                    <ul class="grid-listing list-unstyled">
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
                                $product_tags = get_the_terms($post_id, 'product_tags');
                                $product_link = get_permalink($post_id);
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($product_link); ?>" class="card h-100 border-0">
                                        <!-- <div class="card h-100 border-0"> -->
                                            <?php if (!empty($featured_image)) : ?>
                                                <div class="card-image">
                                                    <img class="white-theme-img card-img-top h-100" src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_image_alt); ?>">
                                                    <img class="black-theme-img card-img-top h-100" src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_image_alt); ?>">
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-body p-4">
                                                <?php if (!empty($post_title)) : ?>
                                                    <h5 class="card-title position-relative"><?php echo esc_html($post_title); ?></h5>
                                                <?php endif; ?>
                                                <?php if (!empty($post_excerpt)) : ?>
                                                    <p class="card-text text-muted">
                                                        <?php echo wp_kses_post($post_excerpt); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (!empty($product_tags) && !is_wp_error($product_tags)) : ?>
                                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                                        <?php foreach ($product_tags as $tag) : ?>
                                                            <span class="badge-custom"><?php echo esc_html($tag->name); ?></span>
                                                        <?php endforeach; ?>
                                                        <span class="badge-cusotm bg-trans_txt">and more</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <!-- </div> -->
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>

        </div>
<?php
        wp_reset_postdata();
    }
}
