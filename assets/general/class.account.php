<?PHP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"].'/assets/modules/phpmailer/Exception.php';
require $_SERVER["DOCUMENT_ROOT"].'/assets/modules/phpmailer/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"].'/assets/modules/phpmailer/SMTP.php';

/**
 * 
 */
class Account
{
	public static $AUTH = false;
	public static $ID;
	public static $EMAIL;
	public static $SESSION_KEY;
	public static $LOGIN;
	public static $NAME;
	public static $SURNAME;
	public static $MIDDLENAME;
	public static $INSTITUTION_ID;
	public static $GROUP_ID;
	public static $AFFILIATION;
	public static $ACCOUNT_TYPE;
	public static $GROUP_NAME;
	protected static $ACCESSLEVEL;

	 
	# SESSION
	private static $sess_user_key = "key_session";

	#
	private static $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	public static function init(){

		# Удаляем все устаревшие сессии
		self::delete_all_session_db();

		if (self::auth_check()) {
			$user_session = R::findOne('sessions', 'key_session = ?', array($_SESSION[self::$sess_user_key]));
			if ($user_session->type_account == 3) {
				$user_data_db = R::findOne('accounts', 'id = ?', array($user_session['user_id']));
			}else if($user_session->type_account == 1 || $user_session->type_account == 2){
				$user_data_db = R::findOne('accounts_generated', 'id = ?', array($user_session['user_id']));
			}

			// Информация о должности пользователя
			$affiliation_name = R::findOne('types_account', 'id = ?', array($user_data_db->account_type))->name;



			// Обновляем сессию
			$user_session->date_add = strtotime(date("Y-m-d H:i:s"));;
			R::store($user_session);

			if ($user_data_db) {

				// Информация о пользователе (Общая)
				self::$AUTH 			= true;
				self::$ID 				= $user_data_db->id;
				self::$SESSION_KEY 		= $_SESSION[self::$sess_user_key];
				self::$LOGIN 			= $user_data_db->login;
				self::$NAME 			= $user_data_db->name;
				self::$SURNAME 			= $user_data_db->surname;
				self::$MIDDLENAME 		= $user_data_db->middle_name;
				self::$AFFILIATION		= $affiliation_name;
				self::$ACCOUNT_TYPE		= $user_data_db->account_type;
				self::$INSTITUTION_ID 	= 0;
				self::$GROUP_ID 		= 0;

				// Информация о диспетчере
				if (self::$ACCOUNT_TYPE == 3) {
					self::$EMAIL 			= $user_data_db->email;
					self::$INSTITUTION_ID 	= $user_data_db->institution_id;
				}

				// Информация об обучающемся
				if (self::$ACCOUNT_TYPE == 1) {
					// Информация о группе
					$group = R::findOne('groups_students', 'id = ?', array($user_data_db->group_id));
					self::$GROUP_ID = $user_data_db->group_id;
					self::$INSTITUTION_ID 	= $user_data_db->institution_id;
					self::$GROUP_NAME 	= $group->name;
				}

				// Информация об преподавателе
				if (self::$ACCOUNT_TYPE == 2) {
					self::$INSTITUTION_ID 	= $user_data_db->institution_id;
				}

				// self::$ACCESSLEVEL 	= $user_data["accesslevel"];
			}
		}
	}

	public static function auth($login, $password){

		if (!self::auth_check()) {
			$user_data_db = R::findOne('accounts', 'login = ? OR email = ?', array($login, $login));
			$user_generated = false;
			if (!$user_data_db) {
				$user_data_db = R::findOne('accounts_generated', 'login = ?', array($login));
				$user_generated = true;
			}
			if ($user_data_db) {
				if (($user_generated && $password == $user_data_db->password) || (password_verify($password.$user_data_db->salt, $user_data_db->password)) ) {

					# Создаем сессию
					$add_session = self::add_session($user_data_db->id, $user_generated);
					if ($add_session["status"]) {
						return array("status" => true, "user_id" => $user_data_db->id, "message" => "Успешная авторизация!");
					}else{
						return array("status" => false, "message" => $add_session["message"]);
					}

					
				}else{
					return array("status" => false, "message" => "Неверно введен пароль!");
				}
				
			}else{
				return array("status" => false, "message" => "Пользователь с таким логином или email не найден!");
			}
		}else{
			return array("status" => false, "message" => "Вы уже авторизованы!");
		}
	}

