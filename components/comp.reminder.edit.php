<?php

// Проверка на авторизацию

if (Account::$AUTH) {
	header('Location: /');
	die();
}

// Сбрасываем старый пароль

if (isset($_POST["reminderEditUser"])) {
	$new_password = htmlspecialchars($_POST["inputPassword"]);
	$recaptcha = $_POST['g-recaptcha-response'];

	$request_reminder = R::findOne("reminder_password", "key_reminder = ?", array($_GET['key']));

	if (isset($_GET['key']) && $request_reminder) {

		if(!empty($recaptcha))
		{
			// Изменяем пароль
			$request_reminder = account::edit_password($new_password, $request_reminder->user_id);

			if ($request_reminder["status"]) {
				$success_reminder = $request_reminder["message"];
				
				// Удаляем запрос на изменение пароля
				R::hunt("reminder_password", "key_reminder = ?", array($_GET['key']));
			}else{
				$error_reminder = $request_reminder["message"];
			}
			
		}else{
			$error_reminder = "Вы не прошли проверку ReCAPTCHA!";
		}
	}else{
		$error_reminder = "Запрос на изменение пароля не найден!";
	}
}