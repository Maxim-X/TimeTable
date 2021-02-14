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
