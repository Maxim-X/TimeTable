<?PHP 

if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}