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

	 
	# SESSION
	private static $sess_user_id = "user_id";

	public static function init()
	{
		if (self::auth_check()) {
			$user_data_db = R::findOne('accounts', $_SESSION[$sess_user_id]);
			if ($user_data_db) {
				self::$AUTH 		= true;
				self::$ID 			= $user_data_db->id;
				self::$EMAIL 		= $user_data_db->email;
				// self::$LOGIN 		= $user_data["login"];
				// self::$NAME 		= $user_data["name"];
				// self::$SURNAME 		= $user_data["surname"];
				// self::$MIDDLENAME 	= $user_data["middlename"];
				// self::$ACCESSLEVEL 	= $user_data["accesslevel"];
			}
		}
	}
	public static function auth($email, $password){
		$user_data_db = R::findOne('accounts', 'email = ?', array($email));
		if ($user_data_db) {
			if (password_verify($password.$user_data_db->salt, $user_data_db->password) ) {
				$_SESSION[$sess_user_id] = $user_data_db->id;
				return array("status" => true, "user_id" => $user_data_db->id, "message" => "Успешная авторизация!");
			}else{
				return array("status" => false, "message" => "Неверно введен пароль!");
			}
			
		}else{
			return array("status" => false, "message" => "Пользователь с таким E-mail не найден!");
		}
		// echo R::testConnection();
		// $_SESSION['user_id'] = 1;
	}

	public static function exit(){
		unset($_SESSION[$sess_user_id]);
		if (!isset($_SESSION[$sess_user_id])) {
			return array("status" => true, "message" => "Вы вышли из аккаунта!");
		}else{
			return array("status" => false, "message" => "Ошибка выхода из аккаунта!");
		}
	}

	// Регистрация пользователя
	// => $user_info - массив данных для регистрации
	// 	  [ "email" - Почта, "password" - Пароль ]
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

		# генерация соли для пароля
		$permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$salt = substr(str_shuffle($permitted_chars), 0, 10);

		$password = password_hash($user_info['password'].$salt, PASSWORD_DEFAULT);

		# регистрируем пользователя
		$user = R::dispense('accounts');
		$user->email 	= $user_info['email'];
		$user->password = $password;
		$user->salt = $salt;
		R::store($user);

		return ["status" => true, "message" => "Успешная регистрация! ".$password];
	}

	public static function auth_id(){
		echo "string";
		// echo R::testConnection();
		// $_SESSION['user_id'] = 1;
	}

	public static function auth_check(){
		if (isset($_SESSION[$sess_user_id])) {
			return true;
		}
		return false;
	}

	private static function email_valid($email){
		if (!isset($email) || empty($email)) {
			return array("status" => false, "message" => "E-mail адрес не указан!");
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		return array("status" => true, "message" => "E-mail адрес указан верно!");
		}else{
			return array("status" => false, "message" => "E-mail адрес указан неверно!");
		}
	}

	private static function password_valid($password){
		if (!isset($password) || empty($password)) {
			return array("status" => false, "message" => "Пароль не указан!");
		}
		if (strlen($password) <= 8) {
        	return array("status" => false, "message" => "Пароль должен содержать не менее 8 символов!");
	    }
	    if(!preg_match("#[0-9]+#",$password)) {
        	return array("status" => false, "message" => "Пароль должен содержать не менее 1 цифры!");
	    }
	    if(!preg_match("#[A-Z]+#",$password)) {
        	return array("status" => false, "message" => "Пароль должен содержать не менее 1 заглавной буквы!");
	    }
	    if(!preg_match("#[a-z]+#",$password)) {
        	return array("status" => false, "message" => "Пароль должен содержать не менее 1 строчной буквы!");
	    } 

	    return array("status" => true, "message" => "Пароль указан верно!");


	}

	private static function trim_info($info){
		foreach ($info as &$value) {
			$value = trim($value);
		}
		return $info;
	}
}