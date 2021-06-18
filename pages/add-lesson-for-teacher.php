 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
						<div class="back_url"><a href="/teachers"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" x="0" y="0" viewBox="0 0 447.243 447.243" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
						<g xmlns="http://www.w3.org/2000/svg"><g><path d="M420.361,192.229c-1.83-0.297-3.682-0.434-5.535-0.41H99.305l6.88-3.2c6.725-3.183,12.843-7.515,18.08-12.8l88.48-88.48    c11.653-11.124,13.611-29.019,4.64-42.4c-10.441-14.259-30.464-17.355-44.724-6.914c-1.152,0.844-2.247,1.764-3.276,2.754    l-160,160C-3.119,213.269-3.13,233.53,9.36,246.034c0.008,0.008,0.017,0.017,0.025,0.025l160,160    c12.514,12.479,32.775,12.451,45.255-0.063c0.982-0.985,1.899-2.033,2.745-3.137c8.971-13.381,7.013-31.276-4.64-42.4    l-88.32-88.64c-4.695-4.7-10.093-8.641-16-11.68l-9.6-4.32h314.24c16.347,0.607,30.689-10.812,33.76-26.88    C449.654,211.494,437.806,195.059,420.361,192.229z" fill="#000000" data-original="#000000" style="" class=""></path></g></g><g xmlns="http://www.w3.org/2000/svg"></g>
						</g></svg> ВЫБОР ПРЕПОДАВАТЕЛЯ</a></div>
					<h1 class="main_header">Назначение предметов для <span class='highlight'><?=$teacher->surname;?> <?=$teacher->name;?> <?=$teacher->middle_name;?></span></h1>
					<?php if (!$alt): ?>
					<div class="all_content_mg">
						<div class="row">
							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
								<div class="bar_table table-mg">
									<form method="POST">
										<div class="reating-arkows zatujgdsanuk">
											<input id="edit_sunday" name="edit_sunday" onchange="location.href='<?=$alt_url;?>'" type="checkbox" <?php if($alt) echo "checked=''"; ?>>
											<label for="edit_sunday">
											<div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
											<div class="title_but">Альтернативная система назначения</div>
											</label>
											<input type="submit" style="display: none" name="save_edit_sunday" id="save_edit_sunday">
										</div>
									</form>
								</div>
								<div class="main_info_page">
									<div class="name">
										<span name="title">Назначение предмета</span>
									</div>
									<form method="POST">
										<div class="row">
											<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-12">
											    <label for="inputGroup" class="form-label">Выберите группу</label>
											    <select class="form-select form-control-input" id="inputGroup" aria-label="Группа" required="">
													<option value="0">Выберите группу</option>
													<?php foreach ($all_group as $group ): ?>
														<option value="<?=$group->id?>"><?=$group->name?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-12">
											    <label for="inputLesson" class="form-label">Выберите предмет</label>
											    <select class="form-select form-control-input" id="inputLesson" aria-label="Предмет" required="">
													<option value="0">Выберите предмет</option>
													<?php foreach ($all_lesson as $lesson ): ?>
														<option value="<?=$lesson->id?>"><?=$lesson->name?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-12">
											    <label class="form-label" style="opacity:0;">Назначить</label>
												<button type="submit" name="add-lesson-for-teacher" class="btn btn-primary btn-def" style="width: 100%;">Назначить</button>
											</div>
										</div>
									</form>
									<br>
									<div class="alert alert-primary d-flex align-items-center alert-primary-def" role="alert">
									  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
									    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
									  </svg>
									  <div>
									    Выбрите группу и предмет, чтобы назначить для преподавателя!
									  </div>
									</div>

								</div>
							</div>
							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
								<div class="table_page section_table" style="margin-top:0px;">
									<table>
										<thead>
											<tr>
												<th>Название предмета</th>
												<th>Группа</th>
												<th>Функции</th>
											</tr>
										</thead>
										<tbody id="all_user_files">
											<?php 
											foreach ($teachers_lessons as $tl):
												$lesson_name = R::findOne('lessons','id = ?', array($tl['id_lesson']));
												$group_name = R::findOne('groups_students','id = ?', array($tl['id_group']));
											?>
											<tr>
													<td><?=$lesson_name->name;?></td>
													<td><?=$group_name->name;?></td>
													<td>
														<div class="table_row_func">
															<div class="button_func_tb button_func_tb_red" id_lesson="<?=$lesson_name->id;?>" id_group="<?=$group_name->id;?>" onclick="edit_del_lesson($(this));"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
														</div>
													</td>
											</tr>
											<?php 
											endforeach;
											?>
											<div class="file-upload-list"></div>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<?php else: ?>
						<div class="bar_table table-mg">
							<form method="POST">
								<div class="reating-arkows zatujgdsanuk">
									<input id="edit_sunday" name="edit_sunday" onchange="location.href='<?=$alt_url;?>'" type="checkbox" <?php if($alt) echo "checked=''"; ?>>
									<label for="edit_sunday">
									<div class="trianglesusing" data-checked="Yes" data-unchecked="No"></div>
									<div class="title_but">Альтернативная система назначения</div>
									</label>
									<input type="submit" style="display: none" name="save_edit_sunday" id="save_edit_sunday">
								</div>
							</form>
						</div>
					<div class="row calendar opt">
						<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
							<div class="table-option">
								<table>
									<thead>
										<tr>
											<th></th>
											<?php foreach($all_group as $group):  ?>
												<th scope="col" group_id="<?=$group->id?>"><?=$group->name?></th>
											<?php endforeach; ?>
										</tr>
									</thead>
									<tbody>
											<?php foreach ($all_lesson as $lesson): ?>
												<tr>
													<th scope="row" lesson_id="<?=$lesson->id;?>"><?=$lesson->name;?></th>
													<?php foreach ($all_group as $group):  ?>
														<td onmouseover="select_cells($(this), <?=$lesson->id;?>, <?=$group->id?>)" onmouseout="select_cells_out($(this), <?=$lesson->id;?>, <?=$group->id?>)"><input type="checkbox" onchange="edit_use_lesson($(this))" id_group="<?=$group->id;?>" id_lesson="<?=$lesson->id;?>" class="form-check-input" 
															<?php if(search_check($lesson->id, $group->id, $teachers_lessons)){ echo 'checked';}?>></td>
													<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
</div>
