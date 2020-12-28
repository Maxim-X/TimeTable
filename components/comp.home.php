<?PHP
require_once($_SERVER["DOCUMENT_ROOT"]."/assets/general/class.account.php");
Account::init();

echo Account::$ID;

if (Account::$AUTH) {
	echo "True";
}else{
	echo "False";
}


echo "<pre>";
$user_info = ["email" => "dkds.adk@mail.ru", "password" => "dkD3kdmsds"];
// var_dump(Account::signup($user_info));

var_dump(Account::auth("dkds.adk@mail.ru", "dkD3kdmsds"));
// var_dump(Account::exit());
echo "</pre>";

if (Account::$AUTH) {
	echo Account::$EMAIL;
}

