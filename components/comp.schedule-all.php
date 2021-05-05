 <?php 
 if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Расписание для групп " . Institution::$SHORT_NAME;
Route::$DESCRIPTION = "Расписание для групп " . Institution::$SHORT_NAME;

// Таблица групп
$all_groups = R::findAll('groups_students', 'id_institution = ? ORDER BY `id` DESC', array(Account::$INSTITUTION_ID));