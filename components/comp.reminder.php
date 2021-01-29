<?php

// Проверка на авторизацию
if (Account::$AUTH) {
	header('Location: /');
	die();
}

// Востановление пароля
if (isset($_POST["reminderUser"])) {
	$email = htmlspecialchars($_POST["inputEmail"]);

	$recaptcha = $_POST['g-recaptcha-response'];

	if(!empty($recaptcha))
	{
		// отправляем запрос на востановление пароля
		$request_reminder = account::request_reminder_password($email);

		if ($request_reminder["status"]) {
			$success_reminder = $request_reminder["message"];
		}else{
			$error_reminder = $request_reminder["message"];
		}
		
	}else{
		$error_reminder = "Вы не прошли проверку ReCAPTCHA!";
	}
}
