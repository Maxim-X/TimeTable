 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Временные графики</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-head-timeline"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить временной график</span></div>
							</div>
							<div class="schedule_table">
								<div class="row">
									<?php foreach ($all_head_timeline as $head_timeline): 
										$all_item_timeline = R::find("timeline", "id_head_timeline = ? ORDER BY time_start", array($head_timeline->id));
									?>
										<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
											<div class="schedule_day">
												<div class="schedule_day_head">
													<div class="name_day"><?=$head_timeline->name;?></div>
													<div class="button_anim_scale" onclick="show_form_add_timeline(<?=$head_timeline->id;?>)" data-toggle="modal" id="button_open_add_schedule" day="<?=$head_timeline->id;?>" data-target="#add-timeline"><img src="/resources/images/icon/plus-positive-add-mathematical-symbol.svg"></div>
												</div>
												<div class="schedule_day_full">
													<?php foreach ($all_item_timeline as $item_timeline):
														$time_start = date("H:i", strtotime($item_timeline->time_start));
														$time_end = date("H:i", strtotime($item_timeline->time_end));
														?>
														<div class="one_lesson" id="one_lesson">
															<div class="time">
																<div class="time_start"><?=$time_start;?></div>
																<div class="time_end"><?=$time_end;?></div>
															</div>
															<div class="line_day_interf"></div>
															<div class="short_info">
																<div class="name_lesson"><?=$item_timeline->name;?></div>
																<!-- <div class="cabinet_lesson">308 каб. 3 этаж 1 корпус</div> -->
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="modal fade" id="add-head-timeline" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Новый временной график</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-12 mb-3">
	        		<label for="inputLesson" class="form-label">Название временного графика</label>
					<input type="text" name="input_name_head-timeline" id="input_name_head-timeline" placeholder="Введите название временного графика" class="form-control form-control-input">
	        	</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_head-timeline" class="btn btn-primary btn-def" value="Добавить график">
	      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="add-timeline" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Новый временной график</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<?php 
	      		if (count($add_timeline_error) != 0) {
	      			?>
					<div class="alert alert-warning" role="alert">
					  <?=implode("<br>\r\n", $add_timeline_error);?>
					</div>
	      	<?php

	      	// echo "<script>show_modal('add-timeline');</script>";
	      		}
	      	?>
	        <div class="row">
	        	<div class="col-12 mb-3">
	        		<label for="inputLesson" class="form-label">Название </label>
					<input type="text" name="input_name-timeline" value="<?=$_POST['input_name-timeline'];?>" id="input_name-timeline" placeholder="Введите название временного графика" class="form-control form-control-input">
	        	</div>
	        	<div class="col">
	        		<div class="row time_start_add">
	        			<label for="inputTimeStartHours" class="form-label">Время начала *</label>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="09" name="inputTimeStartHours" value="<?=$_POST['inputTimeStartHours'];?>" id="inputTimeStartHours" class="form-control form-control-input form-control-input-time" required>
	        			</div>
	        			<div class="col-1 col-dv-time"><div class="dv-time">:</div></div>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="30" name="inputTimeStartMinutes" value="<?=$_POST['inputTimeStartMinutes'];?>" id="inputTimeStartMinutes" class="form-control form-control-input form-control-input-time" required>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="col-1 col-dv-time"></div>
	        	<div class="col mb-3">
	        		<div class="row time_end_add">
	        			<label for="inputTimeEndHours" class="form-label">Время окончания *</label>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="11" name="inputTimeEndHours" value="<?=$_POST['inputTimeEndHours'];?>" id="inputTimeEndHours" class="form-control form-control-input form-control-input-time" required>
	        			</div>
	        			<div class="col-1 col-dv-time"><div class="dv-time">:</div></div>
	        			<div class="col">
							<input type="text" maxlength="2" placeholder="00" name="inputTimeEndMinutes" value="<?=$_POST['inputTimeEndMinutes'];?>" id="inputTimeEndMinutes" class="form-control form-control-input form-control-input-time" required>
	        			</div>
	        		</div>
	        	</div>
	        	<input type="hidden" name="inputHeadId" id="inputHeadId" class="form-control form-control-input">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_timeline" class="btn btn-primary btn-def" value="Добавить график">
	      </div>
      </form>
    </div>
  </div>
</div>
	<?php 
	if (count($add_timeline_error) != 0) {
		echo "<script>window.onload = function(){ $('#add-timeline').modal('show'); }</script>";
	}
	?>