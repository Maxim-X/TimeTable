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

if(!R::testConnection()){ 
	echo ["status"=> false, "message"=> 'Ошибка подключения к Базе Данных!'];
}

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});

// Поиск информации об учащихся и группах по названию и ФИО

Account::init();

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	echo json_encode(["status"=> false, "message"=> 'В доступе отказано!']);
	exit;
}

$find_str = $_POST['find_str'];

$search_groups = R::find('groups_students', "WHERE `name` LIKE ? AND id_institution = ?",array('%'.$find_str.'%', Account::$INSTITUTION_ID));

foreach ($search_groups as &$group) {
	$count_students = R::count( 'accounts_generated', 'group_id = ?', array($group->id));
	$group["count_students"] = $count_students;
}

$groups = R::findOne("groups_students", "id_institution = ?", array(Account::$INSTITUTION_ID));

$search_students = R::getAll("SELECT * FROM `accounts_generated` WHERE (accounts_generated.account_type = ?) AND  (accounts_generated.group_id IN (SELECT groups_students.id FROM `groups_students` WHERE groups_students.id_institution = ?)) AND (`name` LIKE ? OR `surname` LIKE ? OR `middle_name` LIKE ?)", array('1', Account::$INSTITUTION_ID, '%'.$find_str.'%', '%'.$find_str.'%', '%'.$find_str.'%'));

foreach ($search_students as &$student) {
	$group_student = R::findOne( 'groups_students', 'id = ?', array($student->group_id));
	$student["group_name"] = $group_student->name;
}

echo json_encode(["status"=> true, "search_groups"=> $search_groups, "search_students" => $search_students]);