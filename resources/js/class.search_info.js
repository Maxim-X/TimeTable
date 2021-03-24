//
//Класс для поиска информации о студентах, группа, уч. заведениях и т.д.
//
class Search_info{

	static success_ajax = false;


	static search_students(find_str){
		if (!find_str || find_str.length === 0) {
			return {"status": false, "message": "Нет информации для поиска!"};
		}
		let search_students = search_students_dop(find_str);
		search_students = Object.values(search_students);
		let search_groups = search_groups_dop(find_str);
		search_groups = Object.values(search_groups);

		return {
				status: true, 
				search_info: {
					students: search_students,
					groups: search_groups,
				}
			};
	}
}

function search_students_dop(find_str){
	var ret = "";
	$.ajax({
		url: '/assets/ajax/ajax.search-students-info.php',
		type: 'POST',
		dataType: 'json',
		data: {find_str: find_str},
    	async:false
	})
	.done(function(data) {
		console.log(data);
		ret = data.search_students;
	})
	.fail( function() {
		//
	});
	return ret;
}

function search_groups_dop(find_str){
	var ret = "";
	$.ajax({
		url: '/assets/ajax/ajax.search-students-info.php',
		type: 'POST',
		dataType: 'json',
		data: {find_str: find_str},
    	async:false
	})
	.done(function(data) {
		console.log(data);
		ret = data.search_groups;
	})
	.fail( function() {
		//
	});
	return ret;
}
