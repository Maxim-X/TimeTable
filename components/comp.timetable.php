<?php

if (!Account::$AUTH || !(Account::$ACCOUNT_TYPE != 1 || Account::$ACCOUNT_TYPE != 2)) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Расписание";
Route::$DESCRIPTION = "Расписание";

$group = R::findOne('groups_students', 'id = ?', array(Account::$GROUP_ID));

if (!$group) {
	die('Группа не найдена!'); 
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
			console.log("11");
			document.querySelector('#modal-full-info-back').classList.add('active');
			var block = document.querySelector('#modal-full-info-lesson');
			block.classList.add('active');
		}
		function close_full_info_lesson(){
			document.querySelector('#modal-full-info-back').classList.remove('active');
			document.querySelector('#modal-full-info-lesson').classList.remove('active');;

		}

		var lessons = document.querySelectorAll('#one_lesson');
		lessons.forEach(function(item) {
			item.addEventListener("click", function() {
				open_full_info_lesson();
			});
		});

		var lessons = document.querySelectorAll('#one_lesson');
		lessons.forEach(function(item) {
			item.addEventListener("click", function() {
				open_full_info_lesson();
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