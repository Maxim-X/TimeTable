<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Таблица групп</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_opacity"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-group"><img src="/resources/images/icon/add.svg"  alt="document"><span>Добавить группу</span></div>
							</div>
							<div class="section_table">
								<table>
									<thead>
										<tr>
											<th>Название группы</th>
											<th>Количество учеников</th>
											<th>Функции</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($all_groups as $group):
											$count_students = R::count( 'accounts_generated', 'group_id = ?', array($group->id));
										?>
										<tr>
											
												<td><a href="/group/<?=$group->id;?>"><?=$group->name;?></a></td>
												<td><a href="/group/<?=$group->id;?>"><?=$count_students;?></a></td>
												<td>
													<div class="table_row_func">
														<div class="button_func_tb button_func_tb_red"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
														<a href="/group/<?=$group->id;?>"><div class="button_func_tb button_func_tb_blue"><img src="/resources/images/icon/right-chevron.svg" alt="right chevron"></div></a>
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
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
</div>

<!-- Кнопка-триггер модального окна -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Запустить демонстрацию модального окна
</button> -->

<!-- Модальное окно -->
<div class="modal fade" id="add-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <label for="inputNameGroup" class="form-label">Введите название группы</label>
			<input type="text" name="name_group" id="inputNameGroup" class="form-control">
	      </div>
	      <div class="modal-footer">
	        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button> -->
	        <!-- <button type="button" name="add_group"  class="btn btn-primary"></button> -->
	        <input type="submit" name="add_group" class="btn btn-primary" value="Добавить группу">
	      </div>
      </form>
    </div>
  </div>
</div>