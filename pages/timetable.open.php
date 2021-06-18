
<?php 
if (isset($group_id) && !empty($group_id)):
	function cmp_function($a, $b){
		return ($a['time_start'] > $b['time_start']);
	}
?>
<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-10 col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xxl-1 offset-xl-1">
			<section id="content">
				<div class="main_content">
					<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12 mx-auto">
						<div class="back_url"><a href="/timetable-open?institution_id=<?=$institution->id;?>"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
						<g xmlns="http://www.w3.org/2000/svg"><g><path d="M420.361,192.229c-1.83-0.297-3.682-0.434-5.535-0.41H99.305l6.88-3.2c6.725-3.183,12.843-7.515,18.08-12.8l88.48-88.48    c11.653-11.124,13.611-29.019,4.64-42.4c-10.441-14.259-30.464-17.355-44.724-6.914c-1.152,0.844-2.247,1.764-3.276,2.754    l-160,160C-3.119,213.269-3.13,233.53,9.36,246.034c0.008,0.008,0.017,0.017,0.025,0.025l160,160    c12.514,12.479,32.775,12.451,45.255-0.063c0.982-0.985,1.899-2.033,2.745-3.137c8.971-13.381,7.013-31.276-4.64-42.4    l-88.32-88.64c-4.695-4.7-10.093-8.641-16-11.68l-9.6-4.32h314.24c16.347,0.607,30.689-10.812,33.76-26.88    C449.654,211.494,437.806,195.059,420.361,192.229z" fill="#000000" data-original="#000000" style="" class=""></path></g></g><g xmlns="http://www.w3.org/2000/svg"></g>
						</g></svg> ВЫБОР ГРУППЫ</a></div>
						<h1 class="main_header">Расписание группы <span class="highlight"><?=$group->name;?></span> <?php if(isset($name_week)){echo '<span class="name_week">'.$name_week.'</span>';};?></h1>
					</div>
					<div class="section_all_func">
						<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12 mx-auto">
							<div class="bar_table">
								<form method="POST">
									<div class="reating-arkows zatujgdsanuk">
										<input id="edit_sunday" name="edit_sunday" onchange="location.href='<?=$alt_url;?>'" type="checkbox" <?php if($alt) echo "checked=''"; ?>>
										<label for="edit_sunday">
										<div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
										<div class="title_but">Основное расписание</div>
										</label>
										<input type="submit" style="display: none" name="save_edit_sunday" id="save_edit_sunday">
									</div>
								</form>
								<!-- <div class="button_table_func button_table_func_opacity" onclick="exp_pdf()"><img src="/resources/images/icon/document.svg" alt="document"><span>Скачать основное расписание</span></div> -->
								<div class="button_table_func button_table_func_opacity" onclick="exp_pdf()"><img src="/resources/images/icon/document.svg" alt="document"><span>Скачать расписание</span></div>
							</div>
							<div class="schedule_table">
								<?php 
								// Определяем четность недели (0 - нечетная, 1 - четная)
								$even_numbered = $week % 2 == 0 && $group->use_even == 1 ? 1:0;

								// Определяем даты нынешней недели
								if ((date('w') == 7) || (date('w') == 6 && $group->use_sunday == 0)) {
									$date = strtotime('monday next week');
								}else{
									$date = strtotime('monday this week');
								}
								


							    $dates=[];
							    for($i = 0;$i < 7;$i++) {
							        $dates[] =  date("Y-m-d", strtotime('+'.$i.' day', $date));
							    }
							  
									?>
								<div class="row">
									<?php foreach ($day_of_the_week as $index => $day):
										$date_now = $dates[--$index];
										$none_sunday = $index == 5 && $group->use_sunday == 0 ? true : false;
										$all_schedules = R::getAll('SELECT schedules.*, timeline.time_start FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($group->id, $day->id, $even_numbered));
										
										$all_schedules_new_repl = R::getAll('SELECT replacing.*, timeline.time_start FROM `replacing`, `timeline` WHERE replacing.add_new = 1 AND replacing.timeline = timeline.id AND replacing.id_group = ? AND replacing.date = ? ORDER BY timeline.time_start', array($group->id, $date_now));

										if ($all_schedules_new_repl && !$alt) {
											foreach ($all_schedules_new_repl as &$value) {
												array_push($all_schedules, $value);
											}
											
											uasort($all_schedules, 'cmp_function');
										}

										$all_schedules = R::convertToBeans('schedules', $all_schedules);
										
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
											<div class="schedule_day <?php if($none_sunday){echo "schedule_none";}?>"  >
												<div class="schedule_day_head">
													<div class="name_day"><?=$day->name;?></div>
													<div class="date_day"><?=strftime("%d.%m",strtotime($date_now));?></div>
												</div>
												<div class="schedule_day_full">
													<?php if (count($all_schedules) == 0): ?>
														<div class="none_schedule">
															<img src="/resources/images/icon/speech-bubble.svg" alt="none schedule">
															<p>Расписание отсутствует</p>
														</div>
													<?php endif ?>
													<?php foreach ($all_schedules as $schedule): 
														if ($none_sunday) {
															continue;
														}
														$id_schedule = $schedule->id;
														if (!$alt) {
														if ($schedule->add_new != 1) {
															$replace = R::findOne('replacing', 'id_schedule = ? AND date = ?', array($schedule->id, $date_now));
															if ($replace) {
																if ($replace->cancel == 1) {
																	continue;
																}
																$schedule = $replace;
															}
														}else{
															$replace = true;
														}
													}

														$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
														$time_lesson = R::findOne('timeline', 'id = ?', array($schedule->timeline));
														$teacher = R::findOne('accounts_generated', 'id = ?', array($schedule->id_teacher));

														?>
														<div class="one_lesson" id="one_lesson" <?php if ($schedule->add_new != 1): ?> id_schedule="<?=$id_schedule;?>" <?php else: ?> id_replace="<?=$id_schedule;?>" <?php endif ?> date="<?=strftime("%Y-%m-%d",strtotime($date_now));?>">
															<div class="time">
																<div class="time_start"><?=date("H:i", strtotime($time_lesson->time_start));?></div>
																<div class="time_end"><?=date("H:i", strtotime($time_lesson->time_end));?></div>
															</div>
															<div class="line_day_interf"></div>
															<div class="short_info">
																<div class="name_lesson"><?php if($replace):?><span class="replace"></span><?php endif; ?><?=$lesson->name;?></div>
																<div class="footer-lesson">
																	<div class="cabinet_lesson">
																		<?php if (!empty($schedule->office)) {echo $schedule->office." каб. ";} ?>
																		<?php if (!empty($schedule->floor)) {echo $schedule->floor." этаж ";} ?>
																		<?php if (!empty($schedule->building)) {echo $schedule->building." корпус";} ?>
																	</div>
																	<div class="teacher_lesson"><?=$teacher->surname;?> <?=mb_substr($teacher->name,0,1);?>. <?=mb_substr($teacher->middle_name,0,1);?>.</div>
																</div>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php // endfor ;?>
							</div>
						</div>
					</div>
				</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<div class="dark-back" id="modal-full-info-back"></div>
<div class="modal-full-info" id="modal-full-info-lesson">
	<div class="head-full-info">
		<div class="close" id="close-modal-full-info"><img src="/resources/images/icon/close-white.svg" alt="close"></div>
		<div class="user_name">
	        
      	</div>
	</div>
	<div class="full-info">
		<div class="lesson-time">10:35 - 12:05</div>
		<div class="lesson-name">Программирование в компьютерных системах.</div>
		<hr>
		<!-- <div class="lesson-timeline-text">До конца: <span class="highlight">01:17</span></div>
		<div class="lesson-timeline"><div class="line"></div></div> -->
		<div class="lesson-info-item">
			<div class="lesson-info-item_name">Преподаватель:</div>
			<div class="lesson-info-item_text" id="name_teacher">Смирнова Милана Дмитриевна</div>
		</div>
		<div class="lesson-info-item">
			<div class="lesson-info-item_name">Кабинет:</div>
			<div class="lesson-info-item_text" id="num_office">302 кабинет, 3 этаж, 1 корпус</div>
		</div>
	</div>

	<div class="replace-info">
		<div class="header-replace-info">Заменяемый предмет:</div>
		<div class="block-replace-info">
			<div class="lesson-info-item">
				<div class="lesson-info-item_name">Занятие:</div>
				<div class="lesson-info-item_text" id="name_lesson_replace">WEB-программирование</div>
			</div>
			<div class="lesson-info-item">
				<div class="lesson-info-item_name">Преподаватель:</div>
				<div class="lesson-info-item_text" id="name_teacher_replace">Смирнова Милана Дмитриевна</div>
			</div>
			<div class="lesson-info-item">
				<div class="lesson-info-item_name">Кабинет:</div>
				<div class="lesson-info-item_text" id="num_office_replace">302 кабинет, 3 этаж, 1 корпус</div>
			</div>
		</div>
	</div>
</div>
<?php 
elseif(isset($institution_id) && !empty($institution_id)):
?>
 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-10 col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 offset-xxl-1 offset-xl-1">
			<section id="content">
				<div class="main_content">
					<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12 mx-auto">
						<h1 class="main_header">Выберите группу <span class="highlight">(<?=$institution->short_name;?>)</span></h1>
					</div>
					<div class="row all_content_mg">
					<div class="all_groups">
						<div class="row">
							<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12 mx-auto" >
								<div class="row" style="margin: 0px">
									<?php 
									foreach ($all_groups as $group):
										$count_students = R::count("accounts_generated", "group_id = ? AND account_type = ?", array($group->id, 1));
									?>
									<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 group_back">
										<a href="http://cw46249.tmweb.ru/timetable-open?group_id=<?=$group->id;?>">
											<div class="group_info">
												<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
												<div class="title"><div class="name">Группа <?=$group->name;?></div><div class="option">Обучающихся: <?=$count_students;?></div></div>
												<div class="opt"><div class="on"></div></div>
											</div>
										</a>
									</div>
									<?php 
									endforeach;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<?php 
endif;
?>

