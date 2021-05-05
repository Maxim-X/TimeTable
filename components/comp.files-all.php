<?PHP 

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Ваши файлы";
Route::$DESCRIPTION = "Ваши файлы";

$students_group = R::find('accounts_generated', 'account_type = ? AND group_id = ?', array(1, $info_group->id));

$disk_space_mb = (int)Core::$DISC_SPACE / 1024 / 1024;
$user_files = R::find('users_files', 'user_id = ?', array(Account::$ID));
$use_space = 0;

foreach ($user_files as $file) {
	$use_space += $file->size;
}

$use_space_mb += $use_space / 1024 / 1024;

$pr_use_space = $use_space * 100 / (int)Core::$DISC_SPACE;

?>


<script>
	function delete_file(id_file){
		$.ajax({
			url: '/assets/ajax/ajax.delete-user-file.php',
			type: 'POST',
			dataType: 'json',
			data: {id_file: id_file},
		})
		.done(function(data) {
			EDIT_DOM.reload_all_files_table();
		})
		.fail(function(data) {
			console.log("fail");
			console.log(data);
		});
		
	}
</script>