<?php

$id_head_timeline = trim($_POST['id_head_timeline']);
$id_group = trim($_POST['id_group']);
$id_day = trim($_POST['id_day']);
$even_numbered = trim($_POST['even_numbered']);

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

$use_head_timeline = R::findOne("schedules", "id_group = ? AND id_day = ? AND even_numbered = ?", array($id_group, $id_day, $even_numbered))->timeline;
if ($use_head_timeline) {
	$use_head_timeline = R::findOne("timeline", "id = ?", array($use_head_timeline))->id_head_timeline;
	$id_head_timeline = $use_head_timeline;
}

$head_timeline = R::find("head_timeline", "id = ? AND id_institution  = ?", array($id_head_timeline, Account::$INSTITUTION_ID));
if (!$head_timeline) {
	echo json_encode(["status"=> false, "message"=> 'Данный график не найден!']);
	exit;
}

$times = R::getAll('SELECT * FROM timeline WHERE id_head_timeline = ? AND id NOT IN (SELECT timeline FROM `schedules` WHERE id_group = ? AND even_numbered = ? AND id_day = ?) ORDER BY time_start ASC', array($id_head_timeline, $id_group, $even_numbered, $id_day ));

// SELECT timeline FROM `schedules` WHERE id_group = 1 AND even_numbered = 0 AND id_day = 2

if ($use_head_timeline) {
	echo json_encode(["status"=> true, "times"=> $times, "use_head_timeline"=> $use_head_timeline]);
}else{
	echo json_encode(["status"=> true, "times"=> $times]);
}

