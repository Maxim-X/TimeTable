<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Таблица учеников <span class="highlight"><?=$info_group->name;?></span></h1>
					<div class="row all_content_mg">
						<div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_opacity" onclick="generatingAuthInfo(<?=$info_group->id;?>)"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-students"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить</span></div>
							</div>
							<div class="section_table">
								<table>
									<thead>
										<tr>
											<th>Фамилия</th>
											<th>Имя</th>
											<th>Отчество</th>
											<th>Логин</th>
											<th>Функции</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											foreach ($students_group as $student):
										?>
											<tr>
												<td><?=$student->surname;?></td>
												<td><?=$student->name;?> </td>
												<td><?=$student->middle_name;?></td>
												<td><?=$student->login;?></td>
												<td>
													<div class="table_row_func">
														<div class="button_func_tb button_func_tb_red"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
														<div class="button_func_tb button_func_tb_blue" onclick="editStudentInfo(<?=$student->id;?>)"><img src="/resources/images/icon/pencil.svg" alt="pencil"></div>
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
						<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-12">
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
											<p><a href="#" onclick="closeEditStudentInfo();return;">отменить</a></p>
										</div>
										<form id="edit_info_student" method="POST">
											<input type="hidden" name="user_id" class="form-control form-control-input" id="user_id" value="2" required="">
											<div class="mb-3">
											    <label for="user_name" class="form-label">Имя</label>
												<input type="text" name="user_name" class="form-control form-control-input" id="user_name" value="" required="">
											</div>
											<div class="mb-3">
											    <label for="user_surname" class="form-label">Фамилия</label>
												<input type="text" name="user_surname" class="form-control form-control-input" id="user_surname" value="" required="">
											</div>
											<div class="mb-3">
											    <label for="user_middle_name" class="form-label">Отчество</label>
												<input type="text" name="user_middle_name" class="form-control form-control-input" id="user_middle_name" value="" required="">
											</div>
											<div class="mb-3">
											    <label for="user_group" class="form-label">Группа</label>
											    <select class="form-select form-control-input" name="user_group" id="user_group">
											    	<?php foreach ($all_groups as $group): ?>
												  		<option value="<?=$group->id;?>" <?php if($group->id == $info_group->id){echo "selected";} ?>><?=$group->name;?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="mb-3">
												<button type="submit" name="editUserData" class="btn btn-primary btn-def" style="width: 100%;">Сохранить</button>
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

<!-- Модальное окно -->
<div class="modal fade" id="add-students" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить студентов в группу <span><?=$info_group->name;?></span></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="all_add_students_list" id="all_add_students_list">
	      	<div class="row">
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      <div class="modal-body">
			        <label for="inputSurnameStudent_1" class="form-label">Фамилия студента</label>
					<input type="text" name="surname_student_1" id="inputSurnameStudent_1" class="form-control form-control-input">
			      </div>
		      	</div>
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      	<div class="modal-body">
			        <label for="inputNameStudent_1" class="form-label">Имя студента</label>
					<input type="text" name="name_student_1" id="inputNameStudent_1" class="form-control form-control-input">
			     	</div>
		      	</div>
		      	<div class="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12">
			      <div class="modal-body">
			        <label for="inputMiddleNameStudent_1" class="form-label">Отчество студента</label>
					<input type="text" name="middle-name_student_1" id="inputMiddleNameStudent_1" class="form-control form-control-input">
			      </div>
		      </div>
		   </div>
	      </div>
	      <div class="add-new-input-student">
	      	<div class="button-delete" onclick="deleteTamplateStudent()">-</div>
	      	<div class="button-add" onclick="addTamplateStudent()">+</div>
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_students" class="btn btn-primary btn-def" value="Добавить студентов в группу">
	      </div>
      </form>
    </div>
  </div>
</div>

<script src="/resources/js/dropzone.js"></script>
