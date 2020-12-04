<?PHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");

echo $_SESSION['user_id'];

Account::init();
if (Account::$AUTH) {
	echo "True";
}else{
	echo "False";
}