<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Career_List extends Widget_Base {

    public function get_name() {
        return 'custom_career_list';
    }

    public function get_title() {
        return 'Career List with Filters';
    }

    public function get_icon() {
        return 'fa fa-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            ['label' => __('Content', 'repindia')]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Open roles',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Section Subtitle', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Help us bring development superpowers to everyone.',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'enable_filter',
            [
                'label' => __('Enable Filter?', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'filter_taxonomy',
            [
                'label' => __('Filter Taxonomy', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'careerteam' => __('Career Team', 'repindia'),
                    'careercity' => __('Career City', 'repindia'),
                    'careerstate' => __('Career State', 'repindia'),
                    'careercountry' => __('Career Country', 'repindia'),
                ],
                'default' => 'careerteam',
                'condition' => [
                    'enable_filter' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_terms_for_tax($taxonomy) {
        if (!taxonomy_exists($taxonomy)) return [];
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true, 'orderby' => 'name', 'order' => 'ASC']);
        return is_wp_error($terms) || empty($terms) ? [] : $terms;
    }

    private static function get_careers_grouped() {
        $query = new \WP_Query([
            'post_type' => 'careers',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        $grouped = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $team_terms = get_the_terms($post_id, 'careerteam');

            if (!empty($team_terms) && !is_wp_error($team_terms)) {
                foreach ($team_terms as $team_term) {
                    $key = $team_term->slug;
                    if (!isset($grouped[$key])) {
                        $grouped[$key] = ['term' => $team_term, 'posts' => []];
                    }
                    $grouped[$key]['posts'][] = $post_id;
                }
            } else {
                if (!isset($grouped['uncategorized'])) {
                    $grouped['uncategorized'] = ['term' => (object)['name' => 'Uncategorized', 'slug' => 'uncategorized'], 'posts' => []];
                }
                $grouped['uncategorized']['posts'][] = $post_id;
            }
        }
        wp_reset_postdata();

        uksort($grouped, function($a, $b) use ($grouped) {
            return strcasecmp($grouped[$a]['term']->name ?? '', $grouped[$b]['term']->name ?? '');
        });

        return $grouped;
    }

    private static function get_location_string($post_id) {
        $parts = [];
        foreach (['careercity', 'careerstate', 'careercountry'] as $tax) {
            $terms = get_the_terms($post_id, $tax);
            if (!empty($terms) && !is_wp_error($terms)) {
                $parts[] = $terms[0]->name;
            }
        }
        return implode(', ', $parts);
    }

    /**
     * Render widget (HTML + CSS + JS)
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : 'Open roles';
        $section_subtitle = !empty($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $enable_filter = !empty($settings['enable_filter']) && $settings['enable_filter'] === 'yes';
        $filter_taxonomy = !empty($settings['filter_taxonomy']) ? $settings['filter_taxonomy'] : 'careerteam';

        $widget_id = 'career_list_' . $this->get_id();
        $uid = esc_attr($widget_id);

        $filter_terms = $enable_filter && taxonomy_exists($filter_taxonomy) ? $this->get_terms_for_tax($filter_taxonomy) : [];
        $url_filter = isset($_GET['career_filter']) ? sanitize_text_field($_GET['career_filter']) : null;
        if ($url_filter === 'all' || $url_filter === '') $url_filter = null;
        $grouped_careers = self::get_careers_grouped();
        ?>
        <div class="career-list-widget" id="<?php echo $uid; ?>" data-filter-taxonomy="<?php echo esc_attr($filter_taxonomy); ?>">

            <div class="career-header-section">
                <div class="career-header-content">
                    <h3 class="career-main-title"><?php echo esc_html($section_title); ?></h3>
                    <?php if (!empty($section_subtitle)): ?><p class="career-subtitle"><?php echo esc_html($section_subtitle); ?></p><?php endif; ?>
                </div>
                <?php if ($enable_filter && !empty($filter_terms)): ?>
                <div class="career-filter-section">
                    <select class="career-team-filter" id="<?php echo $uid; ?>_filter">
                        <option value="all" <?php selected($url_filter, null); ?>>All teams</option>
                        <?php foreach ($filter_terms as $term): ?>
                            <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($url_filter, $term->slug); ?>><?php echo esc_html($term->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </div>
            <div class="career-table-header">
                <div>Team</div><div class="rolehead">Role</div><div class="locationhead">Location</div>
            </div>

            <div class="career-listing-content" id="<?php echo $uid; ?>_content">
                <?php $this->render_careers_list($grouped_careers, $filter_taxonomy); ?>
            </div>

        </div>

        <style>
        #<?php echo $uid; ?> .career-header-section { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:36px; }
        #<?php echo $uid; ?> .career-main-title { font-size:48px;font-weight: 600;color:#06283D; margin:0 0 12px;line-height: normal;  }
        #<?php echo $uid; ?> .career-subtitle { color:#5C5C5C;font-size: 18px;font-weight:400;line-height: 26px; margin:0; }
        #<?php echo $uid; ?> .career-filter-section { min-width:345px; }
        #<?php echo $uid; ?> .career-team-filter { width:100%; padding:10px 40px 10px 16px; border-radius:12px; border:1px solid #E5E9EC; background:#F2F5FA; height:48px; color:#4A5673; font-size:16px; font-weight:400; cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%235F6F94' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }
        
        #<?php echo $uid; ?> .career-team-filter:focus { outline:none; border-color:#E5E9EC; }
        #<?php echo $uid; ?> .career-team-filter option { border:1px solid #E5E9EC; padding:5px;font-size: 12px;background:#FFFFFF; color:#4A5673; }
        #<?php echo $uid; ?> .career-team-filter option:checked, #<?php echo $uid; ?> .career-team-filter option:hover {background: #f2f5fa;
            color: #5F6F94;}
        #<?php echo $uid; ?> .career-table-header { display:grid; grid-template-columns: 1fr 2fr 1fr; gap:16px; padding:12px 0; border-bottom:1px solid #E6EBF2; color:#5F6F94; font-weight:600; font-size:16px;line-height: 26px;margin-bottom: 12px; }
        #<?php echo $uid; ?> .career-team-group { margin-bottom: 48px;display: grid;grid-template-columns: 1fr 3fr;gap: 16px; }
        #<?php echo $uid; ?> .career-team-group:last-child{ margin-bottom: 0;}
        /* #<?php //echo $uid; ?> .career-team-group:first-child { margin-top: 20px; } */
        #<?php echo $uid; ?> .team-title { font-size: 32px;font-weight: 500 !important;color: #06283D;margin: 0; }
        #<?php echo $uid; ?> .career-row { gap:16px; border-bottom:0; align-items:center;background: transparent;border-radius: 12px;padding: 0 20px;display: inline-block;width: 100%; }
        #<?php echo $uid; ?> .career-row:hover { background: #E5F6FF; }
        #<?php echo $uid; ?> .career-row .career-role,#<?php echo $uid; ?> .career-location { color:#06283D; font-size: 24px;font-weight: 400; line-height: normal;text-decoration: underline;text-decoration-color: transparent; }
        #<?php echo $uid; ?> .career-row:hover .career-role,#<?php echo $uid; ?> .career-row:hover  .career-location{ text-decoration: underline;text-decoration-color: #D7DBE4 ; }
        /* #<?php //echo $uid; ?> .career-row .career-role a:hover { text-decoration:underline; } */
        #<?php echo $uid; ?> .career-role { width: 70%; }
        #<?php echo $uid; ?> .career-location { text-align:left;width: 35%; }
        #<?php echo $uid; ?> .career-empty { text-align:center; padding:36px 20px; color:#666; display:none; }
        #<?php echo $uid; ?> .career-team-col-in {
            padding: 14px 0;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .rolehead { padding: 0 20px; }
        .js-dark .elementor-element.career_life .elementor-widget.elementor-widget-icon-box,.js-dark .elementor-element.career_purpose.e-con,.js-dark .elementor-element.career_filter_list.e-con,
        .js-dark .elementor-element.partner_choose_desc.elementor-position-top.elementor-widget.elementor-widget-image-box{ background-color: #262A30; }
        .js-dark .btn-sec_gap.titlegrep.with_whitebg .grey-btn { border-color: #262A30;background: #262A30;color: rgba(255, 255, 255, 0.9); }
        .js-dark .career_whywork .purpose-swiper .swiper-slide figure.caption-scroll figcaption{ background: transparent; border-bottom-left-radius: 12px;border-bottom-right-radius: 12px; }
        .js-dark .elementor-element.career_faq .e-n-accordion-item .e-flex.e-con.e-child,.js-dark .elementor-element.career_faq  .elementor-widget-n-accordion .e-n-accordion-item-title{
            background-color: #262A30 !important;
            border: 1px solid var(--Golbal-others-border, rgba(193, 196, 198, 0.1)) !important;
        }
        

        /* .js-dark .elementor-element.elementor-widget-n-accordion > .e-n-accordion > .e-n-accordion-item > .e-n-accordion-item-title:hover {
            border: 1px solid rgb(193 196 198 / 20%) !important;

} */


    .js-dark #<?php echo $uid; ?> .career-row:hover { background: #464a4f;}
        .js-dark .elementor-element.career_faq .e-n-accordion-item .e-flex.e-con.e-child{
            border-color: #3e4144 !important;
        }
        .js-dark .elementor-element.career_faq .e-n-accordion > .e-n-accordion-item[open] > .e-n-accordion-item-title{
            background-color: #0074B2!important;
            border-color: #0074B2;
        }
        .js-dark .elementor-element.career_faq  .e-n-accordion > .e-n-accordion-item > .e-n-accordion-item-title:hover { border-color: #3e4144; }
        .js-dark .elementor-element.career_faq .elementor-widget-n-accordion .e-n-accordion-item .e-n-accordion-item-title-icon span>svg{ fill: #fff; }
        .js-dark #<?php echo $uid; ?> .career-row .career-role,.js-dark #<?php echo $uid; ?> .career-location{ color: rgba(255, 255, 255, 0.9); }
        .js-dark #<?php echo $uid; ?> .career-table-header,.js-dark #<?php echo $uid; ?> .career-team-col-in{ border-bottom: 1px solid #3e4144; }
        .js-dark #<?php echo $uid; ?> .career-row:hover .career-role, .js-dark #<?php echo $uid; ?> .career-row:hover .career-location{ color: rgba(255, 255, 255, 0.9) }
        .js-dark #<?php echo $uid; ?> .career-team-filter{ border-color: #464a4f;background: #464a4f;color: rgba(255, 255, 255, 0.9); }
        .js-dark #<?php echo $uid; ?> .career-team-filter{
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23fff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
        .js-dark #<?php echo $uid; ?> .career-table-header{ color: rgba(255, 255, 255, 0.9); }


        @media (max-width: 768px) {
            #<?php echo $uid; ?> .career-header-section { flex-direction:column; gap:20px; margin-bottom:32px; }
            #<?php echo $uid; ?> .career-main-title { font-size:32px; margin-bottom:8px; }
            #<?php echo $uid; ?> .career-subtitle { font-size:16px; line-height:24px; }
            #<?php echo $uid; ?> .career-filter-section { min-width:100%; width:100%; }
            #<?php echo $uid; ?> .career-table-header { display:none; }
            #<?php echo $uid; ?> .career-team-group { grid-template-columns: 1fr; gap:20px; margin-bottom:32px; }
            #<?php echo $uid; ?> .team-title { font-size:24px; margin-bottom: 0px; }
            #<?php echo $uid; ?> .career-team-col-in { flex-direction:column; align-items:flex-start; gap:8px; padding:10px 0; }
            #<?php echo $uid; ?> .career-role { width:100%; }
            #<?php echo $uid; ?> .career-location { width:100%; text-align:left; font-size:16px; }
            #<?php echo $uid; ?> .career-row .career-role { font-size: 18px; }
        }
        </style>

        <script>
        (function(){
            var widgetId = '<?php echo esc_js($uid); ?>';
            var widgetEl = document.getElementById(widgetId);
            if (!widgetEl) return;

            var filterSelect = widgetEl.querySelector('.career-team-filter');
            var contentEl = widgetEl.querySelector('#' + widgetId + '_content');

            function getUrlParameter(name) {
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results ? decodeURIComponent(results[1].replace(/\+/g, ' ')) : null;
            }

            function updateUrlParameter(key, value) {
                var url = new URL(window.location.href);
                if (value === 'all' || !value) url.searchParams.delete(key);
                else url.searchParams.set(key, value);
                window.history.pushState({}, '', url.href);
            }

            function filterCareers(termSlug) {
                if (!contentEl) return;
                var allGroups = contentEl.querySelectorAll('.career-team-group');
                var visibleCount = 0;

                allGroups.forEach(function(group) {
                    var groupVisible = false;
                    var rows = group.querySelectorAll('.career-row');
                    rows.forEach(function(row) {
                        var show = !termSlug || termSlug === 'all' || row.getAttribute('data-filter-value') === termSlug;
                        row.style.display = show ? '' : 'none';
                        if (show) { groupVisible = true; visibleCount++; }
                    });
                    group.style.display = groupVisible ? '' : 'none';
                });

                var emptyMsg = contentEl.querySelector('.career-empty');
                if (visibleCount === 0) {
                    if (!emptyMsg) {
                        emptyMsg = document.createElement('div');
                        emptyMsg.className = 'career-empty';
                        emptyMsg.textContent = 'No careers found.';
                        contentEl.appendChild(emptyMsg);
                    }
                    emptyMsg.style.display = '';
                } else if (emptyMsg) {
                    emptyMsg.style.display = 'none';
                }
            }

            if (filterSelect) {
                filterSelect.addEventListener('change', function(){
                    var val = this.value || 'all';
                    updateUrlParameter('career_filter', val);
                    filterCareers(val);
                });
            }

            var urlFilter = getUrlParameter('career_filter');
            if (urlFilter && filterSelect) {
                filterSelect.value = urlFilter;
                filterCareers(urlFilter);
            }

            window.addEventListener('popstate', function() {
                var urlFilter = getUrlParameter('career_filter');
                if (filterSelect) filterSelect.value = urlFilter || 'all';
                filterCareers(urlFilter || 'all');
            });
        })();
        </script>
        <?php
    }

    private function render_careers_list($grouped_careers, $filter_taxonomy) {
        if (empty($grouped_careers)) {
            echo '<div class="career-empty">No careers found.</div>';
            return;
        }

        foreach ($grouped_careers as $team_slug => $group) {
            if (empty($group['posts'])) continue;
            $term = $group['term'] ?? (object)['name' => 'Uncategorized', 'slug' => 'uncategorized'];
            echo '<div class="career-team-group"><h3 class="team-title">' . esc_html($term->name) . '</h3>';
            echo '<div class="career-team-group-right">';

            foreach ($group['posts'] as $post_id) {
                $filter_terms = get_the_terms($post_id, $filter_taxonomy);
                $filter_slug = (!empty($filter_terms) && !is_wp_error($filter_terms)) ? $filter_terms[0]->slug : 'all';
                $permalink = get_permalink($post_id);
                
                // echo '<div class="career-row" data-filter-value="' . esc_attr($filter_slug) . '">';
                echo '<a class="career-row" data-filter-value="' . esc_attr($filter_slug) . '" href="' . esc_url($permalink) . '">';
                echo '<div class="career-team-col"></div>';
                echo '<div class="career-team-col-in">';
                echo '<div class="career-role">' . esc_html(get_the_title($post_id)) . '</div>';
                echo '<div class="career-location">' . esc_html(self::get_location_string($post_id)) . '</div>';
                echo '</div>';
                echo '</a>';
                // echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
}
