<?PHP 

# Старт сессии
session_start(); 
# Старт буфера
ob_start(); 

define("INDEX", "");

require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.db.php"); // информация о базе данных
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php"); // подключение RedBeanPHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");



// подключение к базе данных
R::setup( "mysql:host=".db::$HostDB."; dbname=".db::$BaseDB, db::$UserDB, db::$PassDB );

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});

if(!R::testConnection()){ 
	echo json_encode(["status"=> false, "message"=> 'Ошибка подключения к Базе Данных!']);
    exit;
}

Account::init();

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	echo json_encode(["status"=> false, "message"=> 'В доступе отказано!']);
	exit;
}

$id_lesson = trim($_POST['id_lesson']);
$id_head_timeline = trim($_POST['id_head_timeline']);
$id_timeline = trim($_POST['id_timeline']);

$id_teacher = trim($_POST['id_teacher']);
$office = trim($_POST['office']);
$floor = trim($_POST['floor']);
$building = trim($_POST['building']);

$id_group = trim($_POST['id_group']);
$id_day = trim($_POST['id_day']);
$even_numbered = trim($_POST['even_numbered']);


// Проверка уровня доступа

if (R::findOne("groups_students", "id = ?", array($id_group))->id_institution != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'В доступе к данной группе отказано!']);
	exit;
}

// Проверка данных

if (empty($id_lesson) || $id_lesson <= 0 || R::count("lessons", "id = ? AND institution_id = ?", array($id_lesson, Account::$INSTITUTION_ID))== 0) {
	echo json_encode(["status"=> false, "message"=> 'Урок выбран неверно!']);
	exit;
}

if (empty($id_head_timeline) || $id_head_timeline <= 0) {
	echo json_encode(["status"=> false, "message"=> 'Идентификатор графика выбран неверно!']);
	exit;
}

if (empty($id_timeline) || $id_timeline <= 0) {
	echo json_encode(["status"=> false, "message"=> 'Время выбрано неверно!']);
	exit;
}

$chec_use_head_timeline = R::count('head_timeline', 'id = ? AND id_institution = ?', array($id_head_timeline, Account::$INSTITUTION_ID));
$chec_use_timeline = R::count('timeline', 'id = ? AND id_head_timeline = ?', array($id_timeline, $id_head_timeline));

if ($chec_use_head_timeline == 0 || $chec_use_timeline == 0) {
	echo json_encode(["status"=> false, "message"=> 'Время выбрано неверно!']);
	exit;
}

if (empty($floor)) {
	$floor = null;
}
if (empty($building)) {
	$building = null;
}

// if ((empty($time_start_hours) || $time_start_hours <= 0 || $time_start_hours >= 24)
// 	&& (empty($time_start_minutes) || $time_start_minutes <= 0 || $time_start_minutes >= 60)
// 	&& (empty($time_end_hours) || $time_end_hours <= 0 || $time_end_hours >= 24)
// 	&& (empty($time_end_minutes) || $time_end_minutes <= 0 || $time_end_minutes >= 60)) {

// 	echo json_encode(["status"=> false, "message"=> 'Время урока введено неверно!']);
// 	exit;
// }

// $time_start_lesson = new DateTimeImmutable($time_start_hours . ":" . $time_start_minutes);
// $time_end_lesson = new DateTimeImmutable($time_end_hours . ":" . $time_end_minutes);

// if ($time_start_lesson >= $time_end_lesson) {
// 	echo json_encode(["status"=> false, "message"=> 'Временной диапазона урока введен неверно!', "d" => $time_start_lesson, "e" => $time_end_lesson]);
// 	exit;
// }

// if (empty($id_teacher) || $id_lesson <= 0) {
// 	echo json_encode(["status"=> false, "message"=> 'Преподаватель выбран неверно!']);
// 	exit;
// }

// if (empty($id_group) || $id_group <= 0) {
// 	echo json_encode(["status"=> false, "message"=> 'Группа выбрана неверно!']);
// 	exit;
// }

if (empty($id_day) || $id_day <= 0 || $id_day > 6) {
	echo json_encode(["status"=> false, "message"=> 'День недели выбран неверно!']);
	exit;
}

if (R::findOne("accounts_generated", "id = ?", array($id_teacher))->institution_id != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'Преподаватель выбран неверно!']);
	exit;
}

if (R::count("teachers_lessons", "id_teacher = ? AND id_lesson = ?", array($id_teacher, $id_lesson)) == 0) {
	echo json_encode(["status"=> false, "message"=> 'Преподаватель не может вести данный урок!']);
	exit;
}




$schedules = R::xdispense('schedules');
$schedules->id_lesson	=  $id_lesson;
$schedules->id_group	=  $id_group;
$schedules->id_teacher 	=  $id_teacher;
$schedules->timeline 	=  $id_timeline;
$schedules->office 		=  $office;
$schedules->floor 		=  $floor;
$schedules->building 	=  $building;
$schedules->even_numbered =  $even_numbered;
$schedules->id_day  	=  $id_day;
R::store($schedules);

echo json_encode(["status"=> true, "message"=> 'Success!']);