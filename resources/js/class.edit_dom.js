
// Класс для редактирования DOM сайта

class EDIT_DOM {

	// -> 	info []
	//			students [] Массив найденных студентов
	//				id 		id студента
	//				fio 	ФИО студента
	//				group	Группа студента
	//			groups   []	Массив найденных групп
	//				id 		id группы
	//				name 	Название группы
	//				count_stusents 	Количество студентов

	static student_search(info, id_elem_edit){
		let edit_elem = document.getElementById(id_elem_edit);
		edit_elem.innerHTML = '';

		console.log(info);
		if (info != undefined) {
			info = info.search_info;
			if (info.students != null && Object.keys(info.students).length > 0) {
				let div_name_group_search = document.createElement('div');
				div_name_group_search.className = 'name_group_search';
				div_name_group_search.innerHTML = 'Обучающиеся';
				edit_elem.append(div_name_group_search);

				info.students.forEach(function(item, i) {
					let div_line_cont_search = document.createElement('div');
					div_line_cont_search.className = 'line_cont_search';

					let a_line_cont_search = document.createElement('a');
					a_line_cont_search.href = "#";

					let div_main_name = document.createElement('div');
					div_main_name.className = 'main_name';
					div_main_name.innerHTML = item.fio;
					a_line_cont_search.append(div_main_name);

					let div_optionally = document.createElement('div');
					div_optionally.className = 'optionally';
					div_optionally.innerHTML = item.group;
					a_line_cont_search.append(div_optionally);

					div_line_cont_search.append(a_line_cont_search);

					edit_elem.append(div_line_cont_search);
				});
			}

			if (info.groups != null && Object.keys(info.groups).length > 0) {
				let div_name_group_search = document.createElement('div');
				div_name_group_search.className = 'name_group_search';
				div_name_group_search.innerHTML = 'Группы';
				edit_elem.append(div_name_group_search);

				info.groups.forEach(function(item, i) {
					let div_line_cont_search = document.createElement('div');
					div_line_cont_search.className = 'line_cont_search';

					let a_line_cont_search = document.createElement('a');
					a_line_cont_search.href = "#";

					let div_main_name = document.createElement('div');
					div_main_name.className = 'main_name';
					div_main_name.innerHTML = item.name;
					a_line_cont_search.append(div_main_name);

					let div_optionally = document.createElement('div');
					div_optionally.className = 'optionally';
					div_optionally.innerHTML = item.count_students;
					a_line_cont_search.append(div_optionally);

					div_line_cont_search.append(a_line_cont_search);

					edit_elem.append(div_line_cont_search);
				});
			}
		}
	} 
}