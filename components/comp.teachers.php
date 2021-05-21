 <?PHP
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Таблица преподавателей " . Institution::$SHORT_NAME;
Route::$DESCRIPTION = "Таблица преподавателей " . Institution::$SHORT_NAME;

if (isset($_POST['add_teachers'])) {
	$id_add_account = 1;
	while ( isset($_POST['name_teacher_'.$id_add_account]) && isset($_POST['surname_teacher_'.$id_add_account]) && isset($_POST['middle-name_teacher_'.$id_add_account])) {
		$user_info = array(	'name' => $_POST['name_teacher_'.$id_add_account],
							'surname' => $_POST['surname_teacher_'.$id_add_account],
							'middle_name' => $_POST['middle-name_teacher_'.$id_add_account],
							'account_type' => 2,
							'institution_id' => Institution::$ID);
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

	if (Account::$AUTH || Account::$ACCOUNT_TYPE == 3) {
		$user = R::load('accounts_generated', $user_id);
		
		if (isset($user_id) || Institution::$ID == $user->institution_id ) {
		
			if ( !empty($user_name) && !empty($user_surname) && !empty($user_middle_name) ) {

					$user->name = $user_name;
					$user->surname = $user_surname;
					$user->middle_name = $user_middle_name;
					R::store($user);

			}else{ $error_edit = "Одно из полей не заполненно!"; }
		
		}else{$error_edit = "Вам запрещено редактировать информацию этого преподавателя!";}
		
	}else{$error_edit = "Вам запрещено редактировать информацию учеников!";}

	
		
	echo $error_edit;

}
if (isset($_POST['add_lesson_for_teacher'])) {

	if ($_POST['lesson_id'] != "") {
		if ($_POST['user_id_th'] != "") {
		$check_use_lesson = R::count('teachers_lessons', 'id_teacher = ? AND id_lesson = ?', array($_POST['user_id_th'], $_POST['lesson_id']));
			if (!$check_use_lesson) {
				$add_lesson_th = R::xdispense('teachers_lessons');
				$add_lesson_th->id_teacher 	= $_POST['user_id_th'];
				$add_lesson_th->id_lesson 	= $_POST['lesson_id'];
				R::store($add_lesson_th);
				if (R::store($add_lesson_th)) {
					header("Refresh: 0");
				}else{$error_add_lesson = "Произошла ошибка, повторите позже!";}
			}else{$error_add_lesson = "Данный предмет уже стоит в профиле преподавателя!";}
		}else{$error_add_lesson = "Вы не выбрали преподавателя!";}
	}else{$error_add_lesson = "Вы не выбрали предмет для добавления в профиль преподавателя!";}
}

$teachers = R::find('accounts_generated', 'account_type = ? AND institution_id	= ?', array(2, Institution::$ID));
$all_lessons = R::find('lessons', 'institution_id = ?', array(Institution::$ID));


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
          acceptedFiles: 'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          thumbnailHeight: 80,
          parallelUploads: 20,
          previewTemplate: previewTemplate,
          previewsContainer: ".file-upload-list"
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
	function addTamplateTeacher(){
		var template = document.createElement('div');
		template.className = 'row';
		template.innerHTML = '<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputSurnameTeacher_'+id_template+'" class="form-label">Фамилия преподавателя</label><input type="text" name="surname_teacher_'+id_template+'" id="inputSurnameTeacher_'+id_template+'" class="form-control form-control-input"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputNameTeacher_'+id_template+'" class="form-label">Имя преподавателя</label><input type="text" name="name_teacher_'+id_template+'" id="inputNameTeacher_'+id_template+'" class="form-control form-control-input"></div></div><div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12"><div class="modal-body"><label for="inputMiddleNameTeacher_'+id_template+'" class="form-label">Отчество преподавателя</label><input type="text" name="middle-name_teacher_'+id_template+'" id="inputMiddleNameTeacher_'+id_template+'" class="form-control form-control-input"></div></div>';
		document.querySelector("#all_add_teachers_list").append(template);
		id_template++;
	}

	function deleteTamplateTeacher(){
		if (id_template >= 2) {
			var last_template_dom = document.querySelector("#all_add_teachers_list");
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

	function editTeacherInfo(user_id){

		$.ajax({
			url: '/assets/ajax/ajax.user-info.php',
			type: 'POST',
			dataType: 'json',
			data: {user_id: user_id},
		})
		.done(function(data) {
			if (data.status) {
				let user = data.user;
				document.querySelector('input#user_id').value = user.id;
				document.querySelector('input#user_id_th').value = user.id;
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

	function closeEditTeacherInfo(){
		document.querySelector('.block_edit_user').style.display = "none";
		document.querySelector('.block_drive').style.display = "block";
	}

	function deleteLessonForTeacher(el, id_lesson, id_teacher){
		$.ajax({
			url: '/assets/ajax/ajax.delete-lesson-for-teacher.php',
			type: 'POST',
			dataType: 'json',
			data: {id_lesson: id_lesson, id_teacher: id_teacher},
		})
		.done(function(data) {
			console.log("success");
			// console.log(data);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
			console.log(data.status);
			if (data.status) {
				el.parentElement.remove();
			}else{
				alert(data.message);
			}
		});
		
	}

	function generatingAuthInfo(){

		$.ajax({
			url: '/assets/ajax/ajax.generating-auth-info-teacher.php',
			type: 'POST',
			dataType: 'json',
			data: {},
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
		    $a.attr("download","Аккаунты преподавателей.xls");
		    $a[0].click();
		    $a.remove();
		});
		
	}
</script>