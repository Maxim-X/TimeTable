<?PHP
/**
 * 
 */
class Account
{
	public static $AUTH = false;
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
			self::$AUTH = true;
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
	public static function auth($login, $password){
		
		echo "string";
		// echo R::testConnection();
		// $_SESSION['user_id'] = 1;
	}

	# password ; mail ; salt
	public static function signup($user_info){
		$user_info = self::trim_info($user_info);

		# проверка валидности email
		$email_valid = self::email_valid($user_info['email']);
		if (!$email_valid['status']) {
			return ["status" => false, "message" => $email_valid['message']];
		}

		# проверка валидности пароля
		$password_valid = self::password_valid($user_info['password']);
		if (!$password_valid['status']) {
			return ["status" => false, "message" => $password_valid['message']];
		}

		return ["status" => true, "message" => "Успешная регистрация!"];
	}

	public static function auth_id(){
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

	private static function email_valid($email){
		if (!isset($email) || empty($email)) {
			return ["status" => false, "message" => "E-mail адрес не указан!"];
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return ["status" => true, "message" => "E-mail адрес указан верно!"];
		}else{
			return ["status" => false, "message" => "E-mail адрес указан неверно!"];
		}
	}

	private static function password_valid($password){
		if (!isset($password) || empty($password)) {
			return ["status" => false, "message" => "Пароль не указан!"];
		}
		if (strlen($password) <= 8) {
        	return ["status" => false, "message" => "Пароль должен содержать не менее 8 символов!"];
	    }
	    if(!preg_match("#[0-9]+#",$password)) {
        	return ["status" => false, "message" => "Пароль должен содержать не менее 1 цифры!"];
	    }
	    if(!preg_match("#[A-Z]+#",$password)) {
        	return ["status" => false, "message" => "Пароль должен содержать не менее 1 заглавной буквы!"];
	    }
	    if(!preg_match("#[a-z]+#",$password)) {
        	return ["status" => false, "message" => "Пароль должен содержать не менее 1 строчной буквы!"];
	    } 

	    return ["status" => true, "message" => "Пароль указан верно!"];


	}

	private static function trim_info($info){
		foreach ($info as &$value) {
			$value = trim($value);
		}
		return $info;
	}
}