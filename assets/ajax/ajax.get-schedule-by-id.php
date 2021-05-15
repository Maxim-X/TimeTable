<?php 

$schedule_id = trim($_POST['schedule_id']);

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


if (!isset($schedule_id) || empty($schedule_id)) {
	echo json_encode(["status"=> false, "message"=> 'ID указан неверно!']);
	exit;
}

$schedule = R::findOne('schedules', 'id = ?', array($schedule_id));


echo json_encode(["status"=> true, "schedule"=> $schedule]);