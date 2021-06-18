<?php

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Все учебные предметы";
Route::$DESCRIPTION = "Все учебные предметы";




if (isset($_POST['add_lesson'])) {
	$name_lesson = trim($_POST['name_lesson']);
	$error = array();

	if (empty($name_lesson) || !isset($name_lesson)) {
		array_push($error, "Название предмета введено неверно!");
	}

	$group_name_find = R::findOne('lessons', 'name = ? AND institution_id = ?', array($name_lesson, Account::$INSTITUTION_ID));
	if ($group_name_find) {
		array_push($error, "Предмет с таким название уже создан!");
	}

	if (count($error) == 0) {
		$add_lesson = R::xdispense('lessons');
		$add_lesson->name = $name_lesson;
		$add_lesson->institution_id = Account::$INSTITUTION_ID;
		R::store($add_lesson);

		header("Refresh: 0");
	}
}

if (isset($_POST['delete_lesson_id'])) {
	$delete_lesson_id = trim($_POST['delete_lesson_id']);
	$error_del = array();

	$lesson_id_find = R::findOne('lessons', 'id = ? AND institution_id = ?', array($delete_lesson_id, Account::$INSTITUTION_ID));
	if (!$lesson_id_find) {
		array_push($error_del, "Предмет не найден!");
	}


	if (count($error_del) == 0) {
		$delete = R::load('lessons', $delete_lesson_id);
		
		try {
		    R::trash($delete);
		    header("Refresh: 0");
		} catch (Exception $e) {
		    array_push($error_del, "Что-бы удалить предмет, вам необходимо удалить его из основного расписания, замен занятий и из предметов которые ведут праподаватели!");
		}
		

		
	}
}
$def_col = 'id';
$def_sort = 'ASC';
$def_a_id = '/lessons?sort_id=1';

$def_a_name = '/lessons?sort_name=1';

if (!isset($_GET['sort_id']) && !isset($_GET['sort_name'])) {
	$arrow_id = '&#9650;';
}else{
	if (isset($_GET['sort_id'])) {
		if ($_GET['sort_id'] == 1) {
			$def_sort = 'DESC';
			$def_a_id = '/lessons';
			$arrow_id = '&#9660;';
		}
	}

	if (isset($_GET['sort_name'])) {
		if ($_GET['sort_name'] == 1) {
			$def_col = 'name';
			$def_sort = 'DESC';
			$def_a_name = '/lessons?sort_name=2';
			$arrow_name = '&#9660;';
		}else{
			$def_col = 'name';
			$def_a_name = '/lessons?sort_name=1';
			$arrow_name = '&#9650;';
		}
	}
}

// Таблица групп
$all_lessons = R::findAll('lessons', 'institution_id = ? ORDER BY `'.$def_col.'` '.$def_sort, array(Account::$INSTITUTION_ID));

?>