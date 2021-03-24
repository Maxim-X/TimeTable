<?PHP
if (!Account::$AUTH) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Группа ".$info_group->name;
Route::$DESCRIPTION = "Группа ".$info_group->name;

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

if (isset($_POST['editUserData'])) {

	$user_id = htmlspecialchars($_POST['user_id']);
	$user_name = htmlspecialchars($_POST['user_name']);
	$user_surname = htmlspecialchars($_POST['user_surname']);
	$user_middle_name = htmlspecialchars($_POST['user_middle_name']);
	$user_group = htmlspecialchars($_POST['user_group']);

	if (Account::$AUTH || Account::$ACCOUNT_TYPE == 3) {
		$id_institution = R::exec('SELECT groups_students.id_institution FROM `accounts_generated`, `groups_students`  WHERE accounts_generated.id = ? AND groups_students.id = accounts_generated.group_id ', array($user_id));
		
		if (isset($user_id) || Institution::$ID == $id_institution ) {
		
			if ( !empty($user_name) && !empty($user_surname) && !empty($user_middle_name) ) {

				$check_group = R::findOne('groups_students', 'id = ?', array($user_group));
				
				if ( isset($user_group) && !empty($user_group) && $user_group > 0 && $check_group ) {
					$user = R::load('accounts_generated', $user_id);
					$user->name = $user_name;
					$user->surname = $user_surname;
					$user->middle_name = $user_middle_name;
					$user->group_id = $user_group;
					R::store($user);
				}else{ $error_edit = "Данной группы не обнаруженно!"; }

			}else{ $error_edit = "Одно из полей не заполненно!"; }
		
		}else{$error_edit = "Вам запрещено редактировать информацию этого ученика!";}
		
	}else{$error_edit = "Вам запрещено редактировать информацию учеников!";}

	
		
	echo $error_edit;

}

$students_group = R::find('accounts_generated', 'account_type = ? AND group_id = ?', array(1, $info_group->id));
$all_groups = R::find('groups_students', 'id_institution = ?', array(Institution::$ID));


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
	window.onload = function(){

		EDIT_DOM.reload_all_files();

		var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone('div.drag_and_drop_file', { // Make the whole body a dropzone
          url: "/assets/ajax/ajax.upload-file.php", // Set the url
          thumbnailWidth: 80,
          // maxFiles: 1,
          acceptedFiles: 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          thumbnailHeight: 80,
          parallelUploads: 20,
          previewTemplate: previewTemplate,
          // autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: ".file-upload-list", // Define the container to display the previews
          // clickable: "#upload_but" // Define the element that should be used as click trigger to select files.
        });

		myDropzone.on('success', function(file) {
		    EDIT_DOM.reload_all_files();
		    setTimeout(() => file.previewElement.remove(), 3000);
		});
		myDropzone.on('error', function(file) {
		    file.previewElement.classList.add('error');
		    console.log(file.previewElement);
		    setTimeout(() => file.previewElement.remove(), 3000);
		});
	}
	var id_template = 2;
	function addTamplateStudent(){
		var template = document.createElement('div');
		template.className = 'row';
		template.innerHTML = '<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputNameStudent_'+id_template+'" class="form-label">Имя студента</label><input type="text" name="name_student_'+id_template+'" id="inputNameStudent_'+id_template+'" class="form-control form-control-input"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputSurnameStudent_'+id_template+'" class="form-label">Фамилия студента</label><input type="text" name="surname_student_'+id_template+'" id="inputSurnameStudent_'+id_template+'" class="form-control form-control-input"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputMiddleNameStudent_'+id_template+'" class="form-label">Отчество студента</label><input type="text" name="middle-name_student_'+id_template+'" id="inputMiddleNameStudent_'+id_template+'" class="form-control form-control-input"></div></div>';
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

	function generatingAuthInfo(group_id){

		$.ajax({
			url: '/assets/ajax/ajax.generating-auth-info.php',
			type: 'POST',
			dataType: 'json',
			data: {group_id: group_id},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function(data) {
			console.log("error");
		})
		.always(function(data) {
			var $a = $("<a>");
		    $a.attr("href",data.file);
		    $("body").append($a);
		    $a.attr("download","Аккаунты группы <?=$info_group->name;?>.xls");
		    $a[0].click();
		    $a.remove();
		});
		
	}

	function editStudentInfo(user_id){

		$.ajax({
			url: '/assets/ajax/ajax.user-info.php',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id},
		})
		.done(function(data) {
			if (data.status) {
				let user = data.user;
				console.log(user);
				document.querySelector('input#user_id').value = user.id;
				document.querySelector('input#user_name').value = user.name;
				document.querySelector('input#user_surname').value = user.surname;
				document.querySelector('input#user_middle_name').value = user.middle_name;
				document.querySelector('#user_edit_id').innerHTML = user.id;
				document.querySelector('.block_edit_user').style.display = "block";
				document.querySelector('.block_drive').style.display = "none";
			}else{
				alert(data.message);
			}
		})
		.fail(function(data) {
			alert("Error");
		});
	}

	function closeEditStudentInfo(){
		document.querySelector('.block_edit_user').style.display = "none";
		document.querySelector('.block_drive').style.display = "block";
	}
</script>