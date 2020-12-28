<?PHP 
echo $_GET["exit"];
var_dump($_GET);
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
	$auth = Account::auth($login, $password);
	if ($auth["status"]) {
		# code...
	}else{
		$error_auth = $auth["message"];
	}
}


?>