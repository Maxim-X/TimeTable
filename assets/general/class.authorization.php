<?PHP 
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php");
/**
 * Класс для авторизации пользователей
 */
class Authorization 
{
	public static function auth(){ //$login, $password
		echo R::testConnection();
	}	
}