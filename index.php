<?php 
# Старт сессии
session_start();

# Старт буфера
ob_start();
define("INDEX", ""); // УСТАНОВКА КОНСТАНТЫ ГЛАВНОГО КОНТРОЛЛЕРА

require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.db.php"); // информация о базе данных
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php"); // подключение RedBeanPHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/Route.php"); // подключение маршрутизатора


// подключение к базе данных
R::setup( "mysql:host=".db::$HostDB."; dbname=".db::$BaseDB, db::$UserDB, db::$PassDB );
if(!R::testConnection()) die('Ошибка подключения к Базе Данных!');

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});




/**
 * ГЛАВНЫЙ КОНТРОЛЛЕР
 */
Route::path("/", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.home.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/home.php");
});
Route::path("login", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.login.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/login.php");
});
Route::path("login/{id}", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.login.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/login.php");
}, ["id"=>"[a-zA-Z]+"]);



// include ($_SERVER[DOCUMENT_ROOT]."/template.php");
