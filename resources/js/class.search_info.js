//
//Класс для поиска информации о студентах, группа, уч. заведениях и т.д.
//
class Search_info{

	static search_students(find_str){
		if (!find_str || find_str.length === 0) {
			return {"status": false, "message": "Нет информации для поиска!"};
		}

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
				groups: [{
					id: '1',
					name: '18П-19',
					count_stusents: '21 Ученик',
				}, 
				{
					id: '2',
					name: '18П-20',
					count_stusents: '24 Ученика',
				}],
			}
		};

	}
}

let obj = {
	key1: {
		key1: 1,
		key2: 2,
		key3: 3,
	},
	key2: {
		key1: 4,
		key2: 5,
		key3: 6,
	},
	key3: {
		key1: 7,
		key2: 8,
		key3: 9,
	},
}