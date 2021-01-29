<?PHP 
//Выход из аккаунта
if (isset($_GET["exit"])) {
	echo "1";
	Account::exit();
}

if (Account::$AUTH) {
	echo "True";
}else{
	echo "False";
}

// Авторизация
if (isset($_POST["authUser"])) {
	$login = htmlspecialchars($_POST["inputLogin"]);
	$password = htmlspecialchars($_POST["inputPassword"]);

	$recaptcha = $_POST['g-recaptcha-response'];

	if(!empty($recaptcha))
	{
		$auth = Account::auth($login, $password);
		if ($auth["status"]) {
			header("Location: /");
		}else{
			$error_auth = $auth["message"];
		}
	}else{
		$error_auth = "Вы не прошли проверку ReCAPTCHA!";
	}
}


?>