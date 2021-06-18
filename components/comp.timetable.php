<?php

if (!Account::$AUTH || !(Account::$ACCOUNT_TYPE != 1 || Account::$ACCOUNT_TYPE != 2)) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Расписание";
Route::$DESCRIPTION = "Расписание";

// $group = R::findOne('groups_students', 'id = ?', array(Account::$GROUP_ID));

// if (!$group) {
// 	die('Группа не найдена!'); 
// }
$week = date('W');
$day_of_the_week = R::find("day_of_the_week");

$name_week = array('Нечетная', 'Четная');
$even_numbered = $week % 2 == 0 ? 1:0;
$name_week = $name_week[$even_numbered];


?>

<script>
	window.onload = function(){
		function open_full_info_lesson(Element){
			
			var block = document.querySelector('#modal-full-info-lesson');
			
			if (Element.hasAttribute('id_schedule')) {
				var schedule_id = Element.getAttribute('id_schedule');
			}
			if (Element.hasAttribute('id_replace')) {
				var replace_id = Element.getAttribute('id_replace');
			}
			var date = Element.getAttribute('date');
			console.log(date);
			$.ajax({
				url: '/assets/ajax/ajax.get-shedule-info.php',
				type: 'POST',
				dataType: 'json',
				data: {schedule_id: schedule_id, replace_id: replace_id, date: date},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				document.querySelector('#modal-full-info-back').classList.add('active');
				console.log(data);
				//Заменяемый предмет
				document.querySelector('#name_group').innerHTML = data['group_name'];
				if (typeof data['replace'] !== "undefined") {
					// console.log(document.querySelector('.replace-info'));
					document.querySelector('.lesson-name').innerHTML = data['lesson_replace']['name'];
					document.querySelector('.lesson-time').innerHTML = data['timeline']['time_start'].slice(0, -3) + " - " + data['timeline']['time_end'].slice(0, -3);
					var num_office = data['replace']['office']+" кабинет, ";
					if (data['replace']['floor'] != null) {
						num_office = num_office + data['replace']['floor']+" этаж, ";
					}
					if (data['replace']['building'] != null) {
						num_office = num_office + data['replace']['building']+" корпус";
					}
					document.querySelector('#num_office').innerHTML = num_office;
					document.querySelector('#name_lesson_replace').innerHTML = data['lesson']['name'];
					//document.querySelector('#name_teacher_replace').innerHTML = data['teacher']['surname'] + " " + data['teacher']['name'] + " " + data['teacher']['middle_name'];
					
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
					var num_office = data['schedule']['office']+" кабинет, ";
					if (data['schedule']['floor'] != null) {
						num_office = num_office + data['schedule']['floor']+" этаж, ";
					}
					if (data['schedule']['building'] != null) {
						num_office = num_office + data['schedule']['building']+" корпус";
					}
					document.querySelector('#num_office').innerHTML = num_office;
					document.querySelector('.replace-info').style.display = "none";
				}
				block.classList.add('active');
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