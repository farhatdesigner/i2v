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
            'author_name',
            [
                'label' => esc_html__('Author Name', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_designation',
            [
                'label' => esc_html__('Designation / Company', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'placeholder' => esc_html__('e.g. Deepwater Drilling Solutions', 'repindia'),
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
                        'testimonial_text' => esc_html__('In our industry, compliance is critical. The real-time monitoring and safety gear detection capabilities ensure our workers adhere to protocols.', 'repindia'),
                        'author_name' => 'Ekanga Nuregesan',
                        'author_designation' => 'Deepwater Drilling Solutions',
                    ],
                    [
                        'testimonial_text' => esc_html__('This is the app that I have been looking for. It works beautifully.', 'repindia'),
                        'author_name' => 'Marco',
                        'author_designation' => 'Tech Solutions Inc.',
                    ],
                    [
                        'testimonial_text' => esc_html__('This has continued to evolve and now has API access. I am very pleased with this one!', 'repindia'),
                        'author_name' => 'Babbly',
                        'author_designation' => 'Innovation Labs',
                    ],
                    [
                        'testimonial_text' => esc_html__('I jumped on this and I am amazed! They have done the best job I have ever seen.', 'repindia'),
                        'author_name' => 'FPro',
                        'author_designation' => 'Enterprise Corp',
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
        $name = !empty($item['author_name']) ? $item['author_name'] : '';
        $designation = !empty($item['author_designation']) ? $item['author_designation'] : '';
        $avatar_url = !empty($item['author_avatar']['url']) ? $item['author_avatar']['url'] : '';

        ob_start();
        ?>
        <div class="lt-testimonial-card">
            <?php if (!empty($text)) : ?>
                <p class="lt-testimonial-text"><?php echo wp_kses_post($text); ?></p>
            <?php endif; ?>
            <div class="lt-author">
                <?php if (!empty($avatar_url)) : ?>
                    <div class="lt-author-avatar"><img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($name); ?>"></div>
                <?php else : ?>
                    <div class="lt-author-icon"><svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_10802_19082)"><mask id="mask0_10802_19082" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="140" height="140"><path d="M140 0H0V140H140V0Z" fill="white"/></mask><g mask="url(#mask0_10802_19082)"><path d="M140 70C140 31.3401 108.66 0 70 0C31.3401 0 0 31.3401 0 70C0 83.0468 3.56931 95.2599 9.78473 105.716C21.9511 126.184 44.2564 139.92 69.7762 140C69.8508 140 69.9254 140 70 140C71.4367 140 72.8633 139.957 74.2785 139.871C99.3354 138.361 120.837 123.669 131.941 102.638C137.087 92.8927 140 81.7866 140 70Z" fill="#E6E6E6"/><path fill-rule="evenodd" clip-rule="evenodd" d="M131.942 102.638C120.837 123.669 99.3358 138.361 74.279 139.871C73.7825 139.898 73.2854 139.921 72.7878 139.939C71.7835 139.977 70.7796 139.997 69.7766 140C44.2569 139.92 21.9516 126.184 9.78516 105.716C10.298 103.769 12.189 98.8699 14.2528 97.2237C20.3333 92.3785 33.9761 88.7095 43.6068 86.1195C46.6239 85.3082 49.2475 84.6026 51.1211 84C54.8312 99.4781 85.1511 103.577 92.3465 84.3095C95.1827 85.7821 100.034 87.335 105.377 89.0453C112.617 91.363 120.761 93.9699 126.021 97.0588C128.766 98.6699 130.628 100.539 131.942 102.638Z" fill="#5F6F94"/><path fill-rule="evenodd" clip-rule="evenodd" d="M53.7219 45.8843L53.6669 45.8247C53.2469 44.5395 52.5245 43.3369 50.8627 43.3369L50.8533 43.2802C48.0816 26.6402 51.4826 14.1932 69.7039 13.0549C80.0905 12.4053 94.5567 17.4845 94.4363 30.4303C94.7093 34.7442 94.8074 39.6886 94.5 44C94.3883 43.9636 94.117 43.5092 94 43.5C93.6214 43.4752 93.3143 43.3975 92.9974 43.6198C92.3134 44.0995 91.771 45.1124 91.3605 46.4757L91.3493 46.4897C91.2905 46.5695 91.2303 46.6493 91.1631 46.7319L91.1337 46.6039C91.0111 46.0704 90.8826 45.5114 90.75 44.9366C90.2107 39.8283 89.2898 34.7668 87.995 29.7942C87.8879 29.7055 87.7781 29.6101 87.6642 29.511C85.9321 28.005 82.9872 25.4445 65.8554 25.9554C63.7316 25.3436 57.916 29.7564 57.8446 29.8754C56.7907 31.7646 56.0904 33.8304 55.7782 35.971C54.6405 42.3803 54.5948 43.5523 54.5572 44.5166C54.5376 45.0187 54.5202 45.4645 54.352 46.5639C54.1825 46.3965 54.0203 46.2219 53.8657 46.0403L53.7219 45.8843Z" fill="#5F6F94"/><path fill-rule="evenodd" clip-rule="evenodd" d="M54.5568 44.5162C54.5373 45.0183 54.5199 45.4641 54.3517 46.5635C54 46 54 46 53.6666 45.8243C53.2466 44.5391 52.5242 43.3365 50.8624 43.3365L50.8529 43.2798C50.7153 43.3252 50.5842 43.39 50.4638 43.4727C48.9042 44.5003 48.3106 48.3503 49.5566 51.9861C49.7664 52.5981 49.9657 53.2059 50.1571 53.79C51.2754 57.2015 52.1758 59.9483 53.9778 59.8443C54.9926 59.7928 55.2678 59.135 55.2477 57.9116C55.8558 60.1216 56.7044 62.2575 57.7505 64.3011C57.7503 64.3101 57.7534 64.3445 57.757 64.3516C58.1432 67.3399 58.377 70.3459 58.4575 73.3577C58.4575 73.4977 58.4295 74.4455 58.3931 75.4577C58.2433 79.8299 53.7826 83.0174 49.5 84.5C60.4732 103.62 84.6574 104.414 96.5 86C96.3037 85.9094 96.0478 85.8354 95.7803 85.7581C95.5164 85.6817 95.2408 85.6021 95 85.5C91.9743 84.2178 87.6759 81.8314 87.1463 78.0575C86.9088 76.247 86.7834 74.4236 86.7711 72.5975C86.7533 70.2767 86.8181 67.8921 87.0251 65.4046L87.0805 65.2909C88.2184 63.1195 89.0805 60.8221 89.6506 58.4379C89.6744 59.4515 89.9796 60.0017 90.9008 60.0619C92.701 60.1813 93.6287 57.447 94.7814 54.0495C94.9797 53.465 95.1846 52.861 95.4018 52.2485C96.7962 48.3131 96.0178 44.1005 94.1544 43.5209C94.0427 43.4845 93.927 43.4612 93.81 43.4523C93.5209 43.4333 93.25 43.4917 92.997 43.6194C91.8849 44.3995 92 45.5 91 46.5C90.9443 45.8572 90.8173 45.5776 90.7496 44.9362C90.2103 39.8279 89.2895 34.7664 87.9947 29.7939C87.8875 29.7051 87.7778 29.6097 87.6638 29.5106C85.9318 28.0046 82.9869 25.4441 65.8551 25.955C63.7313 25.3432 57.9157 29.7561 57.8443 29.8751C56.7904 31.7642 56.0901 33.8301 55.7779 35.9707C54.6402 42.3799 54.5944 43.5519 54.5568 44.5162Z" fill="white"/></g></g><defs><clipPath id="clip0_10802_19082"><rect width="140" height="140" fill="white"/></clipPath></defs></svg></div>
                <?php endif; ?>
                <div class="lt-author-info">
                    <?php if (!empty($name)) : ?>
                        <span class="lt-author-name"><?php echo esc_html($name); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($designation)) : ?>
                        <span class="lt-author-designation"><?php echo esc_html($designation); ?></span>
                    <?php endif; ?>
                </div>
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
            .leaders-testimonial-marquee .lt-marquee-row { overflow: hidden; margin-bottom: 40px; }
            .leaders-testimonial-marquee .lt-marquee-row:last-child { margin-bottom: 0; }
            .leaders-testimonial-marquee .lt-marquee-track { display: flex; flex-wrap: nowrap; gap: 40px; width: max-content; }
            .leaders-testimonial-marquee .lt-testimonial-card { flex-shrink: 0; width: 340px; min-height: 180px; background: #fff; border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
            .leaders-testimonial-marquee .lt-testimonial-text { color: #5C5C5C; font-size: 18px;font-style: normal;font-weight: 500;line-height: 26px!important; margin: 0 0 13px 0; }
            .leaders-testimonial-marquee .lt-author { display: flex; align-items: center; gap: 12px; }
            .leaders-testimonial-marquee .lt-author-info { display: flex; flex-direction: column; gap: 2px; }
            .leaders-testimonial-marquee .lt-author-avatar { width: 48px; height: 48px; border-radius: 48px; overflow: hidden; flex-shrink: 0; }
            .leaders-testimonial-marquee .lt-author-avatar img { width: 100%; height: 100%; object-fit: cover;border-radius: 48px; }
            .leaders-testimonial-marquee .lt-author-icon { width: 48px; height: 48px; border-radius: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
            .leaders-testimonial-marquee .lt-author-icon svg { width: 48px; height: 48px;border-radius: 48px; }
            .leaders-testimonial-marquee .lt-author-name { color: #06283D; font-size: 16px;font-style: normal;font-weight: 500;line-height: 24px; }
            .leaders-testimonial-marquee .lt-author-designation { color: #5C5C5C; font-size: 14px;font-style: normal;font-weight: 400;line-height: 20px; }
            .leaders-testimonial-marquee .lt-marquee-row.lt-scroll-left .lt-marquee-track { animation: lt-marquee-left var(--lt-speed, 40s) linear infinite; }
            .leaders-testimonial-marquee .lt-marquee-row.lt-scroll-right .lt-marquee-track { animation: lt-marquee-right var(--lt-speed, 40s) linear infinite; }
            .leaders-testimonial-marquee.lt-pause-hover:hover .lt-marquee-track { animation-play-state: paused !important; }
            @keyframes lt-marquee-left { from { transform: translateX(0); } to { transform: translateX(-50%); } }
            @keyframes lt-marquee-right { from { transform: translateX(-50%); } to { transform: translateX(0); } }
            @media (max-width: 1024px) { .leaders-testimonial-marquee .lt-testimonial-card { width: 300px; min-height: 160px; padding: 20px; } .leaders-testimonial-marquee .lt-testimonial-text { font-size: 14px; } }
            @media (max-width: 768px) { .leaders-testimonial-marquee .lt-testimonial-card { width: 260px; min-height: 150px; padding: 18px; } .leaders-testimonial-marquee .lt-testimonial-text { font-size: 14px;line-height: 24px!important; } .leaders-testimonial-marquee .lt-marquee-track { gap: 14px; } .leaders-testimonial-marquee .lt-marquee-row { margin-bottom: 14px; }.leaders-testimonial-marquee .lt-author-avatar,.leaders-testimonial-marquee .lt-author-icon,.leaders-testimonial-marquee .lt-author-icon svg { width: 36px;height: 36px;border-radius: 100%; } }
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
