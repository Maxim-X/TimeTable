<?PHP 

function check_step_2(){
	if (Account::$AUTH && 
		Account::$NAME == "" || 
		Account::$SURNAME == "" || 
		Account::$MIDDLENAME == "") {
		return true;
	}
	return false;
}

// Маршрутизация авторизации

// Заполняем информацию о пользователе (логин, email, пароль)
if ($_GET['step'] == "1") {
	if (Account::$AUTH) {
		header('Location: /reg/2');
		exit;
	}
	

	
		if (isset($_POST['reg_step_1'])) {
			$recaptcha = $_POST['g-recaptcha-response'];
			if(!empty($recaptcha))
			{
				$user_login		= $_POST['inputLogin'];
				$user_email		= $_POST['inputEmail'];
				$user_password 	= $_POST['inputPassword'];

				$user_info = array("login" 		=> $user_login,
								   "email" 		=> $user_email,
								   "password" 	=> $user_password,
								   "account_type" => "3");

				$signup = Account::signup($user_info);
				if (!$signup['status']) {
					$error_reg = $signup['message'];
				}else{
					// Успешная регистрация
					Account::auth($user_info['login'], $user_info['password']);
					header('Location: /reg/2');
				}
			}else{$error_reg = "Вы не прошли проверку ReCAPTCHA!";}
		}
		

}

if ($_GET['step'] == "2") {
	if (!Account::$AUTH) {
		header('Location: /reg/1');
	}
	if (check_step_2()) {

		// code...
		
	}else{
		header('Location: /reg/3');
	}
}

if ($_GET['step'] == "3") {

	// Проверяем выполнение второго шага
	if (check_step_2()) {
		header('Location: /reg/2');
	}

	if (Account::$INSTITUTION_ID != 0) {
		header('Location: /reg/2');
	}

	// код добавления в команду и удаления аккаунта
}

if ($_GET['step'] == "3") {

	// Проверяем выполнение второго шага
	if (check_step_2()) {
		header('Location: /reg/2');
	}

	// код добавления учебного заведения
}
