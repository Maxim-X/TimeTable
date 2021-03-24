<?PHP
# Старт сессии
session_start(); 
# Старт буфера
ob_start(); 

define("INDEX", "");


require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.db.php"); // информация о базе данных
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/main/RedBean.php"); // подключение RedBeanPHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/config/config.core.php"); 

require_once $_SERVER["DOCUMENT_ROOT"].'/assets/modules/PHPExcel/Classes/PHPExcel.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/assets/modules/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
 


// подключение к базе данных
R::setup("mysql:host=".db::$HostDB."; dbname=".db::$BaseDB, db::$UserDB, db::$PassDB );

if(!R::testConnection()){ 
	echo json_encode(["status"=> false, "message"=> 'Ошибка подключения к Базе Данных!']);
	exit;
}

R::ext('xdispense', function( $type ){
  return R::getRedBean()->dispense( $type );
});

Account::init();
Core::init();

if (!Account::$AUTH) {
	echo json_encode(["status"=> false, "message"=> 'В доступе отказано!']);
	exit;
}

$group_id = $_POST['group_id'];

$group_info = R::findOne('groups_students', ' id = ? ', array($group_id));

if (!isset($group_id) || $group_id <= 0 || !$group_info) {
	echo json_encode(["status"=> false, "message"=> 'ID группы введено неверно!']);
	exit;
}

$id_inst_group = R::findOne('groups_students', 'id = ?', array($group_id))['id_institution'];

if ($id_inst_group != Account::$INSTITUTION_ID) {
	echo json_encode(["status"=> false, "message"=> 'В доступе к информации об этой группе отказано!']);
	exit;
}

$list_users = R::find('accounts_generated', 'group_id = ?', array($group_id));
// getAll('SELECT `login`, `password`,`name`,`surname`,`middle_name` FROM `accounts_generated` WHERE `group_id`= ?', array($group_id));

$xls = new PHPExcel();

// Автор
// $xls->getProperties()->setCreator(Account::$SURNAME." ".Account::$NAME." ".Account::$MIDDLENAME);
$xls->getProperties()->setCreator(Core::$NAME_SITE);
// Организация
$xls->getProperties()->setCompany(Core::$NAME_SITE);


$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$sheet->setTitle('Аккаунты группы '.$group_info->name);

// Формат
$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
 
// Ориентация
// ORIENTATION_PORTRAIT — книжная
// ORIENTATION_LANDSCAPE — альбомная
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
 


$xls->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$xls->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$xls->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);


$sheet->getStyle('A1')->getFont()->setBold(true);
$sheet->getStyle('B1')->getFont()->setBold(true);
$sheet->getStyle('C1')->getFont()->setBold(true);

$sheet->setCellValue("A1" , "ФИО");
$sheet->setCellValue("B1" , "Логин");
$sheet->setCellValue("C1" , "Пароль");

$ind = 2;
foreach ($list_users as $user) {
	$sheet->setCellValue("A".$ind , $user->surname." ".$user->name." ".$user->middle_name);
	$sheet->setCellValue("B".$ind , $user->login);
	$sheet->setCellValue("C".$ind , $user->password);
	$ind++;
}

// $sheet->setCellValue("A1", "ЗначениеЗначение Значение Значение");

$validLocale = PHPExcel_Settings::setLocale('ru');
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('php://output'); 
$xlsData = ob_get_contents();
ob_end_clean();

echo json_encode(["status"=> true, "file"=> "data:application/vnd.ms-excel;base64,".base64_encode($xlsData), "e" =>$list_users ]);
