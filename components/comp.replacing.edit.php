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
// $all_replacing = R::getAll('SELECT (SELECT name FROM groups_students WHERE id = replacing.id_group), COUNT(replacing.id) AS count FROM replacing WHERE replacing.id_group IN (SELECT id FROM groups_students WHERE id_institution = ?) AND replacing.date = ? GROUP BY replacing.id_group', array(Account::$INSTITUTION_ID, $date_day_format));
// // $all_replacing = R::exportAll( $all_replacing );
// echo "<pre>";
// var_dump($all_replacing);
// echo "</pre>";

?>



<script>
	window.onload = function(){
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
					block_all_repl.innerHTML += '<div class="item_repl_lesson"><img src="/resources/images/icon/folder.svg" alt="folder"><div>Группа '+item["group_name"]+'</div><p>Замен: '+item["count"]+'</p></div>';
				});
			});

			document.querySelector('select#inputHeadTimeline').onchange = function() {
				get_true_timeline();
	    	};
		}


		

		get_replacing_day('<?=$_GET['date'];?>');
	}

		function show_form_add_schedule(elem){
			document.querySelector('input#inputIdDay').value = elem.getAttribute('day');
			// get_true_timeline();
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