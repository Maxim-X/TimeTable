<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Таблица преподавателей <span class="highlight"><?=Institution::$SHORT_NAME;?></span></h1>
					<div class="row all_content_mg">
						<div class="col-xxl-7 col-xl-8 col-lg-8 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_opacity" onclick="generatingAuthInfo()"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-teachers"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить</span></div>
							</div>
							<div class="section_table">
								<table>
									<thead>
										<tr>
											<th>Фамилия</th>
											<th>Имя</th>
											<th>Отчество</th>
											<th>Предметы</th>
											<th>Функции</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											foreach ($teachers as $teacher):
												$all_lessons_teacher = R::getAll("SELECT * FROM `lessons`, `teachers_lessons` WHERE teachers_lessons.id_teacher = ? AND lessons.id = teachers_lessons.id_lesson", array($teacher->id));
										?>
											<tr>
												<td><?=$teacher->surname;?></td>
												<td><?=$teacher->name;?> </td>
												<td><?=$teacher->middle_name;?></td>
												<td><div class="lessons">
													<?php foreach ($all_lessons_teacher as $lesson): ?>
														<div class="lesson"><?=$lesson['name'];?><span class="delete" onclick="deleteLessonForTeacher(this, <?=$lesson['id_lesson'];?>, <?=$teacher->id;?>);"><img src="/resources/images/icon/close.svg" alt="close"></span></div>
													<?php endforeach; ?>
												</div></td>
												<td>
													<div class="table_row_func">
														<div class="button_func_tb button_func_tb_red"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
														<div class="button_func_tb button_func_tb_blue" onclick="editTeacherInfo(<?=$teacher->id;?>)"><img src="/resources/images/icon/pencil.svg" alt="pencil"></div>
													</div>
												</td>
											</tr>
										<?php 
											endforeach;
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
							<div class="block_func_full">
								<div class="block_drive">
									<div class="interactions_drive">
										<div class="info_drive">
											<div class="head_info_drive">
												<div class="image_head_info_drive">
													<img src="/resources/images/icon/cloud.svg" alt="cloud">
												</div>
												<div class="title_head_info_drive">
													<p class="main">Ваш диск</p>
													<p class="general">Provided by TimeTable</p>
												</div>
											</div>
											<div class="remaining_resources">
												<ul class="title_remaining_resources">
													<li><span id="use_space_mb"><?=number_format($use_space_mb, 2);?></span>M</li>
													<li><span id="disk_space_mb"><?=$disk_space_mb;?></span>M</li>
												</ul>
												<div class="progress_bar_remaining_resources">
													<div class="line" id="pr_use_space" style="width: <?=$pr_use_space;?>%"></div>
												</div>
											</div>
										</div>
										<div class="drag_and_drop_file">
											<div class="image"><img src="/resources/images/icon/file-folder.svg" alt="file"></div>
												<div class="title"><p>Перетащите файл сюда или <br> <span id="upload_but">выберите файл</span> 
												</div>
											</div>
									</div>
									<div class="all_user_file">
										<div class="head_user_file">
											<h3>Ваши <span>файлы</span></h3>
											<p><a href="/files-all">все файлы <img src="/resources/images/icon/right-arrow-angle-mini.svg" alt="arrow"></a></p>
										</div>
										<div class="list_user_files">

											<div class="file-upload-list"></div>
											<div id="all_user_files"></div>
										</div>
									</div>
									<div class="inform_use_file">
										<div class="image">
											<img src="/resources/images/icon/information.svg" alt="information">
										</div>
										<div class="title">
											<p>Используйте ваши файлы для автоматического импорта учеников в систему.</p>
										</div>
									</div>
								</div>
								<div class="block_edit_user">
									<div class="edit_user">
										<div class="head_edit_user">
											<h3>Редактировать профиль #<span id="user_edit_id"></span></h3>
											<p><a href="#" onclick="closeEditTeacherInfo();return;">отменить</a></p>
										</div>
										<form id="edit_info_teacher" method="POST">
											<input type="hidden" name="user_id" class="form-control form-control-input" id="user_id" required="">
											<div class="mb-3">
											    <label for="user_surname" class="form-label">Фамилия</label>
												<input type="text" name="user_surname" class="form-control form-control-input" id="user_surname" value="" required="">
											</div>
											<div class="mb-3">
											    <label for="user_name" class="form-label">Имя</label>
												<input type="text" name="user_name" class="form-control form-control-input" id="user_name" value="" required="">
											</div>
											<div class="mb-3">
											    <label for="user_middle_name" class="form-label">Отчество</label>
												<input type="text" name="user_middle_name" class="form-control form-control-input" id="user_middle_name" value="" required="">
											</div>
											<div class="mb-4">
												<button type="submit" name="editUserData" class="btn btn-primary btn-def" style="width: 100%;">Сохранить</button>
											</div>
										</form>
										<hr>
										<form id="add_lesson_for_teacher" method="POST">
											<input type="hidden" name="user_id_th" class="form-control form-control-input" id="user_id_th" required="">
											<div class="mb-3 mt-4">
									    		<label for="user_group" class="form-label">Выберите предмет</label>
											    <select class="form-select form-control-input" name="lesson_id" id="lesson_id">
											    	<option value="" selected>Выберите предмет, чтобы добавить его в профиль преподавателя...</option>
											    	<?php foreach ($all_lessons as $lesson): ?>
												  		<option value="<?=$lesson->id;?>"><?=$lesson->name;?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="mb-3">
												<button type="submit" name="add_lesson_for_teacher" class="btn btn-primary btn-def" style="width: 100%;">Добавить предмет</button>
											</div>
										</form>
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

<div style="display: none">
	<div class="table table-striped" class="files" id="previews">
		<div id="template" class="file_upload">
			<div class="file_info">
				<div class="image"><img src="/resources/images/icon/surface1.svg" alt="surface"></div>
				<div class="name_file"><p data-dz-name></p></div>
			</div>
			<div class="progressbar_upload" data-dz-uploadprogress></div>
		</div>
  	</div>
</div>

</div>


<!-- Модальное окно -->
<div class="modal fade" id="add-teachers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить преподавателей</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="all_add_students_list" id="all_add_teachers_list">
	      	<div class="row">
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      <div class="modal-body">
			        <label for="inputSurnameTeacher_1" class="form-label">Фамилия преподавателя</label>
					<input type="text" name="surname_teacher_1" id="inputSurnameTeacher_1" class="form-control form-control-input">
			      </div>
		      	</div>
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      	<div class="modal-body">
			        <label for="inputNameTeacher_1" class="form-label">Имя преподавателя</label>
					<input type="text" name="name_teacher_1" id="inputNameTeacher_1" class="form-control form-control-input">
			     	</div>
		      	</div>
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      <div class="modal-body">
			        <label for="inputMiddleNameTeacher_1" class="form-label">Отчество преподавателя</label>
					<input type="text" name="middle-name_teacher_1" id="inputMiddleNameTeacher_1" class="form-control form-control-input">
			      </div>
		      </div>
		   </div>
	      </div>
	      <div class="add-new-input-student">
	      	<div class="button-delete" onclick="deleteTamplateStudent()">-</div>
	      	<div class="button-add" onclick="addTamplateTeacher()">+</div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_teachers" class="btn btn-primary btn-def" value="Добавить преподавателя">
	      </div>
      </form>
    </div>
  </div>
</div>

<script src="/resources/js/dropzone.js"></script>
<?php
if (isset($error_add_lesson)) { echo "<script>window.onload=function(){alert('".$error_add_lesson."');}</script>"; }
?>