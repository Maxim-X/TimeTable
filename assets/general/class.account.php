<?PHP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/modules/phpmailer/Exception.php';
require 'assets/modules/phpmailer/PHPMailer.php';
require 'assets/modules/phpmailer/SMTP.php';

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
	private static $sess_user_key = "key_session";

	#
	private static $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	public static function init()
	{
		# Удаляем все устаревшие сессии
		self::delete_all_session_db();

		if (self::auth_check()) {
			$user_session = R::findOne('sessions', 'key_session = ?', array($_SESSION[self::$sess_user_key]));
			$user_data_db = R::findOne('accounts', $user_session['user_id']);

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

	public static function auth($login, $password){
		// dkD3kdmsds
		if (!self::auth_check()) {
			$user_data_db = R::findOne('accounts', 'login = ?', array($login));
			if ($user_data_db) {
				if (password_verify($password.$user_data_db->salt, $user_data_db->password) ) {

					# Создаем сессию
					$add_session = self::add_session($user_data_db->id);
					if ($add_session["status"]) {
						return array("status" => true, "user_id" => $user_data_db->id, "message" => "Успешная авторизация!");
					}else{
						return array("status" => false, "message" => $add_session["message"]);
					}

					
				}else{
					return array("status" => false, "message" => "Неверно введен пароль!");
				}
				
			}else{
				return array("status" => false, "message" => "Пользователь с таким логином не найден!");
			}
		}else{
			return array("status" => false, "message" => "Вы уже авторизованы!");
		}
	}

	public static function exit(){
		R::hunt('reminder_password', 'key_session = ?', array($_SESSION[self::$sess_user_key]));
		unset($_SESSION[self::$sess_user_key]);

		if (!isset($_SESSION[self::$sess_user_key])) {
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
		
		$salt = substr(str_shuffle(self::$permitted_chars), 0, 10);

		$password = password_hash($user_info['password'].$salt, PASSWORD_DEFAULT);

		# регистрируем пользователя
		$user = R::xdispense('accounts');
		$user->login 	= $user_info['login'];
		$user->email 	= $user_info['email'];
		$user->password = $password;
		$user->salt = $salt;
		$user->account_type = $user_info['account_type'];
		R::store($user);
		



		return ["status" => true, "message" => "Успешная регистрация!"];
	}

	public static function add_session($user_id){
		if ($user_id <= 0) {
			return array("status" => false, "message" => "Идентификатор пользователя введен неверно");
		}

		# Удаляем старые сессии пользователя
		R::hunt('sessions', 'user_id = ?', array($user_id));

		# Создаем новую сессию для пользователя
		$session = R::xdispense('sessions');
		do{
			$key_session = substr(str_shuffle(self::$permitted_chars), 0, 20);
		} while (R::findOne('sessions', 'key_session = ?', array($key_session)));

		$session->user_id 		= $user_id;
		$session->key_session 	= $key_session;
		$session->date_add 		= strtotime(date("Y-m-d H:i:s"));

		if(!R::store($session)){
			return array("status" => false, "message" => "Произошла ошибка при создании сессии!");
		}

		$_SESSION[self::$sess_user_key] = $key_session;
		return array("status" => true, "message" => "Сессия успешно созданна!" );

	}

	public static function auth_id(){
		echo "string";
		// echo R::testConnection();
		// $_SESSION['user_id'] = 1;
	}

	public static function auth_check(){
		if (isset($_SESSION[self::$sess_user_key])) {
			$check_session = R::findOne('sessions', 'key_session = ?', array($_SESSION[self::$sess_user_key]));
			if ($check_session) {
				return true;
			}else{
				return false;
			}
			
		}
		return false;
	}

	private static function delete_all_session_db(){
		$time_old_sessions = strtotime(date("Y-m-d H:i:s")) - 1800; // устаревшие сессии
		R::hunt('sessions', 'date_add <= ?', array($time_old_sessions));
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

	public static function request_reminder_password($email){
		// Удаляем старые запросы
		self::delete_reminder_password();
		if (!isset($email)) {
			return array("status" => false, "message" => "E-mail введен некорректно!");
		}

		$user = R::findOne('accounts', 'email = ?', array($email));

		if (!$user) {
			return array("status" => false, "message" => "Пользователь с данным E-mail не найден!!");
		}


		$old_reminder = R::findOne('reminder_password', 'user_id = ?', array($user->id));

		if ($old_reminder) {
			return array("status" => false, "message" => "Запрос на восстановление пароля можно отправлять раз в 15 минут!");
		}

		$reminder = R::xdispense('reminder_password');
		do{
			$key_reminder = substr(str_shuffle(self::$permitted_chars), 0, 10);
		} while (R::findOne('reminder_password', 'key_reminder = ?', array($key_reminder)));

		$reminder->user_id 			= $user->id;
		$reminder->key_reminder 	= $key_reminder;
		$reminder->date_add 		= strtotime(date("Y-m-d H:i:s"));

		if(!R::store($reminder)){
			return array("status" => false, "message" => "Произошла ошибка при восстановлении пароля!");
		}

		//Отправляем инструкцию

		$mail = new PHPMailer;

		$mail->From = "support@timetable.ru";
		$mail->FromName = "Full Name";

		$mail->addAddress($user->email, $user->login);

		$mail->isHTML(true);

		$rem_user_name = $user->login;
		$rem_url = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://'.$_SERVER['SERVER_NAME'].'/reminder/'.$key_reminder; 

		$mail->Subject = "Инструкция по восстановлению пароля || TimeTable";
		$mail->Body = 	"<p>Здравствуйте, {$rem_user_name}</p>";
		$mail->Body .= 	"<p>На ваш аккаунт был создан запрос&nbsp;изменения&nbsp;пароля.</p>";
		$mail->Body .= 	"<p>IP адрес: {$_SERVER['REMOTE_ADDR']}</p>";
		$mail->Body .= 	"<a href=\"{$rem_url}\" class=\"es-button\" target=\"_blank\" style=\"mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;font-size:18px;color:#FFFFFF;border-style:solid;border-color:#2980D9;border-width:10px 40px;display:inline-block;background:#2980D9;border-radius:5px;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center\">Сбросить пароль</a>";
		$mail->AltBody = "";

		try {
			$mail->send();
			return array("status" => true, "message" => "На вашу почту отправленна инструкция для восстановления пароля!");
		} catch (Exception $e) {
			return array("status" => false, "message" => "Mailer Error: " . $mail->ErrorInfo);
		}

		

	}

	private static function delete_reminder_password(){
		$time_old_reminder = strtotime(date("Y-m-d H:i:s")) - 900; // устаревшие запросы
		R::hunt('reminder_password', 'date_add <= ?', array($time_old_reminder));
	}

	public static function edit_password($new_password, $user_id){

		$password_valid = self::password_valid($new_password);
		if (!$password_valid['status']) {
			return array("status" => false, "message" => $password_valid['message']);
		}

		if (!isset($user_id) || !(int)$user_id > 0) {
			return array("status" => false, "message" => "Идентификатор пользователя указан неверно!".gettype($user_id));
		}

		// Проверка валидности пароля

		$password_valid = self::password_valid($new_password);
		if (!$password_valid['status']) {
			return ["status" => false, "message" => $password_valid['message']];
		}


		$edit_account = R::findOne('accounts', 'id = ?', array($user_id));

		if (!$edit_account) {
			return array("status" => false, "message" => "Пользователь не найден!".$user_id);
		}

		// Генерация соли для пароля
		$salt = substr(str_shuffle(self::$permitted_chars), 0, 10);

		// Шифруем пароль
		$password = password_hash($new_password.$salt, PASSWORD_DEFAULT);

		// Изменяем пароль пользователя
		$edit_account->password = $password;
		$edit_account->salt = $salt;

		R::store($edit_account);
		
		return ["status" => true, "message" => "Пароль успешно изменен!"];



	}
}