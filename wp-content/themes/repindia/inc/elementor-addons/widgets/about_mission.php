<?php
namespace WPC\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH'))
	exit;

class about_mission extends Widget_Base
{
	public function get_name()
	{
		return 'about_mission';
	}
	public function get_title()
	{
		return 'About Mission';
	}
	public function get_icon()
	{
		return 'fa fa-newspaper-o';
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
			'mission_title_img',
			[
				'label' => esc_html__('Mission Title Icon Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$repeater->add_control(
			'main_title',
			[
				'label' => esc_html__('Box Title', 'repindia'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_para',
			[
				'label' => esc_html__('Box Description', 'repindia'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'mission_img',
			[
				'label' => esc_html__('Mission Box Image', 'repindia'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
			]
		);
		$this->add_control(
			'box_list',
			[
				'label' => esc_html__('Box List', 'repindia'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'main_title' => '',
					],
				],
				'title_field' => '{{{ main_title }}}',
			]
		);
		$this->end_controls_section();

	}

	// Php Render
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('custom_class', 'basic'); ?>
		<style>
			@media screen (max-width:767px) {
				body:not(.no-js) .aboutscroller .mission_details { transform: translateY(0px) scale(1.1); }
				body:not(.no-js) .aboutscroller .fading-up { transform: translateY(0px) scale(1.1); }
			}
			.sectionsscroll { width: 100%;position: relative;height: 100vh;display: flex; }
			.flex-center { position: relative; }
			.flex-center>* { display: flex;align-items: center;justify-content: center;height: 100vh;width: 100%;position: absolute;top: 0;left: 0; }
			.flex-center .panel img { height: 100vh; }
			.container-page { width: 50%; }
			.contento { background-color: #fff; }
			.panels { width: 50%;overflow: hidden;position: relative; }
			.flex-center .none-desktop .imgicon img { width: auto !important; }
			.txtflex { padding-right: 50px; }
			@media screen and (min-width:768px) and (max-width:1179px) {
				.panels.flex-center { display: flex !important;gap: 1rem; }
			}
			@media(min-width: 1180px) {
				.imgicon { padding-right: 50px; }
				.none-desktop { display: none; }
			}
			@media(max-width: 1179px) {
				.container-page { display: none; }
				.sectionsscroll,.panels,.flex-center>*,.flex-center .panel img { width: 100% !important;height: auto !important;display: block !important;position: static !important;padding: inherit !important;text-align: left !important; }
				.none-desktop { margin-top: 25px;margin-bottom: 50px;text-align: center; }
			}
		</style>
		<div class="sectionsscroll">
			<div class="container-page flex-center">
				<?php
				$itextcount = 1;
				foreach ($settings['box_list'] as $item_item_text) {
					if ($itextcount == 1) {
						$leftanim = '';
					} else {
						$leftanim = 'animate-left';
					}
					?>
					<div class="contento  <?php echo $leftanim; ?>">
						<div class="imgicon"><?php echo translate($item_item_text['mission_title_icon_svg']); ?></div>
						<div class="txtflex">
							<h2><?php echo translate($item_item_text['main_title']); ?></h2>
							<p><?php echo translate($item_item_text['mission_para']); ?></p>
						</div>
					</div>
					<?php
					$itextcount++;
				} ?>
			</div>
			<div class="panels flex-center">
				<?php
				$imgcount = 1;
				foreach ($settings['box_list'] as $item_item_img) {
					$mission_img = $item_item_img['mission_img'];
					$mission_img_val = wp_get_attachment_image_url($mission_img['id'], 'full');
					$mission_title_img = $item_item_img['mission_title_img'];
					$mission_title_img_val = wp_get_attachment_image_url($mission_title_img['id'], 'full');
					if ($imgcount == 1) {
						$rightanim = '';
					} else {
						$rightanim = 'animate-right';
					} ?>
					<section class="panel <?php echo $rightanim; ?>">
						<img src="<?php echo translate($mission_img_val); ?>">
						<div class="none-desktop">
							<!-- <div class="imgicon"><img src="<?php echo translate($mission_title_img_val); ?>"></div> -->
							<h2><?php echo translate($item_item_img['main_title']); ?></h2>
							<p><?php echo translate($item_item_img['mission_para']); ?></p>
						</div>
					</section>
					<?php
					$imgcount++;
				} ?>
			</div>
		</div>
	<?php
	}
} ?>