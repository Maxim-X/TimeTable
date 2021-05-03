 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Расписание для группы <span class="highlight"><?=$group->name;?></span></h1>
					<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table">
								<div class="reating-arkows zatujgdsanuk">
								 <input id="e" type="checkbox">
								 <label for="e">
								 <div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
								 <div class="title_but">Четная/нечетная неделя</div>
								 </label>
								</div>
								<div class="button_table_func button_table_func_opacity" onclick="generatingAuthInfo(<?=$info_group->id;?>)"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-teachers"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить</span></div>
							</div>
							<div class="schedule_table">
								<?php 
									$name_week = array('Нечетная', 'Четная');
								if ($group->use_even != 0) {
									$count_week = 1;
								}else{
									$count_week = 0;
								}
								for ($week_num = 0; $week_num <= $count_week; $week_num++):?>
								<div class="row">
									<div class="block_even_week"><h2 class="even_week"><?=$name_week[$week_num];?></h2></div>
									<?php foreach ($day_of_the_week as $day):
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($id_group, $day->id, $week_num));
										$all_schedules = R::convertToBeans( 'schedules', $all_schedules);
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="schedule_day">
												<div class="schedule_day_head">
													<div class="name_day"><?=$day->name;?></div>
													<div class="button_anim_scale" onclick="show_form_add_schedule(this)" data-toggle="modal" id="button_open_add_schedule" day="<?=$day->id;?>" even_numbered="<?=$week_num;?>" data-target="#add-group"><img src="/resources/images/icon/plus-positive-add-mathematical-symbol.svg"></div>
												</div>
												<div class="schedule_day_full">
													<?php foreach ($all_schedules as $schedule): 
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
																<div class="name_lesson"><?=$lesson->name;?></div>
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
							<?php endfor ;?>
							</div>
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
	        				<?php 
	        				
	        				if (isset($id_user_head_timeline)) {
	        					$times = R::find('timeline', 'id_head_timeline = ?', array($id_user_head_timeline));
	  
	        					foreach($times as $time): 
	        					?>
					  				<option value="<?=$time->id?>"><?=substr($time->time_start,0,-3);?> - <?=substr($time->time_end,0,-3);?></option>
								<?php endforeach;
	        				}
	        				?>
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