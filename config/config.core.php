<?PHP
class Core
{
	public static $NAME_SITE;
	
	public static function init(){
		$config_core = R::load('config', '1');
		self::$NAME_SITE = $config_core->name_site;
	}

}