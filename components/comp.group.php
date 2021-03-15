<?PHP

$disk_space_mb = (int)Core::$DISC_SPACE / 1024 / 1024;

$user_files = R::find('users_files', 'user_id = ?', array(Account::$ID));
$use_space = 0;

foreach ($user_files as $file) {
	$use_space += $file->size;
}

$use_space_mb += $use_space / 1024 / 1024;

$pr_use_space = $use_space * 100 / (int)Core::$DISC_SPACE;
?>