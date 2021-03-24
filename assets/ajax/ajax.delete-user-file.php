<?php
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

if (!Account::$AUTH) {
	echo json_encode("В доступе отказано!");
	exit;
}

$id_file = $_POST['id_file'];
$file = R::findOne('users_files', 'id = ?', array($id_file));
if (Account::$ID != $file->user_id) {
	echo json_encode(["status"=> false, "message"=> 'В доступе к данному файлу отказано!']);
    exit;
}

$filepath = $_SERVER["DOCUMENT_ROOT"].$file->path;
unlink($filepath);

$delete_file = R::load('users_files', $file->id);
R::trash($delete_file);

echo json_encode(["status"=> true, "message"=> 'Файл успешно удален!']);