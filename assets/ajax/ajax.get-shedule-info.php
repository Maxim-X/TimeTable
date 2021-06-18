<?php 

$schedule_id = trim($_POST['schedule_id']);
$replace_id = trim($_POST['replace_id']);
$date = trim($_POST['date']);
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

if ((!isset($schedule_id) || empty($schedule_id)) && (!isset($replace_id) || empty($replace_id))) {
	echo json_encode(["status"=> false, "message"=> 'ID указан неверно!']);
	exit;
}
if (!empty($schedule_id)) {
	$schedule = R::findOne('schedules', 'id = ?', array($schedule_id));
}else{
	$schedule = R::findOne('replacing', 'id = ?', array($replace_id));
}

$lesson = R::findOne('lessons', 'id = ?', array($schedule->id_lesson));
$timeline = R::findOne('timeline', 'id = ?', array($schedule->timeline));

$group_name = R::findOne('groups_students', 'id = ?', array($schedule->id_group))->name;

$teacher = R::findOne('accounts_generated', 'id = ?', array($schedule->id_teacher));
if (empty($replace_id)) {
	$replace = R::findOne('replacing', 'id_schedule = ? AND date = ?', array($schedule->id, $date));
}
$return = ["status"=> true, "schedule"=> $schedule, "lesson" => $lesson, "timeline" => $timeline, "teacher" => $teacher, "group_name" => $group_name];

if ($replace) {

	$lesson_replace = R::findOne('lessons', 'id = ?', array($replace->id_lesson));
	$teacher_replace = R::findOne('accounts_generated', 'id = ?', array($replace->id_teacher));
	$return['replace'] = $replace;
	$return['lesson_replace'] = $lesson_replace;
	$return['teacher_replace'] = $teacher_replace;
}

echo json_encode($return);