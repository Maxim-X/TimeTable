<?PHP
  
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Временной график";
Route::$DESCRIPTION = "Временной график";

if (isset($_POST['add_head-timeline'])) {
	$name_head_timeline = trim($_POST['input_name_head-timeline']);
	if (!empty($name_head_timeline)) {
		$user = R::load('head_timeline', $user_id);
		$head_timeline = R::xdispense('head_timeline');
		$head_timeline->id_institution = Account::$INSTITUTION_ID;
		$head_timeline->name = $name_head_timeline;
		R::store($head_timeline);
	}
}

if (isset($_POST['add_timeline'])) {
	$add_timeline_error = array();
	$name_head_timeline = trim($_POST['input_name-timeline']);
	$time_start_hours = trim($_POST['inputTimeStartHours']);
	$time_start_minutes = trim($_POST['inputTimeStartMinutes']);
	$time_end_hours = trim($_POST['inputTimeEndHours']);
	$time_end_minutes = trim($_POST['inputTimeEndMinutes']);
	$head_id = trim($_POST['inputHeadId']);

	if (empty($name_head_timeline)) {
		array_push($add_timeline_error, 'Название введено неверно!');
	}

	if ((empty($time_start_hours) || $time_start_hours <= 0 || $time_start_hours >= 24)
		&& (empty($time_start_minutes) || $time_start_minutes <= 0 || $time_start_minutes >= 60)
		&& (empty($time_end_hours) || $time_end_hours <= 0 || $time_end_hours >= 24)
		&& (empty($time_end_minutes) || $time_end_minutes <= 0 || $time_end_minutes >= 60)) {
		array_push($add_timeline_error, 'Время введено неверно!');
	}

	$time_start_lesson = new DateTimeImmutable($time_start_hours . ":" . $time_start_minutes);
	$time_end_lesson = new DateTimeImmutable($time_end_hours . ":" . $time_end_minutes);

	if ($time_start_lesson >= $time_end_lesson) {
		array_push($add_timeline_error, 'Временной диапазон введен неверно!');
	}
	if ($time_start_lesson >= $time_end_lesson) {
		array_push($add_timeline_error, 'Временной диапазон введен неверно!');
	}

	$check_use_head = R::count('head_timeline', 'id = ? AND id_institution = ?', array($head_id, Account::$INSTITUTION_ID));
	if ($check_use_head == 0) {
		array_push($add_timeline_error, 'Идентификатор временного графика введен неверно!');
	}

	$chek_timeline = R::count("timeline", "id_head_timeline = ? AND ((time_start BETWEEN '".$time_start_hours.":".$time_start_minutes.":00' AND '".$time_end_hours.":".$time_end_minutes.":00') OR (time_end BETWEEN '".$time_start_hours.":".$time_start_minutes.":00' AND '".$time_end_hours.":".$time_end_minutes.":00'))", array($head_id));

	$chek_timeline_2 = R::count("timeline", "id_head_timeline = ? AND (('".$time_start_hours.":".$time_start_minutes.":00' BETWEEN time_start AND time_end) AND ('".$time_end_hours.":".$time_end_minutes.":00' BETWEEN time_start AND time_end))", array($head_id));

	// echo $chek_timeline;
	// echo "<br>";
	// echo $chek_timeline_2;
	if ($chek_timeline != 0 || $chek_timeline_2 != 0) {
		array_push($add_timeline_error, 'Временной диапазон введен неверно!');
	}

	if (count($add_timeline_error) == 0) {
		$timeline = R::xdispense('timeline');
		$timeline->name = $name_head_timeline;
		$timeline->time_start = $time_start_hours.":".$time_start_minutes.":00";
		$timeline->time_end = $time_end_hours.":".$time_end_minutes.":00";
		$timeline->id_head_timeline = $head_id;
		R::store($timeline);
	}
}

if (isset($_POST['timeline_del'])) {
	$del_timeline_error = array();
	$id_timeline_del = trim($_POST['id_timeline_del']);
	$delete = R::load('timeline', $id_timeline_del);

	if (empty($id_timeline_del)) {
		array_push($error_del, "Идентификатор указан неверно!");
	}
	
	try {
	    R::trash($delete);
	    header("Refresh: 0");
	} catch (Exception $e) {
	    array_push($del_timeline_error, "Что-бы удалить элемент временного расписания, вам необходимо удалить его из расписания и замен занятий!");
	}
}

$all_head_timeline = R::find('head_timeline', 'id_institution = ?', array(Account::$INSTITUTION_ID));
?>

<script>
		function show_form_add_timeline(id_head){
			document.querySelector('#inputHeadId').value = id_head;
		}

		window.onload = function(){

			document.querySelector('input#inputTimeStartHours').oninput = function(){
		    		let regex = /[^0-9]/g;
					this.value = this.value.replace(regex, '');
		    		if (this.value < 0 || this.value > 23) {
		    			document.querySelector('input#inputTimeStartHours').value = "";
		    		}
		    }

		    document.querySelector('input#inputTimeStartMinutes').oninput = function(){
		    		let regex = /[^0-9]/g; 
	 				this.value = this.value.replace(regex, '');
		    		if (this.value < 0 || this.value > 59) {
		    			document.querySelector('input#inputTimeStartMinutes').value = "";
		    		}
		    }

		    document.querySelector('input#inputTimeEndHours').oninput = function(){
		    		let regex = /[^0-9]/g;
					this.value = this.value.replace(regex, '');
		    		if (this.value < 0 || this.value > 23) {
		    			document.querySelector('input#inputTimeEndHours').value = "";
		    		}
		    }

		    document.querySelector('input#inputTimeEndMinutes').oninput = function(){
		    		let regex = /[^0-9]/g; 
	 				this.value = this.value.replace(regex, '');
		    		if (this.value < 0 || this.value > 59) {
		    			document.querySelector('input#inputTimeEndMinutes').value = "";
		    		}
		    }
		}
</script>