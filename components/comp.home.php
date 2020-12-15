<?PHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");

echo $_SESSION['user_id'];

Account::init();
if (Account::$AUTH) {
	echo "True";
}else{
	echo "False";
}


echo "<pre>";
$user_info = ["email" => "dkds.adk@mail.ru", "password" => "dkD3kdmsds"];
var_dump(Account::signup($user_info));
echo "</pre>";