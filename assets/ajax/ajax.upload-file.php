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
}

Account::init();

if (!Account::$AUTH) {
	echo "В доступе отказанно!";
	exit;
}

$ds = DIRECTORY_SEPARATOR; 

$storeFolder = $_SERVER["DOCUMENT_ROOT"] . '\users_files\documents';  
 
if (!empty($_FILES)) {
 
    $tempFile = $_FILES['file']['tmp_name'];

    // Генерируем системное название для файла
    $ext = "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $system_name_file = Account::$ID . time(). rand(1, 9999) . $ext;

    if (!in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), array("xlsx", "xlsm", "xls", "xltx", "xltm"))) {
    	header('Content-type: text/json');           
   		header('Content-type: application/json');
    	echo json_encode(array("status" => false, "message" => "Поддерживаются файлы только с форматом (XLSX, XLSM, XLS, XLTX и XLTM)"));
    	exit;
    }

 
    $targetPath = $storeFolder . $ds; 
 
    $targetFile =  $targetPath .  $system_name_file; //$_FILES['file']['name']; 
 
    move_uploaded_file($tempFile,$targetFile);

    # добавляем информацию о файле в базу данных
	$users_files = R::xdispense('users_files');
	$users_files->name 	= $_FILES['file']['name'];
	$users_files->path 	= '/users_files/documents/'.$system_name_file;
	$users_files->size 	= filesize($storeFolder.$ds.$system_name_file);
	$users_files->user_id 	= Account::$ID;
	R::store($users_files);
 
} else {                                                           
    $result  = array();
 
    $files = scandir($storeFolder);                 //1
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       //2
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $obj['dd'] = var_dump($_FILES['file']);
                $result[] = $obj;
            }
        }
    }
     
    header('Content-type: text/json');              //3
    header('Content-type: application/json');
    echo json_encode($result);
}
?>