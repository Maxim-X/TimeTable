<?PHP 

if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}
$_OPTIMIZATION["title"] = "Аккаунт";
$_OPTIMIZATION["description"] = "Î íàøåì ïðîåêòå";
$_OPTIMIZATION["keywords"] = "Íåìíîãî î íàñ è î íàøåì ïðîåêòå";