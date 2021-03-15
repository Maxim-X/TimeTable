<?php

// Таблица групп
$all_groups = R::findAll('groups_students', 'id_institution = ? ORDER BY `id` DESC', array(Account::$INSTITUTION_ID));


if (isset($_POST['add_group'])) {
	$name_group = $_POST['name_group'];

	$error = array();

	if (empty($name_group) || !isset($name_group)) {
		array_push($error, "Название группы введено неверно!");
	}

	$group_name_find = R::findOne('groups_students', 'name = ? AND id_institution = ?', array($name_group, Account::$INSTITUTION_ID));
	if ($group_name_find) {
		array_push($error, "Группа с таким название уже созданна!");
	}

	if (count($error) == 0) {
		$add_group = R::xdispense('groups_students');
		$add_group->name 	= $name_group;
		$add_group->id_institution 	= Account::$INSTITUTION_ID;
		R::store($add_group);

		header("Refresh: 0");
	}
}

?>