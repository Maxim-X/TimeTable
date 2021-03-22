<?PHP 

if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Аккаунт";
Route::$DESCRIPTION = "Аккаунт";
