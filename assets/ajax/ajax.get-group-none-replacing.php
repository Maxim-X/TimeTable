<?PHP 

# Старт сессии
session_start(); 
# Старт буфера
ob_start(); 

define("INDEX", "");

require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.db.php"); // информация о базе данных
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php"); // подключение RedBeanPHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");


$date = trim($_POST['date']);

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

$all_groups_none_repl = R::getAll("SELECT * FROM groups_students WHERE groups_students.id_institution = ? AND groups_students.id NOT IN (SELECT replacing.id_group FROM replacing WHERE replacing.date = '".$date."')", array(Account::$INSTITUTION_ID));

echo json_encode(["status"=> true, "all_groups_none_repl"=> $all_groups_none_repl, "dd" => "SELECT * FROM groups_students WHERE groups_students.id_institution = ".Account::$INSTITUTION_ID." AND groups_students.id NOT IN (SELECT replacing.id_group FROM replacing WHERE replacing.date = '".$date."')"]);