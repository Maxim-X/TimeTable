<?PHP 

if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Панель диспетчера";
Route::$DESCRIPTION = "Панель диспетчера";

$count_students = R::count("accounts_generated", "account_type = ?", array("1"));
