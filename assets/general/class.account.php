<?PHP
/**
 * 
 */
class Account
{
	public static $AUTH = "false";
	public static $ID;
	public static $EMAIL;
	public static $LOGIN;
	public static $NAME;
	public static $SURNAME;
	public static $MIDDLENAME;
	protected static $ACCESSLEVEL;

	public static function init()
	{
		if (self::auth_check()) {
			self::$AUTH = "true";
			self::$ID = $_SESSION['user_id'];
			// $user_data = R::
			self::$EMAIL = 		$user_data["email"];
			self::$LOGIN = 		$user_data["login"];
			self::$NAME = 		$user_data["name"];
			self::$SURNAME = 		$user_data["surname"];
			self::$MIDDLENAME = 	$user_data["middlename"];
			self::$ACCESSLEVEL = 	$user_data["accesslevel"];
		}
	}
	public static function auth(){
		echo "string";
		// echo R::testConnection();
		// $_SESSION['user_id'] = 1;
	}

	public static function auth_check(){
		if (isset($_SESSION['user_id'])) {
			return true;
		}
		return false;
	}

	public static function email_valid($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return ["status" => true, "message" => "E-mail адрес указан верно!"];
		}else{
			return ["status" => false, "message" => "E-mail адрес указан неверно!"];
		}
	}
}