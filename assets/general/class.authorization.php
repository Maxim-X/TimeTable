<?PHP 
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php");
/**
 * Класс для авторизации пользователей
 */
class Authorization 
{
	public static function email_valid($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return ["status" => true, "message" => "E-mail адрес указан верно!"];
		}else{
			return ["status" => false, "message" => "E-mail адрес указан неверно!"];
		}
	}

	public static function 

	public static function auth(){ //$login, $password
		echo R::testConnection();
	}	
}