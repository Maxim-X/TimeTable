<?php

$id_lesson = trim($_POST['id_lesson']);
$id_group = trim($_POST['id_group']);
$id_teacher = trim($_POST['selected_teacher']);

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


$use_office = R::getAll('SELECT COUNT(*) as count, schedules.office, schedules.floor, schedules.building FROM `schedules` WHERE id_lesson = ? AND id_group = ? AND id_teacher = ? GROUP BY schedules.office, schedules.floor, schedules.building ORDER BY count DESC LIMIT 1' , array($id_lesson, $id_group, $id_teacher));
$use_office = R::convertToBeans('use_office', $use_office);
if ($use_office) {
	echo json_encode(["status"=> true, "use_office"=> $use_office]);
}else{
	echo json_encode(["status"=> false]);
}
