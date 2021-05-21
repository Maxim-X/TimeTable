<?php 
Route::$TITLE = "Расписание группы ";
Route::$DESCRIPTION = "Расписание группы ";

$institution_id = trim($_GET['institution_id']);
$group_id = trim($_GET['group_id']);



if (empty($group_id) && !empty($institution_id)) {
	$all_groups = R::findAll('groups_students', 'id_institution = ? ORDER BY `name` DESC', array($institution_id));
	$institution = R::findOne('institutions', 'id = ?', array($institution_id));
}else if (!empty($group_id)) {
	$group = R::findOne('groups_students', 'id = ?', array($group_id));
	if (!$group) {
		die('Группа не найдена!'); 
	}
	$institution = R::findOne('institutions', 'id = ?', array($group->id_institution));
	Route::$TITLE = "Расписание группы ".$group->name;
	Route::$DESCRIPTION = "Расписание группы ".$group->name;
}

$day_of_the_week = R::find("day_of_the_week");

if ($group->use_even == 1) {
	$name_week = array('Нечетная', 'Четная');
	$even_numbered = $week % 2 == 0 && $group->use_even == 1 ? 1:0;
	$name_week = $name_week[$even_numbered];
}
?>

<script>
	window.onload = function(){
		function open_full_info_lesson(Element){
			
			var block = document.querySelector('#modal-full-info-lesson');
			block.classList.add('active');
			var schedule_id = Element.getAttribute('id_schedule');
			var date = Element.getAttribute('date');
			console.log(date);
			$.ajax({
				url: '/assets/ajax/ajax.get-shedule-info.php',
				type: 'POST',
				dataType: 'json',
				data: {schedule_id: schedule_id, date: date},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				//Заменяемый предмет
				if (typeof data['replace'] !== "undefined") {
					console.log(document.querySelector('.replace-info'));
					document.querySelector('.lesson-name').innerHTML = data['lesson_replace']['name'];
					document.querySelector('.lesson-time').innerHTML = data['timeline']['time_start'].slice(0, -3) + " - " + data['timeline']['time_end'].slice(0, -3);
					document.querySelector('.lesson-name').innerHTML = data['lesson_replace']['name'];
					document.querySelector('#name_teacher').innerHTML = data['teacher_replace']['surname'] + " " + data['teacher_replace']['name'] + " " + data['teacher_replace']['middle_name'];
					var num_office = data['replace']['office']+" кабинет, ";
					if (data['replace']['floor'] != null) {
						num_office = num_office + data['replace']['floor']+" этаж, ";
					}
					if (data['replace']['building'] != null) {
						num_office = num_office + data['replace']['building']+" корпус";
					}
					document.querySelector('#num_office').innerHTML = num_office;


					document.querySelector('#name_lesson_replace').innerHTML = data['lesson']['name'];
					document.querySelector('#name_teacher_replace').innerHTML = data['teacher']['surname'] + " " + data['teacher']['name'] + " " + data['teacher']['middle_name'];
					
					var num_office = data['schedule']['office']+" кабинет, ";
					if (data['schedule']['floor'] != null) {
						num_office = num_office + data['schedule']['floor']+" этаж, ";
					}
					if (data['schedule']['building'] != null) {
						num_office = num_office + data['schedule']['building']+" корпус";
					}

					document.querySelector('#num_office_replace').innerHTML = num_office;
					document.querySelector('.replace-info').style.display = "block";
				}else{
					document.querySelector('.lesson-name').innerHTML = data['lesson']['name'];
					document.querySelector('.lesson-time').innerHTML = data['timeline']['time_start'].slice(0, -3) + " - " + data['timeline']['time_end'].slice(0, -3);
					document.querySelector('.lesson-name').innerHTML = data['lesson']['name'];
					document.querySelector('#name_teacher').innerHTML = data['teacher']['surname'] + " " + data['teacher']['name'] + " " + data['teacher']['middle_name'];
					var num_office = data['schedule']['office']+" кабинет, ";
					if (data['schedule']['floor'] != null) {
						num_office = num_office + data['schedule']['floor']+" этаж, ";
					}
					if (data['schedule']['building'] != null) {
						num_office = num_office + data['schedule']['building']+" корпус";
					}
					document.querySelector('#num_office').innerHTML = num_office;
					document.querySelector('.replace-info').style.display = "none";
					console.log(document.querySelector('.replace-info'));
				}
				document.querySelector('#modal-full-info-back').classList.add('active');
			});
			
		}
		function close_full_info_lesson(){
			document.querySelector('#modal-full-info-back').classList.remove('active');
			document.querySelector('#modal-full-info-lesson').classList.remove('active');;

		}

		var lessons = document.querySelectorAll('#one_lesson');
		lessons.forEach(function(item) {
			item.addEventListener("click", function() {
				open_full_info_lesson(item);
			});
		});

		var close_modal = document.querySelector('#close-modal-full-info');
		var close_modal_back = document.querySelector('#modal-full-info-back');
		close_modal.addEventListener("click", function() {
			close_full_info_lesson();
		});
		close_modal_back.addEventListener("click", function() {
			close_full_info_lesson();
		});


	}
</script>