<?php 
# Старт сессии
@session_start(); 
# Старт буфера
@ob_start(); 


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

require_once($_SERVER["DOCUMENT_ROOT"]."/assets/start/classes.init.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.core.php"); Core::init(); // настройки сайта

if (!Account::$AUTH) {
	# Устанавливаем время по Гринвичу
	$time_zone = 'UTC';
}else{
	# Устанавливаем время по часовому поясу учреждения
	$time_zone = R::findOne('time_zones', 'id = ?', array(Institution::$ID_TIMEZONE))->name;
}



date_default_timezone_set($time_zone);
 


/*
 | ГЛАВНЫЙ КОНТРОЛЛЕР
*/

include($_SERVER["DOCUMENT_ROOT"]."/inc/header.php");

Route::path("/", function(){
	//Авторизованный пользователь
	if (Account::$AUTH) {
		if (Account::$ACCOUNT_TYPE == 1 || Account::$ACCOUNT_TYPE == 2) {
			//Пользователь использует мобильное устройство
			if (Route::is_mobile()) {
				include($_SERVER["DOCUMENT_ROOT"]."/components/comp.timetable.php");
				include($_SERVER["DOCUMENT_ROOT"]."/pages/timetable.php");
			}else{ //Пользователь не использует мобильное устройство
				include($_SERVER["DOCUMENT_ROOT"]."/components/comp.timetable.php");
				include($_SERVER["DOCUMENT_ROOT"]."/pages/timetable.php");
			}
		}
		if (Account::$ACCOUNT_TYPE == 3) {
			//Пользователь использует мобильное устройство
			if (Route::is_mobile()) {
				include($_SERVER["DOCUMENT_ROOT"]."/components/comp.account.php");
				include($_SERVER["DOCUMENT_ROOT"]."/pages/account.php");
			}else{ //Пользователь не использует мобильное устройство
				include($_SERVER["DOCUMENT_ROOT"]."/components/comp.account.php");
				include($_SERVER["DOCUMENT_ROOT"]."/pages/account.php");
			}
		}
		
	}
});


Route::path("/", function(){
	//Не авторизованный пользователь
	if (!Account::$AUTH) {
		include($_SERVER["DOCUMENT_ROOT"]."/components/comp.home.php");
		include($_SERVER["DOCUMENT_ROOT"]."/pages/home.php");
	}
});

Route::path("/login", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.login.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/login.php");
});

Route::path("/reg/{step}", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.reg.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/reg.php");
}, ["step"=>"[0-9]+"]);

Route::path("/reminder", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.reminder.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/reminder.php");
});

Route::path("/reminder/{key}", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.reminder.edit.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/reminder.edit.php");
}, ["key"=>"[a-zA-Z0-9]+"]);

Route::path("/group/{id}", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.group.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/group.php");
}, ["id"=>"[0-9]+"]);

Route::path("/groups-all", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.groups-all.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/groups-all.php");
});

Route::path("/files-all", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.files-all.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/files-all.php");
});

Route::path("/teachers", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.teachers.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/teachers.php");
});

Route::path("/schedule", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.schedule-all.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/schedule-all.php");
});

Route::path("/schedule/{id}", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.schedule.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/schedule.php");
}, ["id"=>"[0-9]+"]);

Route::path("timeline", function(){
	include($_SERVER["DOCUMENT_ROOT"]."/components/comp.timeline.php");
	include($_SERVER["DOCUMENT_ROOT"]."/pages/timeline.php");
}, ["id"=>"[0-9]+"]);
/*
 | ГЛАВНЫЙ КОНТРОЛЛЕР
*/

include($_SERVER["DOCUMENT_ROOT"]."/inc/footer.php");

$content_page = ob_get_contents();

ob_end_clean();

$content_page = str_replace("{!TITLE!}",Route::$TITLE, $content_page);
$content_page = str_replace('{!DESCRIPTION!}',Route::$DESCRIPTION, $content_page);

echo $content_page;