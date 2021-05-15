<?php 
// Проверка на авторизацию
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /');
	die();
}

Route::$TITLE = "Календарь замен занятий";
Route::$DESCRIPTION = "Календарь замен занятий";
$date_day = $_GET['date'];
$date_day_format = date('Y-m-d', strtotime($_GET['date']));
$all_lessons = R::find("lessons", "institution_id = ?", array(Institution::$ID));
$all_head_timeline = R::find("head_timeline", "id_institution = ?", array(Institution::$ID));


if (!isset($_GET['group'])) {
	$_GET['group'] = 0;
}

?>



<script>
	window.onload = function(){


		function get_groups_none_repl(){

			$.ajax({
				url: '/assets/ajax/ajax.get-group-none-replacing.php',
				type: 'POST',
				dataType: 'json',
				data: {date: '<?=$_GET['date'];?>'},
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
				var all_groups_none_repl = data['all_groups_none_repl'];
				all_groups_none_repl.forEach(function(item) {
					$("#inputGroupSelect04").append(" <option value='/replacing/edit/<?=$_GET['date'];?>?group="+item['id']+"'>"+item['name']+"</option>");
				});
			});
		}
		

		function get_replacing_day(date_day){
			$.ajax({
				url: '/assets/ajax/ajax.get-replacing-day.php',
				type: 'POST',
				dataType: 'json',
				data: {date_day: date_day},
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
				var all_replacing = data['all_replacing'];

				document.querySelector('#num_repl_lesson').innerHTML = '('+all_replacing.length+')';
				var block_all_repl = document.querySelector('#all_folders_repl');
				block_all_repl.innerHTML = "";
				all_replacing.forEach(function(item) {
					block_all_repl.innerHTML += '<a href="/replacing/edit/<?=$date_day;?>?group='+item["id"]+'"><div class="item_repl_lesson"><img src="/resources/images/icon/folder.svg" alt="folder"><div>Группа '+item["group_name"]+'</div><p>Замен: '+item["count"]+'</p></div></a>';
				});
			});

			document.querySelector('select#inputHeadTimeline').onchange = function() {
				get_true_timeline();
	    	};
		}

		document.querySelector('select#input_edit_Lesson').onchange = function() {
			get_teacher_for_lesson();
		}

		

		get_replacing_day('<?=$_GET['date'];?>');
		get_groups_none_repl();
	}
		function open_group(){
			var select = $('#inputGroupSelect04').val();
			if (select != 'Выберите группу') {
				location.href=select;
			}
		}

	function get_teacher_for_lesson(id_lesson = 0, id_teacher = null) {
				if (id_lesson == 0) {
					var num_selected = document.querySelector('select#input_edit_Lesson').options.selectedIndex;
					var selected_lesson = document.querySelector('select#input_edit_Lesson').options[num_selected];
					id_lesson = selected_lesson.value;
				}

				if (id_lesson > 0) {
					$.ajax({
						url: '/assets/ajax/ajax.get-teachers-for-lesson.php',
						type: 'POST',
						dataType: 'json',
						data: {id_lesson: id_lesson},
					})
					.always(function(data) {
						document.querySelector("select#input_edit_Teacher").innerHTML='';
						if (data['all_teachers'].length > 0) {
							data['all_teachers'].forEach(function(item, i, arr) {
								if (id_teacher != null && id_teacher == item['id']) {
									 $('#input_edit_Teacher').prepend('<option value="'+item['id']+'" selected>'+item['surname']+' '+item['name']+' '+item['middle_name']+'</option>');
									}else{
										 $('#input_edit_Teacher').prepend('<option value="'+item['id']+'">'+item['surname']+' '+item['name']+' '+item['middle_name']+'</option>');
									}
							 
							});
						}else{
							document.querySelector("select#input_edit_Teacher").innerHTML='';
						}
					});

					
					
					document.querySelector('select#input_edit_Teacher').disabled = false;
				}else{
					document.querySelector('select#input_edit_Teacher').disabled = true;
					document.querySelector("select#input_edit_Teacher").innerHTML='';
				}
	    	};

	    function cancel_lesson(){
			event.preventDefault()
			let id_schedule = document.querySelector('input#input_edit_Schedule').value;
			let date = document.querySelector('input#input_edit_Date').value;
			$.ajax({
				url: '/assets/ajax/ajax.add-replacing.php',
				type: 'POST',
				dataType: 'json',
				data: {type: 2, id_schedule:id_schedule, date:date},
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

		function add_new_replace(){
			event.preventDefault()
			let id_schedule = document.querySelector('input#input_edit_Schedule').value;
			let id_lesson = document.querySelector('select#input_edit_Lesson').value;
			let id_group = document.querySelector('input#input_edit_id_group').value;
			let id_teacher = document.querySelector('select#input_edit_Teacher').value;


			let date = document.querySelector('input#input_edit_Date').value;
			let office = document.querySelector('input#input_edit_Office').value;
			let floor = document.querySelector('input#input_edit_Floor').value;
			let building = document.querySelector('input#input_edit_Building').value;


			$.ajax({
				url: '/assets/ajax/ajax.add-replacing.php',
				type: 'POST',
				dataType: 'json',
				data: {type: 1, id_schedule:id_schedule, id_lesson:id_lesson, id_group:id_group, id_teacher:id_teacher, date:date, office:office, floor:floor, building:building},
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

		function show_form_add_schedule(elem){
			document.querySelector('input#inputIdDay').value = elem.getAttribute('day');
			// get_true_timeline();
		}

	    	function get_schedule_info(schedule_id){
			$.ajax({
				url: '/assets/ajax/ajax.get-schedule-by-id.php',
				type: 'POST',
				dataType: 'json',
				data: {schedule_id: schedule_id},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function(data) {
				var schedule = data['schedule'];
				document.querySelector('input#input_edit_Schedule').value = schedule_id;
				$('#input_edit_Lesson option[value='+schedule['id_lesson']+']').prop('selected', true);
				get_teacher_for_lesson(schedule['id_lesson'], schedule['id_teacher']);
				
				document.querySelector('input#input_edit_Office').value = schedule['office'];
				document.querySelector('input#input_edit_Floor').value = schedule['floor'];
				document.querySelector('input#input_edit_Building').value = schedule['building'];
			});
		}
		
		function get_true_timeline(){
    		var num_selected = document.querySelector('select#inputHeadTimeline').options.selectedIndex;
			var selected_lesson = document.querySelector('select#inputHeadTimeline').options[num_selected];

			var id_group = document.querySelector('input#inputIdGroup').value;
			var id_day = document.querySelector('input#inputIdDay').value;
			var even_numbered = document.querySelector('input#inputEvenNumbered').value;

			if (selected_lesson.value > 0) {
				$.ajax({
					url: '/assets/ajax/ajax.get-time-for-timeline.replace.php',
					type: 'POST',
					dataType: 'json',
					data: {id_head_timeline: selected_lesson.value, id_group: <?=$_GET['group'];?>, date_day: <?=$_GET['date'];?>,},
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
    	}


</script>