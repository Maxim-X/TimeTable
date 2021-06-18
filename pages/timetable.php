<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<?php if (Account::$ACCOUNT_TYPE == 2): ?>
						<h1 class="main_header">Ваше расписание <?php if(isset($name_week)){echo '<span class="name_week">'.$name_week.'</span>';};?></h1>
					<?php endif; ?>
					<div class="section_all_func">
						<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="schedule_table">
								<?php 
								function cmp_function($a, $b){
									return ($a['time_start'] > $b['time_start']);
								}
								// Определяем четность недели (0 - нечетная, 1 - четная)
								// Определяем даты нынешней недели
								$date = strtotime('monday this week');
							    $dates=[];
							    for($i = 0;$i < 7;$i++) {
							        $dates[] =  date("Y-m-d", strtotime('+'.$i.' day', $date));
							    }
									?>
								<div class="row">
									<?php foreach ($day_of_the_week as $index => $day):
										
										if ($even_numbered == 0) {
											$all_schedules = R::getAll('SELECT schedules.*, timeline.time_start FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_teacher = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array(Account::$ID, $day->id, $even_numbered));
										}else{
											$all_schedules = R::getAll('SELECT schedules.*, timeline.time_start FROM `schedules`, `timeline`, `groups_students` WHERE schedules.timeline = timeline.id AND schedules.id_teacher = ? AND schedules.id_day = ? AND ((schedules.even_numbered = ? AND (groups_students.id = schedules.id_group AND groups_students.use_even = 1))  OR (schedules.even_numbered = 0 AND (groups_students.id = schedules.id_group AND groups_students.use_even = 0)))  ORDER BY timeline.time_start', array(Account::$ID, $day->id, $even_numbered));
										}
										


										
										$date_now = $dates[--$index];

										$repl = R::getAll('SELECT replacing.*, timeline.time_start FROM replacing, timeline WHERE replacing.date = ? AND replacing.id_teacher = ?', array($date_now, Account::$ID));
										

										if ($repl) {
											$all_schedules = array_merge($all_schedules, $repl);
											uasort($all_schedules, 'cmp_function');
										}
										if ($all_schedules) {
											$all_schedules = R::convertToBeans('schedules', $all_schedules);
										}
										
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="schedule_day"  >
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
														if (isset($schedule->id_schedule)) {
															$id_schedule = $schedule->id_schedule;
														}else{
															$id_schedule = $schedule->id;
														}

														$replace_another_teacher = R::findOne('replacing', 'id_schedule = ? AND date = ? AND id_teacher != ?', array($schedule->id, $date_now, Account::$ID));
														if ($replace_another_teacher) {
															$replace_another_teacher_back = "style=\"opacity: 0.1\"";
														}else{
															$replace_another_teacher_back = "";
														}
														$id_schedule = $schedule->id;
														if ($schedule->add_new != 1) {
														$replace = R::findOne('replacing', 'id_schedule = ? AND date = ? AND id_teacher = ?', array($schedule->id, $date_now, Account::$ID));
														if ($replace) {
															if ($replace->cancel == 1) {
																continue;
															}
															$schedule = $replace;
														}
														}else{
															$replace = true;
														}

														$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
														$time_lesson = R::findOne('timeline', 'id = ?', array($schedule->timeline));
														$group = R::findOne('groups_students', 'id = ?', array($schedule->id_group));

														?>
														<div class="one_lesson" id="one_lesson" <?=$replace_another_teacher_back;?> <?php if ($schedule->add_new != 1): ?> id_schedule="<?=$id_schedule;?>" <?php else: ?> id_replace="<?=$id_schedule;?>" <?php endif ?> date="<?=strftime("%Y-%m-%d",strtotime($date_now));?>">
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
																	<div class="teacher_lesson"><?=$group->name;?></div>
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
	        <div class="user">
	        	<div class="name"><?=Account::$SURNAME;?> <?=Account::$NAME;?> <?=Account::$MIDDLENAME;?></div>
	        	<div class="role"><?=Account::$AFFILIATION;?></div>
	        </div>
	        <div class="avatar">
	        	<div class="letter"><?=mb_substr(Account::$NAME, 0, 1);?></div>
	        </div>
      	</div>
	</div>
	<div class="full-info">
		<div class="lesson-time">10:35 - 12:05</div>
		<div class="lesson-name">Программирование в компьютерных системах.</div>
		<!-- <div class="lesson-timeline-text">До конца: <span class="highlight">01:17</span></div>
		<div class="lesson-timeline"><div class="line"></div></div> -->
		<hr>
		<div class="lesson-info-item">
			<div class="lesson-info-item_name">Группа:</div>
			<div class="lesson-info-item_text" id="name_group"></div>
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
				<div class="lesson-info-item_name">Кабинет:</div>
				<div class="lesson-info-item_text" id="num_office_replace">302 кабинет, 3 этаж, 1 корпус</div>
			</div>
		</div>
	</div>
</div>
