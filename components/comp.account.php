<?PHP 

if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /login');
	exit;
}

Route::$TITLE = "Панель диспетчера";
Route::$DESCRIPTION = "Панель диспетчера";



if (isset($_POST['but_code_invite'])) {
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < 6; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

	$team_invites = R::xdispense('team_invites');
	$team_invites->key_invite = $random_string;
	$team_invites->institution_id = Account::$INSTITUTION_ID;
	$team_invites->status = 0;
	R::store($team_invites);
	}

$count_students = R::count("accounts_generated", "account_type = ? AND group_id IN (SELECT id FROM groups_students WHERE id_institution = ?)", array("1", Account::$INSTITUTION_ID));
$count_groups = R::count("groups_students", "id_institution = ?", array(Account::$INSTITUTION_ID));
$all_group = R::find('groups_students', 'id_institution = ?', array(Account::$INSTITUTION_ID));

$last_code = R::findOne('team_invites', 'institution_id = ? AND status = ? ORDER BY id DESC ', array(Account::$INSTITUTION_ID, 0));
class Calendar 
{
	/**
	 * Вывод календаря на один месяц.
	 */
	public static function  getMonth($month, $year, $events = array())
	{
		$months = array(
			1  => 'Январь',
			2  => 'Февраль',
			3  => 'Март',
			4  => 'Апрель',
			5  => 'Май',
			6  => 'Июнь',
			7  => 'Июль',
			8  => 'Август',
			9  => 'Сентябрь',
			10 => 'Октябрь',
			11 => 'Ноябрь',
			12 => 'Декабрь'
		);
 
		$month = intval($month);
		$out = '
		<div class="calendar-item">
			<table>
				<tr>
					<th>Пн</th>
					<th>Вт</th>
					<th>Ср</th>
					<th>Чт</th>
					<th>Пт</th>
					<th>Сб</th>
					<th>Вс</th>
				</tr>';
 
		$day_week = date('N', mktime(0, 0, 0, $month, 1, $year));
		$day_week--;
 
		$out.= '<tr>';
 
		for ($x = 0; $x < $day_week; $x++) {
			$out.= '<td></td>';
		}
 
		$days_counter = 0;		
		$days_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	
		for ($day = 1; $day <= $days_month; $day++) {
			if (date('j.n.Y') == $day . '.' . $month . '.' . $year) {
				$class = 'today';
			} elseif (time() > strtotime($day . '.' . $month . '.' . $year)) {
				$class = 'last';
			} else {
				$class = '';
			}
			
			$event_show = false;
			$event_text = array();
			if (!empty($events)) {
				foreach ($events as $date => $text) {
					$date = explode('.', $date);
					if (count($date) == 3) {
						$y = explode(' ', $date[2]);
						if (count($y) == 2) {
							$date[2] = $y[0];
						}
 
						if ($day == intval($date[0]) && $month == intval($date[1]) && $year == $date[2]) {
							$event_show = true;
							$event_text[] = $text;
						}
					} elseif (count($date) == 2) {
						if ($day == intval($date[0]) && $month == intval($date[1])) {
							$event_show = true;
							$event_text[] = $text;
						}
					} elseif ($day == intval($date[0])) {
						$event_show = true;
						$event_text[] = $text;
					}				
				}
			}

			$count_replacing = R::count('replacing', 'date = ? AND id_schedule IN (SELECT id FROM schedules WHERE schedules.id_group IN (SELECT id FROM groups_students WHERE groups_students.id_institution = ?))', array($year.'-'.$month.'-'.$day, Account::$INSTITUTION_ID));
			if ($count_replacing != 0) {
				$out.= '<td data-href="/replacing/edit/'.$year.'-'.$month.'-'.$day.'?" class="calendar-day ' . $class . ' event"><div class="num-day">' . $day . '</div>';
				$out.= '<div class="calendar-popup">' . $count_replacing . ' Замен занятий</div>';
				$out.= '</td>';
			} else {
				$out.= '<td data-href="/replacing/edit/'.$year.'-'.$month.'-'.$day.'?" class="calendar-day ' . $class . '"><div class="num-day">' . $day . '</div></td>';
			}
 			// $out.= '</a><div>';
			if ($day_week == 6) {
				$out.= '</tr>';
				if (($days_counter + 1) != $days_month) {
					$out.= '<tr>';
				}
				$day_week = -1;
			}
 
			$day_week++; 
			$days_counter++;
		}
 
		$out .= '</tr></table></div>';
		return array('calendar' => $out, 'month' => $months[$month], 'year' => $year) ;
	}
}



$m_calendar_use = date("m");
$y_calendar_use = date("Y");
$full_calendar_use = date("Y-m");


$Calendar = new Calendar;
$Calendar_use = $Calendar->getMonth($m_calendar_use, $y_calendar_use);

?>

<script>
$(document).ready(function() {
	$('td.calendar-day').on('click', '', function(e){
    e.prevenDefault;
    document.location.href = $(this).data('href');
})
});

function CopyToClipboard(containerid) {
if (document.selection) { 
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("Copy"); 

} else if (window.getSelection) {
    var range = document.createRange();
     range.selectNode(document.getElementById(containerid));
     window.getSelection().addRange(range);
     document.execCommand("Copy");
}}
</script>