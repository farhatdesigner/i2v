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
    }
    public function register_widgets()
    {
    	$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Home_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Customtabsolution() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Insightsupdates() );
    }
	public function __construct()
	{
		add_action('elementor/widgets/widgets_registered',[$this,'register_widgets'], 99);
	}
}
// Instantiate Plugin Class
Widget_Loader::instance();

?>