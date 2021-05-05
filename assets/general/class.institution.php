<?PHP

// require_once("assets/general/class.account.php");

/**
 * 
 */
class Institution
{
	public static $EXISTS = false;
	public static $ID;
	public static $SHORT_NAME;
	public static $FULL_NAME;
	public static $ID_TIMEZONE;
	public static $ID_TYPE;

	
	public static function init(){
		if (Account::auth_check()) {
			if ((Account::$INSTITUTION_ID != 0 && (Account::$ACCOUNT_TYPE == 3 || Account::$ACCOUNT_TYPE == 2)) || (Account::$GROUP_ID != 0 && Account::$ACCOUNT_TYPE == 1)) {	
				if(Account::$ACCOUNT_TYPE == 1){
					$group_data_db = R::findOne('groups_students', 'id = ?', array(Account::$GROUP_ID));
					$inst_data_db = R::findOne('institutions', 'id = ?', array($group_data_db->id_institution));
				}else{
					$inst_data_db = R::findOne('institutions', 'id = ?', array(Account::$INSTITUTION_ID));
				}

				self::$EXISTS 		= true;
				self::$ID 	= $inst_data_db->id;
				self::$SHORT_NAME 	= $inst_data_db->short_name;
				self::$FULL_NAME 	= $inst_data_db->full_name;
				self::$ID_TIMEZONE 	= $inst_data_db->timezone;
				self::$ID_TYPE 		= $inst_data_db->type_institutions;
			}else{
				$url = $_SERVER['REQUEST_URI'];
				$url = explode('?', $url);
				$url = $url[0];
				$re = '/\/(reg)\/\d/m';
				if (!preg_match($re, $url)) {
					header('Location: /reg/1');
				}
			}
		}
	}

	// Добавление учебного заведения
	public static function add_institution($inst_data){
		if (!isset($inst_data['type_inst']) &&
			!isset($inst_data['fullNameInst']) &&
			!isset($inst_data['shortNameInst']) &&
			!isset($inst_data['timeZoneInst']) &&
			!isset($inst_data['offRepresentative']) ) {
			return array("status" => false, "message" => "Не все данные были переданы");
		}

		$type_inst 			= trim($inst_data['type_inst']);
		$fullNameInst 		= trim($inst_data['fullNameInst']);
		$shortNameInst 		= trim($inst_data['shortNameInst']);
		$timeZoneInst 		= trim($inst_data['timeZoneInst']);
		$offRepresentative 	= trim($inst_data['offRepresentative']);

		// Проверка типа учреждения
		if (empty($type_inst)) {
			return array("status" => false, "message" => "Тип учреждения введен неверно!");
		}
		$find_type_inst = R::findOne('types_institutions', 'id = ?', array($type_inst));
		if (!$find_type_inst) {
			return array("status" => false, "message" => "Данный тип учреждения не обнаружен!");
		}

		// Проверка полного названия учреждения
		if (empty($fullNameInst)) {
			return array("status" => false, "message" => "Название учреждения введено неверно!");
		}
		$find_full_name_inst = R::findOne('institutions', 'full_name = ?', array($fullNameInst));
		if ($find_full_name_inst) {
			return array("status" => false, "message" => "Учереждение с данным названием уже добавленно!");
		}

		// Проверка краткого названия учреждения
		if (empty($shortNameInst)) {
			return array("status" => false, "message" => "Краткое название учреждения введено неверно!");
		}
		$find_short_name_inst = R::findOne('institutions', 'short_name = ?', array($shortNameInst));
		if ($find_short_name_inst) {
			return array("status" => false, "message" => "Учереждение с данной аббревиатурой уже добавленно!");
		}

		// Проверка часового пояса учреждения
		if (empty($timeZoneInst)) {
			return array("status" => false, "message" => "Часовой пояс введен неверно!");
		}
		$find_timezone_name_inst = R::findOne('time_zones', 'id = ?', array($timeZoneInst));
		if (!$find_timezone_name_inst) {
			return array("status" => false, "message" => "Часовой пояс не найден!");
		}

		// Проверка подтвержения официального представителя
		if (!$offRepresentative) {
			return array("status" => false, "message" => "Вы не подтвердили, что являетесь официальным представителем учебного заведения!");
		}

		// Добавляем учебное учереждение

		$institution = R::xdispense('institutions');
		$institution->short_name 	= $shortNameInst;
		$institution->full_name 	= $fullNameInst;
		$institution->timezone 		= $timeZoneInst;
		$institution->type_institutions = $type_inst;
		
		$institution_add = R::store($institution);

		if (!$institution_add) {
			return array("status" => false, "message" => "Ошибка записи в базу данных!");
		}

		// Назвначаем пользователя сотрудником учебного заведения

		$user = R::load('accounts', Account::$ID);
		$user->institution_id = $institution_add;
		$user = R::store($user);

		return array("status" => true, "message" => "Учебное учереждение добавленно!");


	}
}