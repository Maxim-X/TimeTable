<?PHP 
/**
 * Определение маршрута
 */
class Route
{
	
	public static function path($url, $func, $where = array()){
		$url_now = $_SERVER['REQUEST_URI'];
		$url_now = explode('?', $url_now);
		$url_now = $url_now[0];
		$url_now = trim($url_now, '/');
		$url = trim($url, '/');

		//
		// Поиск элементов для замены
		//
		preg_match_all('/{[a-zA-Z0-9]+}/m', $url, $all_mask, PREG_SET_ORDER, 0);
		$all_mask = $all_mask[0];
		$url = str_replace("/","\/", $url);
		if ($all_mask != NULL) {
			foreach ($all_mask as $mask) {
				// str_replace(["{","}"], "", $mask);
				$mask = substr($mask, 1, -1);
				if (isset($where["$mask"])) {
					$url = str_replace("{".$mask."}", $where["$mask"], $url);
				}else{
					$url = str_replace("{".$mask."}", "[a-zA-Z]+", $url);
				}
			}
		}
		//
		// Поиск элементов для замены
		//
		$re = "/^{$url}$/m";

		preg_match_all($re, $url_now, $matches, PREG_SET_ORDER, 0);

		if (count($matches) != 0) {
			$func();
		}
	}
}