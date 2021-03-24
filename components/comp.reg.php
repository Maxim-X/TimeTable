<?PHP 
Route::$TITLE = "Регистрация";
Route::$DESCRIPTION = "Регистрация";

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

		if (isset($_POST['reg_step_2'])) {
			$user_name			= $_POST['inputName'];
			$user_surname		= $_POST['inputSurname'];
			$user_middlename 	= $_POST['inputMiddlename'];

			$user_info = array("name" 		 => $user_name,
							   "surname" 	 => $user_surname,
							   "middle_name" => $user_middlename);

			$add_fio = Account::add_fio($user_info);
			if (!$add_fio['status']) {
				$error_reg = $add_fio['message'];
			}else{
				header('Location: /reg/3');
			}
		}
		
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
		header('Location: /');
	}


	if (isset($_POST['reg_step_3'])) {
		$key_invite = $_POST['inputCode'];
		$invite = Account::add_institution($key_invite);
		if (!$invite['status']) {
			$error_reg = $invite['message'];
		}else{
			header('Location: /');
		}
	}

	if (isset($_POST['deleteUser'])){
        $delete = Account::delete_account();
        if (!$delete['status']) {
            $error_reg = $delete['message'];
        }else{
            header('Location: /');
        }
    }

	// код добавления в команду и удаления аккаунта
}

if ($_GET['step'] == "4") {

	// Проверяем выполнение второго шага
	if (check_step_2()) {
		header('Location: /reg/2');
	}

	$all_time_zone = R::find("time_zones");
	$all_type_inst = R::find("types_institutions");



	// Добавление учебного заведения
	if (isset($_POST['reg_step_4'])) {
		$type_inst 			= $_POST['type_inst'];
		$fullNameInst 		= $_POST['inputFullNameInst'];
		$shortNameInst 		= $_POST['inputShortNameInst'];
		$timeZoneInst 		= $_POST['inputTimeZoneInst'];
		$offRepresentative 	= $_POST['officialRepresentative'];

		// Информация для добавления учебного заведения
		$inst_data = array( 'type_inst' 		=> $type_inst,
							'fullNameInst' 		=> $fullNameInst,
							'shortNameInst' 	=> $shortNameInst,
							'timeZoneInst' 		=> $timeZoneInst,
							'offRepresentative' => $offRepresentative );

		// Добавление уч. заведения
		$add_institution = Institution::add_institution($inst_data);
		if (!$add_institution['status']) {
			$error_reg = $add_institution['message'];
		}else{
			header('Location: /');
		}
	}
}
