<?PHP 
//Выход из аккаунта
if (isset($_GET["exit"])) {
	Account::exit();
}
Route::$TITLE = "Авторизация";
Route::$DESCRIPTION = "Авторизация";

if (Account::$AUTH) {
	header('Location: /');
	exit;
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