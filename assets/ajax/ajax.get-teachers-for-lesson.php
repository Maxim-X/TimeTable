<?php

$id_lesson = trim($_POST['id_lesson']);
$id_group = trim($_POST['id_group']);

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


if (empty($id_lesson) || $id_lesson <= 0) {
	echo json_encode(["status"=> false, "message"=> 'Идентификатор урока введен неверно!']);
	exit;
}

$lesson = R::find("lessons", "id = ? AND institution_id  = ?", array($id_lesson, Account::$INSTITUTION_ID));
if (!$lesson) {
	echo json_encode(["status"=> false, "message"=> 'Данный предмет не найден']);
	exit;
}
if (isset($_POST['id_group'])) {
	$all_teachers = R::getAll('SELECT accounts_generated.id, accounts_generated.name, accounts_generated.surname, accounts_generated.middle_name FROM `teachers_lessons`, `accounts_generated` WHERE teachers_lessons.id_lesson = ? AND teachers_lessons.id_group = ? AND teachers_lessons.id_teacher = accounts_generated.id GROUP BY id', array($id_lesson, $id_group));
}else{
	$all_teachers = R::getAll('SELECT accounts_generated.id, accounts_generated.name, accounts_generated.surname, accounts_generated.middle_name FROM `teachers_lessons`, `accounts_generated` WHERE teachers_lessons.id_lesson = ? AND teachers_lessons.id_teacher = accounts_generated.id GROUP BY id', array($id_lesson));
}


echo json_encode(["status"=> true, "all_teachers"=> $all_teachers]);
