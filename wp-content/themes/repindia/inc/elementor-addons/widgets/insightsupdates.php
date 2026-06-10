<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Insightsupdates extends Widget_Base
{
    public function get_name()
    {
        return 'insightsupdates';
    }
    
    public function get_title()
    {
        return 'Blog Insight Updates';
    }
    
    public function get_icon()
    {
        return 'fa fa-th';
    }
    
    public function get_category()
    {
        return ['general'];
    }
    
    /**
     * Get all registered post types
     */
    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = ['post' => __('Post', 'repindia')];
        
        foreach ($post_types as $post_type) {
            if ($post_type->name !== 'post' && $post_type->name !== 'page' && $post_type->name !== 'attachment') {
                $options[$post_type->name] = $post_type->label;
            }
        }
        
        return $options;
    }
    
    /**
     * Get all registered taxonomies
     */
    private function get_all_taxonomies()
    {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        $result = [];
        
        foreach ($taxonomies as $taxonomy) {
            // Skip built-in taxonomies that are not commonly used
            if (in_array($taxonomy->name, ['post_format', 'nav_menu', 'link_category'])) {
                continue;
            }
            
            $result[$taxonomy->name] = [
                'label' => $taxonomy->label,
                'object_type' => $taxonomy->object_type,
            ];
        }
        
        return $result;
    }
    
    /**
     * Get terms for a taxonomy
     */
    private function get_taxonomy_terms($taxonomy)
    {
        if (!taxonomy_exists($taxonomy)) {
            return [];
        }
        
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);
        
        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }
        
        $options = [];
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }
        
        return $options;
    }
    
    protected function register_controls()
    {
        // Main Settings Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content Settings', 'repindia'),
            ]
        );
        
        // Section Title
        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Insights & Updates', 'repindia'),
                'label_block' => true,
            ]
        );
        
        // Section Description
        $this->add_control(
            'section_description',
            [
                'label' => __('Section Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Explore the latest from i2V — blogs, press releases, webinars, events, and industry insights.', 'repindia'),
                'rows' => 3,
                'label_block' => true,
            ]
        );
        
        // Posts Per Page
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 7,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->end_controls_section();

        // Add only newsroom_type taxonomy filter section
        $this->start_controls_section(
            'section_taxonomy_newsroom_type',
            [
                'label' => __('Filter by Newsroom Type', 'repindia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add control to enable/disable newsroom_type filter
        $this->add_control(
            'taxonomy_newsroom_type_enable',
            [
                'label' => __('Filter by Newsroom Type', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // Get terms for newsroom_type taxonomy
        $terms = $this->get_taxonomy_terms('newsroom_type');
        
        if (!empty($terms)) {
            $this->add_control(
                'taxonomy_newsroom_type_terms',
                [
                    'label' => __('Select Newsroom Type', 'repindia'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $terms,
                    'multiple' => true,
                    'label_block' => true,
                    'condition' => [
                        'taxonomy_newsroom_type_enable' => 'yes',
                    ],
                ]
            );
        } else {
            $this->add_control(
                'taxonomy_newsroom_type_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('No terms found for Newsroom Type.', 'repindia'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition' => [
                        'taxonomy_newsroom_type_enable' => 'yes',
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }

    /**
     * Build query arguments based on settings
     */
    private function build_query_args($settings)
    {
        // Hardcode post type to 'newsroom'
        $post_type = 'newsroom';
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 7;
        
        // Get current page for pagination
        $paged = 1;
        
        $args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => 1,
            'order' => 'ASC',
            'ignore_sticky_posts' => true,
        ];
        
        // Build tax_query based on newsroom_type taxonomy filter only
        $tax_query = [];
        
        // Check for newsroom_type filter
        if (!empty($settings['taxonomy_newsroom_type_enable']) && $settings['taxonomy_newsroom_type_enable'] === 'yes') {
            $selected_terms = !empty($settings['taxonomy_newsroom_type_terms']) ? $settings['taxonomy_newsroom_type_terms'] : [];
            
            if (!empty($selected_terms) && is_array($selected_terms)) {
                $selected_terms = array_map('intval', $selected_terms);
                $tax_query[] = [
                    'taxonomy' => 'newsroom_type',
                    'field' => 'term_id',
                    'terms' => $selected_terms,
                ];
            }
        }
        
        // Add tax_query if we have taxonomy filters
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        return $args;
    }

    /**
     * Get first taxonomy term for a post from newsroom_categories
     */
    private function get_post_taxonomy_term($post_id, $post_type)
    {
        // Get terms from newsroom_categories taxonomy only
        $terms = get_the_terms($post_id, 'newsroom_categories');
        
        if (!empty($terms) && !is_wp_error($terms) && !empty($terms[0]->name)) {
            return [
                'name' => $terms[0]->name,
                'taxonomy' => 'newsroom_categories',
            ];
        }
        
        return null;
    }

    /**
     * Get all taxonomy terms for a post from newsroom_categories
     */
    private function get_post_taxonomy_terms($post_id)
    {
        $terms = get_the_terms($post_id, 'newsroom_categories');
        
        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms;
        }
        
        return [];
    }

    /**
     * Format post date from ACF field or default post date
     * Format: Jan 31, 2026
     */
    private function format_post_date($post_id)
    {
        // Try to get ACF field first
        if (function_exists('get_field')) {
            $custom_date = get_field('custom_created_date', $post_id);
            if (!empty($custom_date)) {
                if (is_numeric($custom_date)) {
                    // Unix timestamp
                    return date('M d, Y', $custom_date);
                } else {
                    // Try different date formats
                    $date_obj = \DateTime::createFromFormat('Ymd', $custom_date);
                    if ($date_obj === false) {
                        $date_obj = \DateTime::createFromFormat('Y-m-d', $custom_date);
                    }
                    if ($date_obj !== false) {
                        return $date_obj->format('M d, Y');
                    }
                    // Try to parse as string
                    $timestamp = strtotime($custom_date);
                    if ($timestamp !== false) {
                        return date('M d, Y', $timestamp);
                    }
                }
            }
        }
        
        // Fallback to default post date
        return get_the_date('M d, Y', $post_id);
    }

    /**
     * Resolve ACF image field value to a URL
     */
    private function resolve_acf_image_url($field_value)
    {
        if (empty($field_value)) {
            return '';
        }

        $image_url = '';
        $attachment_id = 0;

        if (is_array($field_value)) {
            if (!empty($field_value['url'])) {
                $image_url = $field_value['url'];
            }
            if (!empty($field_value['ID'])) {
                $attachment_id = (int) $field_value['ID'];
            } elseif (!empty($field_value['id'])) {
                $attachment_id = (int) $field_value['id'];
            }
        } elseif (is_numeric($field_value)) {
            $attachment_id = (int) $field_value;
        } elseif (is_string($field_value) && filter_var($field_value, FILTER_VALIDATE_URL)) {
            $image_url = $field_value;
        }

        if (empty($image_url) && $attachment_id) {
            $image_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
        }

        return !empty($image_url) ? $image_url : '';
    }

    /**
     * Get light/dark author image URLs with fallback chain
     */
    private function get_news_author_images($post_id)
    {
        $default_url = get_template_directory_uri() . '/assets/images/update/avtar.svg';
        $light_url = '';
        $dark_url = '';

        if (function_exists('get_field')) {
            $light_url = $this->resolve_acf_image_url(get_field('news_author_image', $post_id));
            $dark_url = $this->resolve_acf_image_url(get_field('news_author_image_dark', $post_id));
        }

        if (empty($light_url)) {
            $light_url = $default_url;
        }

        if (empty($dark_url)) {
            $dark_url = $light_url;
        }

        return [
            'light' => $light_url,
            'dark' => $dark_url,
        ];
    }

    /**
     * Render pagination
     */
    private function render_pagination($query)
    {
        if (!$query->max_num_pages || $query->max_num_pages <= 1) {
            return;
        }
        
        $pagination_args = [
            'total' => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => __('&laquo; Previous', 'repindia'),
            'next_text' => __('Next &raquo;', 'repindia'),
        ];
        
        if (is_front_page()) {
            $pagination_args['current'] = max(1, get_query_var('page'));
        }
        
        echo '<div class="custom-latest-resource-pagination">';
        echo paginate_links($pagination_args);
        echo '</div>';
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        // Hardcode post type to 'newsroom'
        $post_type = 'newsroom';
        
        // Don't run query in Elementor editor preview unnecessarily
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="resource_card_section custom-latest-resource-wrapper">';
            echo '<p>' . esc_html__('Post list will appear here on the frontend.', 'repindia') . '</p>';
            echo '</div>';
            return;
        }
        
        // Build and execute query
        $query_args = $this->build_query_args($settings);
        $query = new \WP_Query($query_args);
        
        // Get posts
        $posts = $query->posts;
        $first_post = !empty($posts) ? $posts[0] : null;
        $remaining_posts = !empty($posts) && count($posts) > 1 ? array_slice($posts, 1) : [];
        
        ?>
        <div class="sectionsinsightsupdates grey-light">
         <section class="microspace-custom_outside custom-container">
            <div class="mx-auto">

               <div class="col-lg-12 text-center">
                  <?php if (!empty($settings['section_title'])) : ?>
                     <h3 class="main_title quote">
                        <?php echo esc_html($settings['section_title']); ?>
                     </h3>
                  <?php endif; ?>
                  <?php if (!empty($settings['section_description'])) : ?>
                     <div class="text-left">
                        <p><?php echo wp_kses_post($settings['section_description']); ?></p>
                     </div>
                  <?php endif; ?>
               </div>


               <div class="insights-updates">
                  <div class="row">
                     <div class="col-xl-7">
                        <?php if ($first_post) : ?>
                           <?php
                           setup_postdata($first_post);
                           $first_post_id = $first_post->ID;
                           $first_post_image = get_the_post_thumbnail_url($first_post_id, 'full');
                           $first_post_categories = $this->get_post_taxonomy_terms($first_post_id);
                           $first_post_title = get_the_title($first_post_id);
                           $first_post_excerpt = get_the_excerpt($first_post_id);
                           $first_post_date = $this->format_post_date($first_post_id);
                           $first_post_author = get_the_author_meta('display_name', $first_post->post_author);
                           $first_post_author_images = $this->get_news_author_images($first_post_id);
                           $first_post_link = get_permalink($first_post_id);
                           ?>
                           <a href="<?php echo esc_url($first_post_link); ?>" >
                              <div class="insights-updates-item">
                                 <?php if (!empty($first_post_image)) : ?>
                                    <div class="insights-updates-item-image">
                                       <img src="<?php echo esc_url($first_post_image); ?>" alt="<?php echo esc_attr($first_post_title); ?>" class="activeblogimg">
                                    </div>
                                 <?php endif; ?>
                                 <div class="insights-updates-item-text_left">
                                    <?php if (!empty($first_post_categories)) : ?>
                                       <ul class="p-0 insights-updates-item-text_left-list">
                                          <li>
                                             <?php foreach ($first_post_categories as $cat) : ?>
                                                <span href="#" onclick="event.stopPropagation();"><?php echo esc_html($cat->name); ?></span>
                                             <?php endforeach; ?>
                                          </li>
                                       </ul>
                                    <?php endif; ?>
                                    <h4 class="brand_heading_color">
                                       <?php echo esc_html($first_post_title); ?>
                                    </h4>
                                    <?php if (!empty($first_post_excerpt)) : ?>
                                       <div class="insightleftdesc">
                                          <p><?php echo wp_kses_post($first_post_excerpt); ?></p>
                                       </div>
                                    <?php endif; ?>
                                    <div class="date-author-txt">
                                       <p><span><?php echo esc_html($first_post_date); ?></span> <span><small><img class="white-theme-img" src="<?php echo esc_url($first_post_author_images['light']); ?>" alt="<?php echo esc_attr($first_post_author); ?>"><img class="black-theme-img" src="<?php echo esc_url($first_post_author_images['dark']); ?>" alt="<?php echo esc_attr($first_post_author); ?>"></small> <?php echo esc_html($first_post_author); ?></span></p>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        <?php endif; ?>
                     </div>
                     <div class="col-xl-5">
                        <?php if (!empty($remaining_posts)) : ?>
                           <div class="lisitng-inner">
                              <?php foreach ($remaining_posts as $post) : ?>
                                 <?php
                                 setup_postdata($post);
                                 $post_id = $post->ID;
                                 $post_image = get_the_post_thumbnail_url($post_id, 'full');
                                 $post_title = get_the_title($post_id);
                                 $post_date = $this->format_post_date($post_id);
                                 $post_author = get_the_author_meta('display_name', $post->post_author);
                                 $post_author_images = $this->get_news_author_images($post_id);
                                 $post_link = get_permalink($post_id);
                                 ?>
                                    <a href="<?php echo esc_url($post_link); ?>" class="d-flex align-items-end gap-4">
                                       <!-- <div class="d-flex align-items-end gap-4"> -->
                                          <?php if (!empty($post_image)) : ?>
                                             <div class="insights-updates-item-small-icon">
                                                <img src="<?php echo esc_url($post_image); ?>" alt="<?php echo esc_attr($post_title); ?>">
                                             </div>
                                          <?php endif; ?>
                                          <div class="insights-updates-item-text">
                                             <h5>
                                                <?php echo esc_html($post_title); ?>
                                             </h5>
                                             <div class="date-author-txt">
                                                <p><span><?php echo esc_html($post_date); ?></span> <span><small><img class="white-theme-img" src="<?php echo esc_url($post_author_images['light']); ?>" alt="<?php echo esc_attr($post_author); ?>"><img class="black-theme-img" src="<?php echo esc_url($post_author_images['dark']); ?>" alt="<?php echo esc_attr($post_author); ?>"></small> <?php echo esc_html($post_author); ?></span></p>
                                             </div>
                                          </div>
                                       <!-- </div> -->
                                    </a>
                              <?php endforeach; ?>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>


            </div>
         </section>
      </div>
        
<?php
        wp_reset_postdata();
    }
}
