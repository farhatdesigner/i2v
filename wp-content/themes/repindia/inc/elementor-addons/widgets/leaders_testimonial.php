<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Leaders_Testimonial extends Widget_Base
{
    public function get_name()
    {
        return 'leaders_testimonial';
    }
    public function get_title()
    {
        return 'Leaders Testimonial';
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
            'testimonial_text',
            [
                'label' => esc_html__('Testimonial Text', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('This is an amazing product. Highly recommended!', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'star_rating',
            [
                'label' => esc_html__('Star Rating', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 1,
                'default' => 5,
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => esc_html__('Author Name', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_avatar',
            [
                'label' => esc_html__('Author Avatar', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'testimonial_text' => esc_html__('Tried the new feature, and I am BLOWN AWAY. Absolutely stunning output. Kudos to the team!', 'repindia'),
                        'star_rating' => 5,
                        'author_name' => 'Abhi',
                    ],
                    [
                        'testimonial_text' => esc_html__('This is the app that I have been looking for. It works beautifully.', 'repindia'),
                        'star_rating' => 5,
                        'author_name' => 'Marco',
                    ],
                    [
                        'testimonial_text' => esc_html__('This has continued to evolve and now has API access. I am very pleased with this one!', 'repindia'),
                        'star_rating' => 5,
                        'author_name' => 'Babbly',
                    ],
                    [
                        'testimonial_text' => esc_html__('I jumped on this and I am amazed! They have done the best job I have ever seen.', 'repindia'),
                        'star_rating' => 5,
                        'author_name' => 'FPro',
                    ],
                ],
                'title_field' => '{{{ author_name }}}',
            ]
        );

        $this->add_control(
            'marquee_speed',
            [
                'label' => esc_html__('Marquee Speed (seconds)', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 10,
                        'max' => 120,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 40,
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render_testimonial_card($item)
    {
        $text = !empty($item['testimonial_text']) ? $item['testimonial_text'] : '';
        $rating = isset($item['star_rating']) ? max(0, min(5, (int) $item['star_rating'])) : 5;
        $name = !empty($item['author_name']) ? $item['author_name'] : '';
        $avatar_url = !empty($item['author_avatar']['url']) ? $item['author_avatar']['url'] : '';

        $stars_html = '';
        for ($i = 0; $i < 5; $i++) {
            $stars_html .= '<span class="lt-star' . ($i < $rating ? ' lt-star-filled' : '') . '">★</span>';
        }

        ob_start();
        ?>
        <div class="lt-testimonial-card">
            <?php if (!empty($text)) : ?>
                <p class="lt-testimonial-text"><?php echo wp_kses_post($text); ?></p>
            <?php endif; ?>
            <div class="lt-stars"><?php echo $stars_html; ?></div>
            <div class="lt-author">
                <?php if (!empty($avatar_url)) : ?>
                    <div class="lt-author-avatar"><img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($name); ?>"></div>
                <?php else : ?>
                    <div class="lt-author-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                <?php endif; ?>
                <?php if (!empty($name)) : ?>
                    <span class="lt-author-name"><?php echo esc_html($name); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $testimonials = $settings['testimonials'] ?? [];
        $speed = !empty($settings['marquee_speed']['size']) ? (float) $settings['marquee_speed']['size'] : 40;
        $pause_on_hover = !empty($settings['pause_on_hover']) && $settings['pause_on_hover'] === 'yes';
        $widget_id = 'lt-marquee-' . $this->get_id();

        if (empty($testimonials)) {
            return;
        }

        // Inline CSS - scoped to this widget to avoid affecting other elements
        static $lt_css_added = false;
        if (!$lt_css_added) {
            $lt_css_added = true;
            ?>
            <style id="leaders-testimonial-marquee-css">
            .leaders-testimonial-marquee { width: 100%; overflow: hidden; padding: 24px 0; }
            .leaders-testimonial-marquee .lt-marquee-row { overflow: hidden; margin-bottom: 16px; }
            .leaders-testimonial-marquee .lt-marquee-row:last-child { margin-bottom: 0; }
            .leaders-testimonial-marquee .lt-marquee-track { display: flex; flex-wrap: nowrap; gap: 20px; width: max-content; }
            .leaders-testimonial-marquee .lt-testimonial-card { flex-shrink: 0; width: 340px; min-height: 180px; background: #1a1d24; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
            .leaders-testimonial-marquee .lt-testimonial-text { color: #e8eaed; font-size: 15px; line-height: 1.5; margin: 0 0 16px 0; }
            .leaders-testimonial-marquee .lt-stars { display: flex; gap: 2px; margin-bottom: 16px; }
            .leaders-testimonial-marquee .lt-star { color: #3d4048; font-size: 16px; }
            .leaders-testimonial-marquee .lt-star-filled { color: #f5c518; }
            .leaders-testimonial-marquee .lt-author { display: flex; align-items: center; gap: 12px; }
            .leaders-testimonial-marquee .lt-author-avatar { width: 36px; height: 36px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
            .leaders-testimonial-marquee .lt-author-avatar img { width: 100%; height: 100%; object-fit: cover; }
            .leaders-testimonial-marquee .lt-author-icon { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #8b8f97; }
            .leaders-testimonial-marquee .lt-author-icon svg { width: 20px; height: 20px; }
            .leaders-testimonial-marquee .lt-author-name { color: #e8eaed; font-size: 14px; font-weight: 500; }
            .leaders-testimonial-marquee .lt-marquee-row.lt-scroll-left .lt-marquee-track { animation: lt-marquee-left var(--lt-speed, 40s) linear infinite; }
            .leaders-testimonial-marquee .lt-marquee-row.lt-scroll-right .lt-marquee-track { animation: lt-marquee-right var(--lt-speed, 40s) linear infinite; }
            .leaders-testimonial-marquee.lt-pause-hover:hover .lt-marquee-track { animation-play-state: paused !important; }
            @keyframes lt-marquee-left { from { transform: translateX(0); } to { transform: translateX(-50%); } }
            @keyframes lt-marquee-right { from { transform: translateX(-50%); } to { transform: translateX(0); } }
            @media (max-width: 1024px) { .leaders-testimonial-marquee .lt-testimonial-card { width: 300px; min-height: 160px; padding: 20px; } .leaders-testimonial-marquee .lt-testimonial-text { font-size: 14px; } }
            @media (max-width: 768px) { .leaders-testimonial-marquee .lt-testimonial-card { width: 260px; min-height: 150px; padding: 18px; } .leaders-testimonial-marquee .lt-testimonial-text { font-size: 13px; } .leaders-testimonial-marquee .lt-marquee-track { gap: 14px; } }
            </style>
            <?php
        }
        ?>
        <div class="leaders_testimonial_section leaders-testimonial-marquee <?php echo $pause_on_hover ? 'lt-pause-hover' : ''; ?>" id="<?php echo esc_attr($widget_id); ?>" style="--lt-speed: <?php echo esc_attr($speed); ?>s;">
            <div class="lt-marquee-row lt-scroll-right">
                <div class="lt-marquee-track lt-track-row1">
                    <?php foreach ($testimonials as $item) : echo $this->render_testimonial_card($item); endforeach; ?>
                    <?php foreach ($testimonials as $item) : echo $this->render_testimonial_card($item); endforeach; ?>
                </div>
            </div>
            <div class="lt-marquee-row lt-scroll-left">
                <div class="lt-marquee-track lt-track-row2">
                    <?php foreach ($testimonials as $item) : echo $this->render_testimonial_card($item); endforeach; ?>
                    <?php foreach ($testimonials as $item) : echo $this->render_testimonial_card($item); endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    }
}
