 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
			<div class="all_dop_page_info">
				<div class="block_dop_info">
					<div class="head_dop_info">Замены занятий <span id="num_repl_lesson">(0)</span><div class="dop_head_text">на <?=$date_day_format;?></div></div>
					<div class="all_folders_repl" id="all_folders_repl">
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Редактирование замен занятий</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table" style="justify-content: space-between;">
								<div></div>
								<div class="input-group def-group">
								  <select class="form-select form-control-input" id="inputGroupSelect04" aria-label="Example select with button addon">
								    <option selected>Выберите группу</option>
								  </select>
								  <button class="btn btn-outline-secondary btn btn-primary btn-def" onclick="open_group()" type="button">Добавить замены</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row calendar">
							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
								<div class="schedule_day">
									<div class="schedule_day_head">
										<?php 
										$day_num = date("N",strtotime($_GET['date']));
										if ($group->use_even != 0) {
											if (date("W",strtotime($_GET['date'])) % 2 == 0 ) {
												$week_num = 1;
											}else{
												$week_num = 0;
											}
										}else{
											$week_num = 0;
										}
										$group = R::findOne('groups_students', 'id = ?', array($id_group));
										$id_group = $_GET['group'];
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($id_group, $day_num, $week_num));
										$all_schedules = R::convertToBeans( 'schedules', $all_schedules);
										?>	
										<div class="name_day">Основное расписание</div>
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
							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
								<div class="schedule_day">
									<div class="schedule_day_head">
										<?php 
										$day_num = date("N",strtotime($_GET['date']));
										if ($group->use_even != 0) {
											if (date("W",strtotime($_GET['date'])) % 2 == 0 ) {
												$week_num = 1;
											}else{
												$week_num = 0;
											}
										}else{
											$week_num = 0;
										}
										$group = R::findOne('groups_students', 'id = ?', array($id_group));
										$id_group = $_GET['group'];
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($id_group, $day_num, $week_num));
										$all_schedules = R::convertToBeans( 'schedules', $all_schedules);
										?>	
										<div class="name_day">Замены</div>
										<!-- <div class="button_anim_scale" onclick="show_form_add_schedule(this)" data-toggle="modal" id="button_open_add_schedule" day="<?=$_GET['date'];?>" data-target="#add-group"><img src="/resources/images/icon/plus-positive-add-mathematical-symbol.svg"></div> -->
									</div>
									<div class="schedule_day_full">
										<?php if (count($all_schedules) == 0): ?>
											<div class="none_schedule">
												<img src="/resources/images/icon/speech-bubble.svg" alt="none schedule">
												<p>Расписание отсутствует</p>
											</div>
										<?php endif ?>
										<?php foreach ($all_schedules as $schedule): 
											$replace = R::findOne('replacing', 'id_schedule = ? AND date = ?', array($schedule->id, $_GET['date']));
											if ($replace) {
												$schedule = $replace;
											}
											$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
											$time_lesson = R::findOne('timeline', 'id = ?', array($schedule->timeline));
											?>

											<div class="one_lesson" data-toggle="modal" onclick="get_schedule_info(<?=$schedule->id;?>)" id-schedule="<?=$schedule->id;?>" id="button_open_add_schedule" data-target="#edit-lesson" id="one_lesson"<?php if (!$replace):?> style="opacity: 0.1" <?php endif ?>>
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
							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
								<div class="schedule_day">
									<div class="schedule_day_head">
										<?php 
										$day_num = date("N",strtotime($_GET['date']));
										if ($group->use_even != 0) {
											if (date("W",strtotime($_GET['date'])) % 2 == 0 ) {
												$week_num = 1;
											}else{
												$week_num = 0;
											}
										}else{
											$week_num = 0;
										}
										$group = R::findOne('groups_students', 'id = ?', array($id_group));
										$id_group = $_GET['group'];
										$all_schedules = R::getAll('SELECT schedules.* FROM `schedules`, `timeline` WHERE schedules.timeline = timeline.id AND schedules.id_group = ? AND schedules.id_day = ? AND schedules.even_numbered = ? ORDER BY timeline.time_start', array($id_group, $day_num, $week_num));
										$all_schedules = R::convertToBeans( 'schedules', $all_schedules);
										?>	
										<div class="name_day">Итог</div>
									</div>
									<div class="schedule_day_full">
										<?php if (count($all_schedules) == 0): ?>
											<div class="none_schedule">
												<img src="/resources/images/icon/speech-bubble.svg" alt="none schedule">
												<p>Расписание отсутствует</p>
											</div>
										<?php endif ?>
										<?php foreach ($all_schedules as $schedule): 
											$replace = R::findOne('replacing', 'id_schedule = ? AND date = ?', array($schedule->id, $_GET['date']));
											if ($replace) {
												if ($replace->cancel == 1) {
													continue;
												}
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
	        <h5 class="modal-title" id="exampleModalLabel">Добавить урок</h5>
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

<div class="modal fade" id="edit-lesson" tabindex="-1" aria-labelledby="edit-lesson" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить замену урока</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-12 mb-3">
	        		<label for="input_edit_Lesson" class="form-label">Выберите урок</label>
					<select class="form-select form-control-input" id="input_edit_Lesson" aria-label="Предмет" required>
						<option value="0">Выберите урок</option>
						<?php foreach($all_lessons as $lesson): ?>
					  		<option value="<?=$lesson->id?>"><?=$lesson->name;?></option>
						<?php endforeach; ?>
					</select>
	        	</div>
	        	<div class="col-12">
	        		<div class="row">
	        			<div class="col-6">
	        				<label for="input_edit_Teacher" class="form-label">Преподаватель</label>
	        				<select class="form-select form-control-input" id="input_edit_Teacher" aria-label="Преподаватель" disabled required>
							</select>
	        			</div>
	        			<div class="col-6">
	        				<label for="input_edit_Office" class="form-label">Кабинет</label>
	        				<div class="all_input_cab row">
	        					<div class="col"><input type="text" placeholder="Каб." name="input_edit_Office" id="input_edit_Office" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        					<div class="col"><input type="text" placeholder="Этаж" name="input_edit_Floor" id="input_edit_Floor" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        					<div class="col"><input type="text" placeholder="Корпус" name="input_edit_Building" id="input_edit_Building" class="form-control form-control-input" onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></div>
	        				</div>
	        			</div>
	        		</div>
	        		<input type="hidden" name="input_edit_id_group" id="input_edit_id_group" value="<?=$id_group;?>" readonly>
	        		<input type="hidden" name="input_edit_Schedule" id="input_edit_Schedule" value="<?=$id_group;?>" readonly>
	        		<input type="hidden" name="input_edit_Date" id="input_edit_Date" value="<?=$_GET['date'];?>" readonly>

	        	</div>

	        </div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" onclick="cancel_lesson()" name="add_group" class="btn btn-primary btn-def" value="Отменить занятие">
	        <input type="submit" onclick="add_new_replace()" name="add_group" class="btn btn-primary btn-def" value="Добавить замену занятия">
	      </div>
      </form>
    </div>
  </div>
</div>