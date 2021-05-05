<?PHP 

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Панель диспетчера";
Route::$DESCRIPTION = "Панель диспетчера";

$count_students = R::count("accounts_generated", "account_type = ?", array("1"));
