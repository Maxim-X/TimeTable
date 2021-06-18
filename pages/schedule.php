 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<div class="back_url"><a href="/schedule"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
<g xmlns="http://www.w3.org/2000/svg"><g><path d="M420.361,192.229c-1.83-0.297-3.682-0.434-5.535-0.41H99.305l6.88-3.2c6.725-3.183,12.843-7.515,18.08-12.8l88.48-88.48    c11.653-11.124,13.611-29.019,4.64-42.4c-10.441-14.259-30.464-17.355-44.724-6.914c-1.152,0.844-2.247,1.764-3.276,2.754    l-160,160C-3.119,213.269-3.13,233.53,9.36,246.034c0.008,0.008,0.017,0.017,0.025,0.025l160,160    c12.514,12.479,32.775,12.451,45.255-0.063c0.982-0.985,1.899-2.033,2.745-3.137c8.971-13.381,7.013-31.276-4.64-42.4    l-88.32-88.64c-4.695-4.7-10.093-8.641-16-11.68l-9.6-4.32h314.24c16.347,0.607,30.689-10.812,33.76-26.88    C449.654,211.494,437.806,195.059,420.361,192.229z" fill="#000000" data-original="#000000" style="" class=""></path></g></g><g xmlns="http://www.w3.org/2000/svg"></g>
</g></svg> ВЫБОР ГРУППЫ</a></div>
					<h1 class="main_header">Расписание для группы <span class="highlight"><?=$group->name;?></span></h1>
					<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table">
								<div class="stat_info_for_bar" <?php if($training_hours > $training_hours_def){echo "style='background:rgb(255 72 72 / 40%)'";} ?>>Учебные часы: <span><?=$training_hours;?> / <?=$training_hours_def;?></span></div>
								<?php if ($count_week == 1):?>
									<div class="stat_info_for_bar" <?php if($training_hours_even > $training_hours_def){echo "style='background:rgb(255 72 72 / 40%)'";} ?>>Учебные часы: <span><?=$training_hours_even;?> / <?=$training_hours_def;?> (Четная)</span></div>
								<?php endif; ?>

								<form method="POST">
									<div class="reating-arkows zatujgdsanuk">
										<input id="edit_sunday" name="edit_sunday" onchange="document.querySelector('input#save_edit_sunday').click();" type="checkbox" <?=$check_use_sunday;?>>
										<label for="edit_sunday">
										<div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
										<div class="title_but">Суббота</div>
										</label>
										<input type="submit" style="display: none" name="save_edit_sunday" id="save_edit_sunday">
									</div>
								</form>
								<form method="POST">
									<div class="reating-arkows zatujgdsanuk">
										<input id="edit_even" name="edit_even" onchange="document.querySelector('input#save_edit_even').click();" type="checkbox" <?=$check_use_even;?>>
										<label for="edit_even">
										<div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
										<div class="title_but">Четность недели</div>
										</label>
										<input type="submit" style="display: none" name="save_edit_even" id="save_edit_even">
									</div>
								</form>
							<!-- 	<div class="button_table_func button_table_func_opacity" onclick="generatingAuthInfo(<?=$info_group->id;?>)"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-teachers"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить</span></div> -->
							</div>
							<div class="schedule_table">
								<?php 
									
								if ($group->use_even != 0) {
									$count_week = 1;
									$name_week = array('Нечетная', 'Четная');
								}else{
									$count_week = 0;
								}
								for ($week_num = 0; $week_num <= $count_week; $week_num++):

									?>
								<div class="row">
									<?php if (isset($name_week)): ?>
									<div class="block_even_week"><h2 class="even_week"><?=$name_week[$week_num];?></h2></div>
									<?php endif; ?>
									<?php foreach ($day_of_the_week as $index => $day):
										$none_sunday = $index == 6 && $group->use_sunday == 0 ? true : false;
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($id_group, $day->id, $week_num));
										$all_schedules = R::convertToBeans( 'schedules', $all_schedules);
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="schedule_day <?php if($none_sunday){echo "schedule_none";}?>"  >
												<div class="schedule_day_head">
													<div class="name_day"><?=$day->name;?></div>
													<?php if(!$none_sunday): ?>
													<div class="button_anim_scale" onclick="show_form_add_schedule(this)" data-toggle="modal" id="button_open_add_schedule" day="<?=$day->id;?>" even_numbered="<?=$week_num;?>" data-target="#add-group"><img src="/resources/images/icon/plus-positive-add-mathematical-symbol.svg"></div>
												<?php endif; ?>
												</div>
												<div class="schedule_day_full">
													<?php if (count($all_schedules) == 0): ?>
														<div class="none_schedule">
															<img src="/resources/images/icon/speech-bubble.svg" alt="none schedule">
															<p>Расписание отсутствует</p>
														</div>
													<?php endif ?>
													<?php foreach ($all_schedules as $schedule): 
														$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
														$time_lesson = R::findOne('timeline', 'id = ?', array($schedule->timeline));
														$teacher = R::findOne('accounts_generated', 'id = ?', array($schedule->id_teacher));
														?>
														<div class="one_lesson" id="one_lesson">
															<div class="time">
																<div class="time_start"><?=date("H:i", strtotime($time_lesson->time_start));?></div>
																<div class="time_end"><?=date("H:i", strtotime($time_lesson->time_end));?></div>
															</div>
															<div class="line_day_interf"></div>
															<div class="short_info">
																<div class="name_lesson"><?=$lesson->name;?></div>
																<div class="footer-lesson">
																		<div class="cabinet_lesson">
																			<?php if (!empty($schedule->office)) {echo $schedule->office." каб. ";} ?>
																			<?php if (!empty($schedule->floor)) {echo $schedule->floor." этаж ";} ?>
																			<?php if (!empty($schedule->building)) {echo $schedule->building." корпус";} ?>
																		</div>
																		<div class="teacher_lesson"><?=$teacher->surname;?> <?=mb_substr($teacher->name,0,1);?>. <?=mb_substr($teacher->middle_name,0,1);?>.</div>
																</div>
															
															</div>
															<form method="POST" style="display: none;">
																<input type="text" name="id_schedule_del" value="<?=$schedule->id;?>">
																<input type="submit" name="schedule_del" id="schedule_del_<?=$schedule->id;?>">
															</form>
															<div class="one_lesson_delete">
																<div class="button_func_tb button_func_tb_red" onclick="console.log($('#schedule_del_<?=$schedule->id;?>').click());"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endfor ;?>
							</div>
								<section id="info_error">

								<?php 

									
									$errors_found = array();
									$schedules = R::find('schedules', 'id_group = ? AND even_numbered = ?', array($id_group, 0));

									foreach ($schedules as $schedule) {
										// Однинаковые кабинеты
										$check_error = R::findOne('schedules', 'timeline = ? AND id_day = ? AND id_group != ? AND even_numbered = ? AND id != ? AND office = ?', array($schedule->timeline, $schedule->id_day, $id_group , $schedule->even_numbered, $schedule->id, $schedule->office));

										if ($check_error) {
											$week_num = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота');
											$group_name = R::findOne('groups_students', 'id = ?', array($check_error->id_group))->name;
											$timeline = R::findOne('timeline', 'id = ?', array($schedule->timeline));
											$error_generation = "Кабинет №".$schedule->office." используется несколько раз.<br><b>День недели:</b> ".$week_num[$schedule->id_day - 1]."; <b>Время:</b> ". date("H:i", strtotime($timeline->time_start)) ." - ". date("H:i", strtotime($timeline->time_end)) ."; <b>Совместная группа:</b> " . $group_name.";";
											array_push($errors_found, $error_generation);
										}
										// Одинаковые преподаватели
										$check_error = R::findOne('schedules', 'timeline = ? AND id_day = ? AND id_group != ? AND even_numbered = ? AND id != ? AND id_teacher = ?', array($schedule->timeline, $schedule->id_day, $id_group , $schedule->even_numbered, $schedule->id, $schedule->id_teacher));
										if ($check_error) {
											$week_num = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота');
											$group_name = R::findOne('groups_students', 'id = ?', array($check_error->id_group))->name;
											$timeline = R::findOne('timeline', 'id = ?', array($schedule->timeline));
											$teacher = R::findOne('accounts_generated', 'id = ?', array($schedule->id_teacher));
											$error_generation = "Преподаватель <b>$teacher->surname $teacher->name $teacher->middle_name</b> ведет в одно время, в нескольких группах.<br><b>День недели:</b> ".$week_num[$schedule->id_day - 1]."; <b>Время:</b> ". date("H:i", strtotime($timeline->time_start)) ." - ". date("H:i", strtotime($timeline->time_end)) ."; <b>Совместная группа:</b> " . $group_name.";";
											array_push($errors_found, $error_generation);
										}
									}

									
									
									if (count($errors_found) != 0) {
										echo "<h1 class='main_header'>Ошибки при заполнении расписания:</h1><br>";
										sort($errors_found);
									}
									foreach ($errors_found as $error) {
										echo "<div class=\"alert alert-primary\" role=\"alert\">".$error."</div>";
									}
								?>
							</section>
						</div>
					</div>
				</div>
			</section>


		</div>
	</div>
