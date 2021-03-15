
// Класс для редактирования DOM сайта

class EDIT_DOM {

	static reload_all_files(){
		
		$.ajax({
			url: '/assets/ajax/ajax.space-info.php',
			type: 'POST',
			dataType: 'json',
			data: {},
		})
		.done(function(data) {
			console.log("success");
			document.querySelector('#use_space_mb').textContent = data.use_space_mb;
			document.querySelector('#disk_space_mb').textContent = data.disk_space_mb;
			document.querySelector('#pr_use_space').style.width = data.pr_use_space+"%";

			data.user_files =  Object.values(data.user_files).map(v => Object.values(v));
			// let template = '<div class="file"><div class="file_info"><div class="image"><img src="/resources/images/icon/excel.svg" alt="excel"></div><div class="name_file"><p>Студенты 2021г.xls</p></div><div class="size_file"><p>4.1М</p></div><div class="button_add"><div class="button_add_f"><img src="/resources/images/icon/add_mini.svg" alt="add"><p>Добавить студентов из этого файла</p></div></div></div></div>';
			// <div class="file">
			// 	<div class="file_info">
			// 		<div class="image"><img src="/resources/images/icon/excel.svg" alt="excel"></div>
			// 		<div class="name_file"><p>Студенты 2021г.xls</p></div>
			// 		<div class="size_file"><p>4.1М</p></div>
			// 		<div class="button_add"><div class="button_add_f"><img src="/resources/images/icon/add_mini.svg" alt="add"><p>Добавить студентов из этого файла</p></div></div>
			// 	</div>
			// </div>
;
			


			data.user_files.forEach(function(item, i) {
				let file = document.createElement('div');
				file.className = 'file';

				let file_info = document.createElement('div');
				file_info.className = 'file_info';

				let image = document.createElement('div');
				image.className = 'image';

				let img = document.createElement('img');
				img.src = '/resources/images/icon/excel.svg';
				img.alt = 'excel';

				let name_file = document.createElement('div');
				name_file.className = 'name_file';

				let name_file_p = document.createElement('p');
				name_file_p.innerHTML = item[1];

				let size_file = document.createElement('div');
				size_file.className = 'size_file';

				let size_file_p = document.createElement('p');
				size_file_p.innerHTML = item[2]+"М";

				let button_add = document.createElement('div');
				button_add.className = 'button_add';
				
				let button_add_f = document.createElement('div');
				button_add_f.className = 'button_add_f';
				

				let button_add_f_img = document.createElement('img');
				button_add_f_img.src = '/resources/images/icon/add_mini.svg';
				button_add_f_img.alt = 'add';

				let button_add_f_p = document.createElement('p');
				button_add_f_p.innerHTML = "Добавить студентов из этого файла";

				button_add_f.append(button_add_f_img);
				button_add_f.append(button_add_f_p);
				button_add.append(button_add_f);
				image.append(img);
				file_info.append(image);
				name_file.append(name_file_p);
				file_info.append(name_file);
				size_file.append(size_file_p);
				file_info.append(size_file);
				file_info.append(button_add);
				file.append(file_info);
			  	document.querySelector('#all_user_files').append(file);
			});
		})
		.fail(function(request, status, error) {
			console.log("error");
			alert(request.responseText);
			alert(status);
			alert(error);
		})
		.always(function(data) {
			console.log("complete");
			console.log(data);
		});
		
	}

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