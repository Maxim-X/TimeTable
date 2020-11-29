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

		echo $url_now."<br>";
		echo $url."<br>";
		echo "<br>";
		echo preg_match("/^login\/${id}/", $url);

		if ($url == $url_now) {
			$func();
		}
		
	}

}