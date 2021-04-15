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
								<div class="row">
									<?php foreach ($day_of_the_week as $day): 
										$all_schedules = R::find("schedules", "id_group = ? AND id_day = ?", array($id_group, $day->id))
										?>
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
											<div class="schedule_day">
												<div class="schedule_day_head">
													<div class="name_day"><?=$day->name;?></div>
													<div class="button_anim_scale" data-toggle="modal" data-target="#add-group"><img src="/resources/images/icon/plus-positive-add-mathematical-symbol.svg"></div>
												</div>
												<div class="schedule_day_full">
													<?php foreach ($all_schedules as $schedule): 
														$lesson = R::findOne("lessons", "id = ?", array($schedule->id_lesson));
														?>
														<div class="one_lesson" id="one_lesson">
															<div class="time">
																<div class="time_start">08:50</div>
																<div class="time_end">10:20</div>
															</div>
															<div class="line_day_interf"></div>
															<div class="short_info">
																<div class="name_lesson"><?=$lesson->name;?></div>
																<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="schedule_table">
								<div class="row">
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Понедельник</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">08:50</div>
														<div class="time_end">10:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">13:50</div>
														<div class="time_end">15:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Вторник</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">08:50</div>
														<div class="time_end">10:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">13:50</div>
														<div class="time_end">15:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Среда</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">08:50</div>
														<div class="time_end">10:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Четверг</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">08:50</div>
														<div class="time_end">10:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Пятница</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">13:50</div>
														<div class="time_end">15:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Суббота</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">13:50</div>
														<div class="time_end">15:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
										<div class="schedule_day">
											<div class="name_day">Воскресенье</div>
											<div class="schedule_day_full">
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">08:50</div>
														<div class="time_end">10:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">10:35</div>
														<div class="time_end">12:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Web-программирование.</div>
														<div class="cabinet_lesson">214 каб. 2 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">12:20</div>
														<div class="time_end">13:05</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
												<div class="one_lesson" id="one_lesson">
													<div class="time">
														<div class="time_start">13:50</div>
														<div class="time_end">15:20</div>
													</div>
													<div class="line_day_interf"></div>
													<div class="short_info">
														<div class="name_lesson">Программирование в компьютерных системах.</div>
														<div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div>
													</div>
												</div>
											</div>
										</div>
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

<div class="modal fade" id="add-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить предмет в расписание</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-12 mb-3">
	        		<label for="inputNameGroup" class="form-label">Введите название предмета</label>
					<input type="text" name="name_group" id="inputNameGroup" class="form-control form-control-input">
	        	</div>

	        	<div class="col">
	        		<div class="row time_start_add">
	        			<label for="inputNameGroup" class="form-label">Время начала</label>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="09" name="name_group" id="inputNameGroup" class="form-control form-control-input form-control-input-time">
	        			</div>
	        			<div class="col-1 col-dv-time"><div class="dv-time">:</div></div>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="30" name="name_group" id="inputNameGroup" class="form-control form-control-input form-control-input-time">
	        			</div>
	        		</div>
	        	</div>
	        	<div class="col-1 col-dv-time"></div>
	        	<div class="col">
	        		<div class="row time_end_add">
	        			<label for="inputNameGroup" class="form-label">Время окончания</label>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="11" name="name_group" id="inputNameGroup" class="form-control form-control-input form-control-input-time">
	        			</div>
	        			<div class="col-1 col-dv-time"><div class="dv-time">:</div></div>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="00" name="name_group" id="inputNameGroup" class="form-control form-control-input form-control-input-time">
	        			</div>
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_group" class="btn btn-primary btn-def" value="Добавить группу">
	      </div>
      </form>
    </div>
  </div>
</div>