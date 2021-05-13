<?php 

$date_day = trim($_POST['date_day']);

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

if (!Account::$AUTH && Account::$ACCOUNT_TYPE != 3) {
	echo json_encode(["status"=> false, "message"=> 'В доступе отказано!']);
	exit;
}


if (!isset($date_day) || empty($date_day)) {
	echo json_encode(["status"=> false, "message"=> 'Дата указана неверно!']);
	exit;
}

$date_day_format = date('Y-m-d', strtotime($date_day));

// $all_replacing = R::find('replacing', 'date = ?', array($date_day_format));
$all_replacing = R::getAll('SELECT (SELECT name FROM groups_students WHERE id = replacing.id_group) AS group_name, COUNT(replacing.id) AS count FROM replacing WHERE replacing.id_group IN (SELECT id FROM groups_students WHERE id_institution = ?) AND replacing.date = ? GROUP BY replacing.id_group', array(Account::$INSTITUTION_ID, $date_day_format));
// $all_replacing = R::exportAll( $all_replacing );


echo json_encode(["status"=> true, "all_replacing"=> $all_replacing]);

//SELECT * FROM replacing, groups_students WHERE replacing.id_group IN (SELECT id FROM groups_students WHERE id_institution = 1) AND replacing.date = 2021-05-10