<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<?php if (Account::$ACCOUNT_TYPE == 1): ?>
						<h1 class="main_header">Расписание группы <span class="highlight"><?=Account::$GROUP_NAME;?></span> <?php if(isset($name_week)){echo '<span class="name_week">'.$name_week.'</span>';};?></h1>
					<?php endif; ?>
					<div class="section_all_func">
						<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="schedule_table">
								<?php 
								// Определяем четность недели (0 - нечетная, 1 - четная)
								$even_numbered = $week % 2 == 0 && $group->use_even == 1 ? 1:0;
								// Определяем даты нынешней недели
								$date = strtotime('monday this week');
							    $dates=[];
							    for($i = 0;$i < 7;$i++) {
							        $dates[] =  date("Y-m-d", strtotime('+'.$i.' day', $date));
							    }
									?>
								<div class="row">
									<?php foreach ($day_of_the_week as $index => $day):
										$none_sunday = $index == 6 && $group->use_sunday == 0 ? true : false;
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($group->id, $day->id, $even_numbered));
										$all_schedules = R::convertToBeans('schedules', $all_schedules);
										$date_now = $dates[--$index];
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
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

														$replace = R::findOne('replacing', 'id_schedule = ? AND date = ?', array($schedule->id, $date_now));
														if ($replace) {
															$schedule = $replace;
														}

														$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
														$time_lesson = R::findOne('timeline', 'id = ?', array($schedule->timeline));

														?>
														<div class="one_lesson" id="one_lesson">
															<div class="time">
																<div class="time_start"><?=date("H:i", strtotime($time_lesson->time_start));?></div>
																<div class="time_end"><?=date("H:i", strtotime($time_lesson->time_end));?></div>
															</div>
															<div class="line_day_interf"></div>
															<div class="short_info">
																<div class="name_lesson"><?php if($replace):?><span class="replace"></span><?php endif; ?><?=$lesson->name;?></div>
																<div class="cabinet_lesson">
																	<?php if (!empty($schedule->office)) {echo $schedule->office." каб. ";} ?>
																	<?php if (!empty($schedule->floor)) {echo $schedule->floor." этаж ";} ?>
																	<?php if (!empty($schedule->building)) {echo $schedule->building." корпус";} ?></div>
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
		<div class="lesson-timeline-text">До конца: <span class="highlight">01:17</span></div>
		<div class="lesson-timeline"><div class="line"></div></div>
		<div class="lesson-info-item">
			<div class="lesson-info-item_name">Преподаватель:</div>
			<div class="lesson-info-item_text">Смирнова Милана Дмитриевна</div>
		</div>
		<div class="lesson-info-item">
			<div class="lesson-info-item_name">Кабинет:</div>
			<div class="lesson-info-item_text">302 кабинет, 3 этаж, 1 корпус</div>
		</div>
	</div>
</div>
