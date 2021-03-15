<?php

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

require_once($_SERVER["DOCUMENT_ROOT"]."/assets/start/classes.init.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.core.php"); Core::init(); // настройки сайта

$disk_space_mb = number_format((int)Core::$DISC_SPACE / 1024 / 1024, 0);

$user_files = R::find('users_files', 'user_id = ?', array(Account::$ID));
$use_space = 0;

foreach ($user_files as $file) {
	$use_space += $file->size;
}

$user_files_open = array();

foreach ($user_files as $file) {
	$user_file = array();
	$user_file["id"] = $file->id;
	$user_file["name"] = $file->name;
	$user_file["size"] = number_format($file->size / 1024 / 1024, 2);
	// array_push($user_file, $user_files_open["id"], $user_files_open["name"], $user_files_open["size"] );
	array_push($user_files_open, $user_file);
}

$use_space_mb += number_format($use_space / 1024 / 1024, 2);

$pr_use_space = number_format($use_space * 100 / (int)Core::$DISC_SPACE, 2);


$ret = json_encode(array("use_space_mb" => $use_space_mb, "pr_use_space" => $pr_use_space, "disk_space_mb" => $disk_space_mb, "user_files" => $user_files_open));

echo $ret;

?>