<?PHP

# Старт сессии
session_start(); 
# Старт буфера
ob_start(); 

define("INDEX", "");




require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.db.php"); // информация о базе данных
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php"); // подключение RedBeanPHP


// подключение к базе данных
R::setup( "mysql:host=".db::$HostDB."; dbname=".db::$BaseDB, db::$UserDB, db::$PassDB );

if(!R::testConnection()){ 
	echo ["status"=> false, "message"=> 'Ошибка подключения к Базе Данных!'];
}

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});

// Поиск информации об учащихся и группах по названию и ФИО



$find_str = $_POST['find_str'];

$search_groups = R::find('groups_students', "WHERE `name` LIKE ?",array('%'.$find_str.'%'));

foreach ($search_groups as &$group) {
	$count_students = R::count( 'accounts', 'group_id = ?', array($group->id));
	$group["count_students"] = $count_students;
}

echo json_encode(["status"=> true, "search_groups"=> $search_groups]);