<?PHP

// Класс пользователя
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");
Account::init();

// Класс учебного заведения
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.institution.php");
Institution::init();


