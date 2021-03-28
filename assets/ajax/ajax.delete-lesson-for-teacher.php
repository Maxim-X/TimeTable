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


$id_teacher = trim($_POST['id_teacher']);
$id_lesson 	= trim($_POST['id_lesson']);
$id_institution_teacher = R::findOne("accounts_generated", "id = ?", array($id_teacher))->institution_id;

if (empty($id_teacher) || $id_teacher <= 0 || !$id_institution_teacher) {
	echo json_encode(["status"=> false, "message"=> 'Идентификатор преподавателя указан неверно!']);
	exit;
}

if ($id_institution_teacher != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'Вы не можете редактировать профиль данного преподавателя!']);
	exit;
}

if (empty($id_lesson) || $id_lesson <= 0) {
	echo json_encode(["status"=> false, "message"=> 'Идентификатор предмета указан неверно!']);
	exit;
}

$lesson_for_teacher_delete = R::hunt('teachers_lessons', 'id_teacher = ? AND id_lesson = ?', array($id_teacher, $id_lesson));

if (!$lesson_for_teacher_delete) {
	echo json_encode(["status"=> false, "message"=> 'Произошла ошибка при удалении!']);
	exit;
}

echo json_encode(["status"=> true, "message"=> 'Предмет успешно удален из профиля преподавателя']);