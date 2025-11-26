<?php
namespace WPC;
/* */
class Widget_Loader
{
	private static $_instance = null;
	public static function instance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    private static function include_widgets_files()
    {
		require_once(__DIR__.'/widgets/home_banner.php');
		require_once(__DIR__.'/widgets/customtabsolution.php');
		require_once(__DIR__.'/widgets/insightsupdates.php');
		require_once(__DIR__.'/widgets/cardslisting.php');
		require_once(__DIR__.'/widgets/carosoulslider.php');
		require_once(__DIR__.'/widgets/platformtab.php');
		require_once(__DIR__.'/widgets/vertcialaccordion.php');
		require_once(__DIR__.'/widgets/scalescroll.php');
		require_once(__DIR__.'/widgets/custom_tooltip.php');
		require_once(__DIR__.'/widgets/custom_marquee.php');
		require_once(__DIR__.'/widgets/scalescroll.php');
		require_once(__DIR__.'/widgets/video_accordion.php');
		require_once(__DIR__.'/widgets/singlescrollcards.php');
		require_once(__DIR__.'/widgets/custom_testimonial.php');
		require_once(__DIR__.'/widgets/custom_image_circle.php');
		require_once(__DIR__.'/widgets/custom_purpose_slider.php');
    }
    public function register_widgets()
    {
    	$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Home_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Customtabsolution() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Insightsupdates() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Cardslisting() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Carosoulslider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Platformtab() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Vertcialaccordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Scalescroll() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Custom_Tooltip() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Custom_Marquee() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Scalescroll() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Video_accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Singlescrollcards() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Custom_Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Custom_Image_Circle() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Custom_Purpose_Slider() );
    }
	public function __construct()
	{
		add_action('elementor/widgets/widgets_registered',[$this,'register_widgets'], 99);
	}
}
// Instantiate Plugin Class
Widget_Loader::instance();

?>