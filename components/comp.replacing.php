<?php 
// Проверка на авторизацию
if (!Account::$AUTH || Account::$ACCOUNT_TYPE != 3) {
	header('Location: /');
	die();
}

Route::$TITLE = "Календарь замен занятий";
Route::$DESCRIPTION = "Календарь замен занятий";

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

			$count_replacing = R::count('replacing', 'date = ?', array($year.'-'.$month.'-'.$day));
			
			if ($count_replacing != 0) {
				$out.= '<td class="calendar-day ' . $class . ' event"><div class="num-day">' . $day . '</div>';
				$out.= '<div class="calendar-popup">' . $count_replacing . ' Замен занятий</div>';
				$out.= '</td>';
			} else {
				$out.= '<td class="calendar-day ' . $class . '"><div class="num-day">' . $day . '</div></td>';
			}
 
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



$m_calendar_use = date("m", strtotime($_GET['date']));
$y_calendar_use = date("Y", strtotime($_GET['date']));
$full_calendar_use = date("Y-m", strtotime($_GET['date']));


$Calendar = new Calendar;
$Calendar_use = $Calendar->getMonth($m_calendar_use, $y_calendar_use);