</div>

<div class="modal fade" id="add-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить урок в расписание</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-12 mb-3">
	        		<label for="inputLesson" class="form-label">Выберите урок</label>
					<select class="form-select form-control-input" id="inputLesson" aria-label="Предмет" required>
						<option value="0">Выберите урок</option>
						<?php foreach($all_lessons as $lesson): ?>
					  		<option value="<?=$lesson->id?>"><?=$lesson->name;?></option>
						<?php endforeach; ?>
					</select>
	        	</div>

	        	<div class="col-6">
	        		<label for="inputHeadTimeline" class="form-label">Выберите график</label>
	        			<?php if (count($all_head_timeline) == 1) {$disabled_select = "disabled";} ?>
	        			<select class="form-select form-control-input" id="inputHeadTimeline" aria-label="График" <?=$disabled_select;?> required>
	        				<?php foreach($all_head_timeline as $index => $head_timeline): 
	        					if($index == 1){$id_user_head_timeline = $head_timeline->id;}?>
					  			<option value="<?=$head_timeline->id?>"><?=$head_timeline->name;?></option>
							<?php endforeach; ?>
	        			</select>
	        		</div>
	        	<div class="col-6 mb-3">
	        		<label for="inputTime" class="form-label">Выберите время</label>
	        			<select class="form-select form-control-input" id="inputTime" aria-label="Преподаватель" required>
	        				
	        			</select>
	        	</div>

	        	<div class="col-12">
	        		<div class="row">
	        			<div class="col-6">
	        				<label for="inputTeacher" class="form-label">Преподаватель</label>
	        				<select class="form-select form-control-input" id="inputTeacher" aria-label="Преподаватель" disabled required>
							</select>
	        			</div>
	        			<div class="col-6">
	        				<label for="inputOffice" class="form-label">Кабинет</label>
	        				<div class="all_input_cab row">
	        					<div class="col"><input type="text" placeholder="Каб." name="inputOffice" id="inputOffice" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        					<div class="col"><input type="text" placeholder="Этаж" name="inputFloor" id="inputFloor" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        					<div class="col"><input type="text" placeholder="Корпус" name="inputBuilding" id="inputBuilding" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        				</div>
	        			</div>
	        		</div>
	        		<input type="hidden" name="inputIdGroup" id="inputIdGroup" value="<?=$id_group;?>" readonly>
	        		<input type="hidden" name="inputIdDay" id="inputIdDay" value="" readonly>
	        		<input type="hidden" name="inputEvenNumbered" id="inputEvenNumbered" value="" readonly>
	        	</div>

	        </div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" onclick="add_new_schedule()" name="add_group" class="btn btn-primary btn-def" value="Добавить урок">
	      </div>
      </form>
    </div>
  </div>
</div>

<?php




//Вывод ошибок

if (count($error_del) != 0) {
	$error_del_text = "";
	foreach ($error_del as $value) {
		$error_del_text .= $value;
	}
	echo "<script>
	window.onload = function(){alert('".$error_del_text."');}
</script>";
}
?>