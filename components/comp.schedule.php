<?PHP
  
if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}
$id_group = htmlspecialchars(trim($_GET['id']));

$group = R::findOne('groups_students', 'id = ?', array($id_group));

if (!$group) {
	die('Группа не найдена!'); 
}
if ($group->id_institution != Account::$INSTITUTION_ID) {
	die('У вас нет доступа к данной группе!'); 
}

Route::$TITLE = "Расписание для группы " . $group->name;
Route::$DESCRIPTION = "Расписание для группы " . $group->name;

if ($group->use_sunday == 0) {
	$day_of_the_week = R::find("day_of_the_week", "id != ?", array(7));
}else{
	$day_of_the_week = R::find("day_of_the_week");
}

// foreach ($day_of_the_week as $day) {
// 	echo $day->name;
// }