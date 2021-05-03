<?php

$id_head_timeline = trim($_POST['id_head_timeline']);

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


if (empty($id_head_timeline) || $id_head_timeline <= 0) {
	echo json_encode(["status"=> false, "message"=> 'Идентификатор графика введен неверно!']);
	exit;
}

$head_timeline = R::find("head_timeline", "id = ? AND id_institution  = ?", array($id_head_timeline, Account::$INSTITUTION_ID));
if (!$head_timeline) {
	echo json_encode(["status"=> false, "message"=> 'Данный график не найден!']);
	exit;
}

$times = R::getAll('SELECT * FROM timeline WHERE id_head_timeline = ? ORDER BY time_start ASC', array($id_head_timeline));


echo json_encode(["status"=> true, "times"=> $times]);
