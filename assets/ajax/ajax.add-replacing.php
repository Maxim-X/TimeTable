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
$type = trim($_POST['type']);
$id_schedule = trim($_POST['id_schedule']);
$date = trim($_POST['date']);

if ($type == 1) {
	$id_lesson = trim($_POST['id_lesson']);
	$id_group = trim($_POST['id_group']);
	$id_teacher = trim($_POST['id_teacher']);
	$office = trim($_POST['office']);
	$floor = trim($_POST['floor']);
	$building = trim($_POST['building']);
	$id_timeline = R::findOne('schedules', 'id = ?', array($id_schedule))->timeline;

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

	if (empty($id_timeline) || $id_timeline <= 0) {
		echo json_encode(["status"=> false, "message"=> 'Время выбрано неверно!']);
		exit;
	}

	if (empty($floor)) {
		$floor = null;
	}
	if (empty($building)) {
		$building = null;
	}

	if (R::findOne("accounts_generated", "id = ?", array($id_teacher))->institution_id != Account::$INSTITUTION_ID) {
		echo json_encode(["status"=> false, "message"=> 'Преподаватель выбран неверно!']);
		exit;
	}

	if (R::count("teachers_lessons", "id_teacher = ? AND id_lesson = ?", array($id_teacher, $id_lesson)) == 0) {
		echo json_encode(["status"=> false, "message"=> 'Преподаватель не может вести данный урок!']);
		exit;
	}

	$replacing = R::xdispense('replacing');
	$replacing->date = $date;
	$replacing->id_schedule = $id_schedule;
	$replacing->id_lesson = $id_lesson;
	$replacing->id_group = $id_group;
	$replacing->id_teacher = $id_teacher;
	$replacing->timeline = $id_timeline;
	$replacing->office 		=  $office;
	$replacing->floor 		=  $floor;
	$replacing->building 	=  $building;
	R::store($replacing);

	echo json_encode(["status"=> true, "message"=> 'Success!']);
}

// Отмена занятия
if ($type == 2) {
	$replacing = R::xdispense('replacing');
	$replacing->date = $date;
	$replacing->id_schedule = $id_schedule;
	$replacing->cancel = 1;

	R::store($replacing);
}