<?PHP
  
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}
$id_group = htmlspecialchars(trim($_GET['id']));

$group = R::findOne('groups_students', 'id = ?', array($id_group));

if (!$group) {
	die('Группа не найдена!'); 
}
if ($group->id_institution != Account::$INSTITUTION_ID) {
	die('У вас нет доступа к данной группе!'); 
}

Route::$TITLE = "Расписание для группы " . $group->name;
Route::$DESCRIPTION = "Расписание для группы " . $group->name;


if (isset($_POST['save_edit_even'])) {
	if ($_POST['edit_even']) {
		$group_edit = R::load('groups_students', $group->id);
		$group_edit->use_even = 1;
		R::store($group_edit);
	}else{
		$group_edit = R::load('groups_students', $group->id);
		$group_edit->use_even = 0;
		R::store($group_edit);
	}
	$group = R::findOne('groups_students', 'id = ?', array($id_group));
}

if (isset($_POST['save_edit_sunday'])) {
	if ($_POST['edit_sunday']) {
		$group_edit = R::load('groups_students', $group->id);
		$group_edit->use_sunday = 1;
		R::store($group_edit);
	}else{
		$group_edit = R::load('groups_students', $group->id);
		$group_edit->use_sunday = 0;
		R::store($group_edit);
	}
	$group = R::findOne('groups_students', 'id = ?', array($id_group));
}

if ($group->use_sunday == 0) {
	$day_of_the_week = R::find("day_of_the_week", "id != ?", array(7));
}else{
	$day_of_the_week = R::find("day_of_the_week");
}

$all_lessons = R::find("lessons", "institution_id = ?", array(Institution::$ID));
$all_head_timeline = R::find("head_timeline", "id_institution = ?", array(Institution::$ID));

if ($group->use_even) {
	$check_use_even = 'checked';
}
if ($group->use_sunday) {
	$check_use_sunday = 'checked';
}
?>

<script>
	window.onload = function() {
		document.querySelector('select#inputLesson').onchange = function() {
				var num_selected = document.querySelector('select#inputLesson').options.selectedIndex;
				var selected_lesson = document.querySelector('select#inputLesson').options[num_selected];
				if (selected_lesson.value > 0) {
					$.ajax({
						url: '/assets/ajax/ajax.get-teachers-for-lesson.php',
						type: 'POST',
						dataType: 'json',
						data: {id_lesson: selected_lesson.value},
					})
					.always(function(data) {
						document.querySelector("select#inputTeacher").innerHTML='';
						if (data['all_teachers'].length > 0) {
							data['all_teachers'].forEach(function(item, i, arr) {
							  $('#inputTeacher').prepend('<option value="'+item['id']+'">'+item['surname']+' '+item['name']+' '+item['middle_name']+'</option>');
							});
						}else{
							document.querySelector("select#inputTeacher").innerHTML='';
						}
						
					});
					
					document.querySelector('select#inputTeacher').disabled = false;
				}else{
					document.querySelector('select#inputTeacher').disabled = true;
					document.querySelector("select#inputTeacher").innerHTML='';
				}
	    	};

	    	document.querySelector('select#inputHeadTimeline').onchange = function() {
				var num_selected = document.querySelector('select#inputHeadTimeline').options.selectedIndex;
				var selected_lesson = document.querySelector('select#inputHeadTimeline').options[num_selected];
				if (selected_lesson.value > 0) {
					$.ajax({
						url: '/assets/ajax/ajax.get-time-for-timeline.php',
						type: 'POST',
						dataType: 'json',
						data: {id_head_timeline: selected_lesson.value},
					})
					.always(function(data) {
						console.log(data['times']);
						document.querySelector("select#inputTime").innerHTML='';
						console.log(data['times'].length);
						if (data['times'].length > 0) {
							data['times'].forEach(function(item, i, arr) {
								if (i == 0) {var selected = 'selected';}else{selected = "";}
							  $('#inputTime').append('<option '+selected+' value="'+item['id']+'">'+item['time_start'].substring(0, item['time_start'].length - 3)+' - '+item['time_end'].substring(0, item['time_end'].length - 3)+'</option>');
							});
						}else{
							document.querySelector("select#inputTime").innerHTML='';
						}
						
					});
					
					document.querySelector('select#inputTime').disabled = false;
				}else{
					document.querySelector('select#inputTime').disabled = true;
					document.querySelector("select#inputTime").innerHTML='';
				}
	    	};

	   //  document.querySelector('input#inputTimeStartHours').oninput = function(){
	   //  		let regex = /[^0-9]/g;
				// this.value = this.value.replace(regex, '');
	   //  		if (this.value < 0 || this.value > 23) {
	   //  			document.querySelector('input#inputTimeStartHours').value = "";
	   //  		}
	   //  }

	   //  document.querySelector('input#inputTimeStartMinutes').oninput = function(){
	   //  		let regex = /[^0-9]/g; 
 			// 	this.value = this.value.replace(regex, '');
	   //  		if (this.value < 0 || this.value > 59) {
	   //  			document.querySelector('input#inputTimeStartMinutes').value = "";
	   //  		}
	   //  }

	   //  document.querySelector('input#inputTimeEndHours').oninput = function(){
	   //  		let regex = /[^0-9]/g;
				// this.value = this.value.replace(regex, '');
	   //  		if (this.value < 0 || this.value > 23) {
	   //  			document.querySelector('input#inputTimeEndHours').value = "";
	   //  		}
	   //  }

	   //  document.querySelector('input#inputTimeEndMinutes').oninput = function(){
	   //  		let regex = /[^0-9]/g; 
 			// 	this.value = this.value.replace(regex, '');
	   //  		if (this.value < 0 || this.value > 59) {
	   //  			document.querySelector('input#inputTimeEndMinutes').value = "";
	   //  		}
	   //  }

	    document.querySelector('input#inputOffice').oninput = replaceOffice();
	    document.querySelector('input#inputFloor').oninput = replaceOffice();
	    document.querySelector('input#inputBuilding').oninput = replaceOffice();

	    function replaceOffice(){
	    	let regex = /[^0-9]/g; 
 			this.value = this.value.replace(regex, '');
	    }
	}
		function show_form_add_schedule(elem){
			document.querySelector('input#inputIdDay').value = elem.getAttribute('day');
			document.querySelector('input#inputEvenNumbered').value = elem.getAttribute('even_numbered');
		}

		function add_new_schedule(){
			event.preventDefault()
			let id_lesson = document.querySelector('select#inputLesson').value;
			let id_head_timeline = document.querySelector('select#inputHeadTimeline').value;
			let id_timeline = document.querySelector('select#inputTime').value;

			
			let id_teacher = document.querySelector('select#inputTeacher').value;
			let office = document.querySelector('input#inputOffice').value;
			let floor = document.querySelector('input#inputFloor').value;
			let building = document.querySelector('input#inputBuilding').value;

			let id_group = document.querySelector('input#inputIdGroup').value;
			let id_day = document.querySelector('input#inputIdDay').value;
			let even_numbered = document.querySelector('input#inputEvenNumbered').value;

			$.ajax({
				url: '/assets/ajax/ajax.add-schedule.php',
				type: 'POST',
				dataType: 'json',
				data: {id_lesson: id_lesson, id_head_timeline: id_head_timeline, id_timeline: id_timeline, id_teacher: id_teacher, office: office, floor: floor, building: building, id_group: id_group, id_day: id_day, even_numbered: even_numbered},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				console.log("complete");
				console.log(data);
			});
			

		}

</script>