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

		return {
				status: true, 
				search_info: {
					students: [{
						id: '1',
						fio: 'Иванов Иван Иванович',
						group: '16П-1',
					}, 
					{
						id: '2',
						fio: 'Иванов Иван Иванович',
						group: '16П-1',
					}],
					groups: search_students,
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
		ret = data.search_groups;
	})
	.fail( function() {
		//
	});
	return ret;
}
