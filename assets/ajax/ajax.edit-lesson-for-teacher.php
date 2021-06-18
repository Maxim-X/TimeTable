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

$teacher_id = trim($_POST['teacher_id']);
$lesson_id = trim($_POST['lesson_id']);
$group_id = trim($_POST['group_id']);
$action = trim($_POST['action']);


// Проверка уровня доступа

if (R::findOne("groups_students", "id = ?", array($group_id))->id_institution != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'В доступе к данной группе отказано!']);
	exit;
}

// Проверка данных

if (empty($lesson_id) || $lesson_id <= 0 || R::count("lessons", "id = ? AND institution_id = ?", array($lesson_id, Account::$INSTITUTION_ID)) == 0) {
	echo json_encode(["status"=> false, "message"=> 'Урок выбран неверно!']);
	exit;
}

if (R::findOne("accounts_generated", "id = ?", array($teacher_id))->institution_id != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'Преподаватель выбран неверно!']);
	exit;
}
$check_ed = R::findOne('teachers_lessons', 'id_teacher = ? AND id_lesson = ? AND id_group = ?', array($teacher_id, $lesson_id, $group_id));

if ($action == 'on') {
	if (!$check_ed) {
		$teachers_lessons = R::xdispense('teachers_lessons');
		$teachers_lessons->id_teacher 	=  $teacher_id;
		$teachers_lessons->id_lesson		=  $lesson_id;
		$teachers_lessons->id_group			=  $group_id;
		R::store($teachers_lessons);
		echo json_encode(["status"=> true, "message"=> 'Success!']);
	}else{
		echo json_encode(["status"=> false, "message"=> 'Предмет и группа уже назначены для данного преподавателя!']);
	}
}else if ($action == 'off'){
	if ($check_ed) {
			$lesson_for_teacher_delete = R::hunt('teachers_lessons', 'id_teacher = ? AND id_lesson = ? AND id_group = ?', array($teacher_id, $lesson_id, $group_id));
			echo json_encode(["status"=> true, "message"=> 'Success!']);
	}else{
			echo json_encode(["status"=> false, "message"=> 'Предмет и группа не назначены для данного преподавателя!']);
	}
}
