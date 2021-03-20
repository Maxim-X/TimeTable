<?PHP

$info_group = R::findOne('groups_students', 'id = ?', array($_GET['id']));

if (isset($_POST['add_students'])) {
	$id_add_account = 1;

	while ( isset($_POST['name_student_'.$id_add_account]) && isset($_POST['surname_student_'.$id_add_account]) && isset($_POST['middle-name_student_'.$id_add_account])) {
		$user_info = array(	'name' => $_POST['name_student_'.$id_add_account],
							'surname' => $_POST['surname_student_'.$id_add_account],
							'middle_name' => $_POST['middle-name_student_'.$id_add_account],
							'account_type' => 1,
							'group_id' => $info_group->id);
		Account::signup_system_account($user_info);
		$id_add_account++;
	}
	header("Refresh: 0");
}

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
	var id_template = 2;
	function addTamplateStudent(){
		var template = document.createElement('div');
		template.className = 'row';
		template.innerHTML = '<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputNameStudent_'+id_template+'" class="form-label">Имя студента</label><input type="text" name="name_student_'+id_template+'" id="inputNameStudent_'+id_template+'" class="form-control"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputSurnameStudent_'+id_template+'" class="form-label">Фамилия студента</label><input type="text" name="surname_student_'+id_template+'" id="inputSurnameStudent_'+id_template+'" class="form-control"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputMiddleNameStudent_'+id_template+'" class="form-label">Отчество студента</label><input type="text" name="middle-name_student_'+id_template+'" id="inputMiddleNameStudent_'+id_template+'" class="form-control"></div></div>';
		document.querySelector("#all_add_students_list").append(template);
		id_template++;
	}

	function deleteTamplateStudent(){
		if (id_template >= 2) {
			var last_template_dom = document.querySelector("#all_add_students_list");
			last_template_dom.lastChild.remove();
			id_template--;
		}
	}
</script>