	public static function exit(){
		R::hunt('sessions', 'key_session = ?', array($_SESSION[self::$sess_user_key]));
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

		# проверка валидности логина
		$login_valid = self::login_valid($user_info['login']);
		if (!$login_valid['status']) {
			return ["status" => false, "message" => $login_valid['message']];
		}

		if (strlen($user_info['login']) < 5){
		    return ["status" => false, "message" => "Логин должен состоять не менее чем из 5 символов!"];
        }

        if (preg_match('/Account|account/m', $user_info['login'])) {
			return ["status" => false, "message" => "Логин пользователя не должен содеражать слово 'Account'!"];
		}

        $pattern = '/^[a-zA-Z][a-zA-Z0-9]{4,20}$/U';
        if (!preg_match($pattern, $user_info['login'])){
            return ["status" => false, "message" => "Логин должен начинаться с буквы и состоять только из латинских букв и/или цифр!"];
        }

		$login_find = R::findOne('accounts', 'login = ?', array($user_info['login']));
		if ($login_find) {
			return ["status" => false, "message" => "Данный логин уже используется!"];
		}

		# проверка валидности email
		$email_valid = self::email_valid($user_info['email']);
		if (!$email_valid['status']) {
			return ["status" => false, "message" => $email_valid['message']];
		}

		$email_find = R::findOne('accounts', 'email = ?', array($user_info['email']));
		if ($email_find) {
			return ["status" => false, "message" => "Данный Email уже используется!"];
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

	public static function signup_system_account($user_info){
		$user_info = self::trim_info($user_info);

		$name 		 	= $user_info['name'];
		$surname 	 	= $user_info['surname'];
		$middle_name 	= $user_info['middle_name'];
		$account_type 	= $user_info['account_type'];
		$group_id 		= $user_info['group_id'];
		$institution_id = $user_info['institution_id'];

		if (empty($name) || empty($surname) || empty($middle_name)) {
			return array("status" => false, "message" => "Информация введена неверно!");
		}

		if ($account_type == 1 && (empty($user_info['group_id']) || $user_info['group_id'] <= 0)) {
			return array("status" => false, "message" => "Группа указана неверно!");
		}

		if ($account_type == 2 && (empty($user_info['institution_id']) || $user_info['institution_id'] <= 0)) {
			return array("status" => false, "message" => "Учебное учреждение указано неверно!");
		}

		$password = self::generation_password(4);
		$login = "Account_";

		# регистрируем пользователя
		$user = R::xdispense('accounts_generated');
		$user->login 	= $login;
		$user->password = $password;
		$user->account_type = $account_type;
		$user->name = $name;
		$user->surname = $surname;
		$user->middle_name = $middle_name;
		if (isset($group_id)) {
			$user->group_id = $group_id;
		}
		if (isset($institution_id)) {
			$user->institution_id = $institution_id;
		}
		
		$user_id = R::store($user);

		$user = R::load('accounts_generated', $user_id);
		$user->login = $login.$user_id;
		$user = R::store($user);
		return array("status" => true, "message" => "Аккаунт успешно добавлен!");
	}

	public static function delete_account(){
	    if (!self::$AUTH){
            return array("status" => false, "message" => "Для удаления аккаунта вам необходимо авторизоваться!");
        }
        echo self::$INSTITUTION_ID;

        if (self::$INSTITUTION_ID != "") {
        	return array("status" => false, "message" => "Ваш аккаунт привязан к учебному заведению, его нельзя удалить!");
        }

        // Выходим из аккаунта и удаляем сессию
        self::exit();

        // Удаляем запросы на восстановление пароля 
        R::hunt('reminder_password', 'user_id = ?', array(self::$ID));

        $delete = R::hunt('accounts', 'id = ?', array(self::$ID));
        var_dump($delete);


        if (!$delete){
            return array("status" => false, "message" => "При удалении аккаунта произошла ошибка, попробуйте позже!");
        }
        

        return array("status" => true, "message" => "Аккаунт удален!");

    }

	public static function add_fio($user_info){
		$name 		 = trim($user_info['name']);
		$surname 	 = trim($user_info['surname']);
		$middle_name = trim($user_info['middle_name']);

		if (empty($name) || empty($surname) || empty($middle_name)) {
			return array("status" => false, "message" => "Информация введена неверно!");
		}

		$add_fio = R::load('accounts', self::$ID);
		$add_fio->name = $name;
		$add_fio->surname = $surname;
		$add_fio->middle_name = $middle_name;
		$add_fio = R::store($add_fio);

		if (!$add_fio) {
			return array("status" => false, "message" => "Ошибка записи в базу данных!");
		}

		return array("status" => true, "message" => "Информация изменена!");
	}

	public static function add_institution($key_invite){
		if (empty($key_invite) || !isset($key_invite)) {
			return array("status" => false, "message" => "Ключ приглашения введен неверно!");
		}

		# Проверка состоит ли пользователь в команде
		if (self::$INSTITUTION_ID != 0) {
			return array("status" => false, "message" => "Вы уже состоите в команде!");
		}

		# Проверка приглашения в команду
		$find_invite = R::findOne('team_invites', 'key_invite = ?', array($key_invite));
		if (!$find_invite) {
			return array("status" => false, "message" => "Приглашение недействительно!");
		}

		$add_institution = R::load('accounts', self::$ID);
		$add_institution->institution_id = $find_invite->institution_id;
		$add_institution = R::store($add_institution);

		if (!$add_institution) {
			return array("status" => false, "message" => "Ошибка записи в базу данных!");
		}

		$edit_status_invite = R::load('team_invites', $find_invite->id);
		$edit_status_invite->status = 1;
		$edit_status_invite = R::store($edit_status_invite);

		return array("status" => true, "message" => "Информация изменена!");


	}

	public static function add_session($user_id, $user_generated){
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

		if ($user_generated) {
			$user_info = R::findOne('accounts_generated', 'id = ?', array($user_id));
		}else{
			$user_info = R::findOne('accounts', 'id = ?', array($user_id));
		}
		

		$session->user_id 		= $user_id;
		$session->key_session 	= $key_session;
		$session->type_account  = $user_info->account_type;
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

	private static function login_valid($login){
		if (!isset($login) || empty($login)) {
			return array("status" => false, "message" => "Логин не указан!");
		}
		if (preg_match("/^[a-zA-Z0-9_-]{2,20}$/i", $login)) {
			return array("status" => true, "message" => "Логин указан верно!");
		} else {
			return array("status" => false, "message" => "Логин указан неверно!");
		}
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
		if (strlen($password) < 8) {
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

	private static function generation_password($iter = 4){
		echo "<hr>";
		$arr_characters = array('a','b','c','d','e','f',
			'g','h','i','j','k','l',
			'm','n','o','p','r','s',
			't','u','v','x','y','z',
			'A','B','C','D','E','F',
			'G','H','I','J','K','L',
			'M','N','O','P','R','S',
			'T','U','V','X','Y','Z',
			'1','2','3','4','5','6',
			'7','8','9','0');
			// Генерируем пароль
			
		do{
			$pass = "";
			for($i = 1; $i < $iter; $i++)
			{
				$sec_pass = "";
				for ($j=0; $j < $iter ; $j++) { 
					$sec_pass .= $arr_characters[rand(0, count($arr_characters) - 1)];
				}
				// $index = rand(0, count($arr_letters) - 1);
				if ($i == $iter - 1) {
					$pass .= $sec_pass;
				}else{
					$pass .= $sec_pass . "-";
				}
			}
		}while(!self::password_valid($pass)['status']);

		return $pass;
	}
}