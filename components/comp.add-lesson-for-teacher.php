<?php 
// Проверка на авторизацию
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /');
	die();
}
$id_teacher = trim($_GET['id']);
$teacher = R::findOne('accounts_generated', 'id = ?', array($id_teacher));

if (empty($id_teacher) || !isset($id_teacher)) {
	header('Location: /');
	die();
}

$checked_teacher = R::findOne('accounts_generated', 'id = ? AND institution_id = ?', array($id_teacher, Account::$INSTITUTION_ID));
if (!$checked_teacher) {
	header('Location: /');
	die();
}

Route::$TITLE = "Назначение предметов для преподавателей";
Route::$DESCRIPTION = "Назначение предметов для преподавателей";

$alt = isset($_GET['alt']) ? true : false;

$alt_url = $alt ? "/add-lesson-for-teacher/$id_teacher" : "/add-lesson-for-teacher/$id_teacher?alt=";

$all_group = R::find('groups_students','id_institution = ?', array(Account::$INSTITUTION_ID));
$all_lesson = R::find('lessons','institution_id = ?', array(Account::$INSTITUTION_ID));
$teachers_lessons = R::find('teachers_lessons', 'id_teacher = ?', array($id_teacher));

$teachers_lessons = R::exportAll( $teachers_lessons );

function search_check($id_lesson, $id_group, $teachers_lessons){
	foreach ($teachers_lessons as $teacher_lesson) {
		if ($teacher_lesson['id_lesson'] == $id_lesson && $teacher_lesson['id_group'] == $id_group) {
			return true;
		}
	}
	return false;
}

?>

<script>
	function select_cells(elem, id_lesson, id_group){
		$('.calendar.opt thead tr th[group_id='+id_group+']').css('background', '#5c92fd');
		$('.calendar.opt tbody tr th[lesson_id='+id_lesson+']').css('background', '#5c92fd');
		elem.css('background', 'rgb(92 146 253 / 27%)');
	}

	function select_cells_out(elem, id_lesson, id_group){
		$('.calendar.opt thead tr th[group_id='+id_group+']').css('background', '');
		$('.calendar.opt tbody tr th[lesson_id='+id_lesson+']').css('background', '');
		elem.css('background', '');
	}

	function edit_use_lesson(elem){
		var teacher_id = '<?=$id_teacher;?>';
		var lesson_id = elem.attr('id_lesson');
		var group_id = elem.attr('id_group');

		if (elem.is(':checked')){
			var action = 'on';
		} else {
			var action = 'off';
		}

		$.ajax({
			url: '/assets/ajax/ajax.edit-lesson-for-teacher.php',
			type: 'POST',
			dataType: 'json',
			data: {teacher_id: teacher_id, lesson_id: lesson_id, group_id: group_id , action: action},
		})
		.always(function(data) {
			if(!data['status']){
				alert(data['message']);
			}
		});
		
	}

	function edit_del_lesson(elem){
		var teacher_id = '<?=$id_teacher;?>';
		var lesson_id = elem.attr('id_lesson');
		var group_id = elem.attr('id_group');

		$.ajax({
			url: '/assets/ajax/ajax.edit-lesson-for-teacher.php',
			type: 'POST',
			dataType: 'json',
			data: {teacher_id: teacher_id, lesson_id: lesson_id, group_id: group_id , action: 'off'},
		})
		.always(function(data) {
			if(!data['status']){
				alert(data['message']);
			}else{
				window.location.reload();
			}
		});
		
	}

	jQuery(document).ready(function($) {
		function edit_add_lesson(){
			var teacher_id = '<?=$id_teacher;?>';
			var lesson_id = $('select#inputLesson').val();
			var group_id = $('select#inputGroup').val();
			console.log(lesson_id);
			console.log(group_id);

			var error_inp = false;
			if(lesson_id == "" || lesson_id == 0){
				alert('Выберите предмет из списка доступных.');
				error_inp = true;
			}
			if(group_id == "" || group_id == 0){
				alert('Выберите группу из списка доступных.');
				error_inp = true;
			}

			if(!error_inp){
				$.ajax({
					url: '/assets/ajax/ajax.edit-lesson-for-teacher.php',
					type: 'POST',
					dataType: 'json',
					data: {teacher_id: teacher_id, lesson_id: lesson_id, group_id: group_id , action: 'on'},
				})
				.always(function(data) {
					if(!data['status']){
						alert(data['message']);
					}else{
						window.location.reload();
					}
				});
			}
			
		}

		$('button[name="add-lesson-for-teacher"]').click(function(){
			event.preventDefault()
		  edit_add_lesson();
		});
	});


	
</script>