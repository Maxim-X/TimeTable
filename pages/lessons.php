<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Все учебные предметы</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-7 col-xl-10 col-lg-12 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-lesson"><img src="/resources/images/icon/add.svg"  alt="document"><span>Добавить предмет</span></div>
							</div>
							<div class="section_table">
								<table>
									<thead>
										<tr>
											<th onclick="document.location.href = '<?=$def_a_id;?>'">ID <?=$arrow_id;?></th>
											<th onclick="document.location.href = '<?=$def_a_name;?>'">Название предмета <?=$arrow_name;?></th>
											<th>Функции</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach ($all_lessons as $lesson):
										?>
										<tr>
											
												<td><?=$lesson->id;?></td>
												<td><?=$lesson->name;?></td>
												<td>
													<div class="table_row_func">
														<form method="POST" style="display: none;">
															<input type="hidden" name="delete_lesson_id" value="<?=$lesson->id;?>" readonly>
															<input type="submit" name="delete_lesson" id="delete_lesson_<?=$lesson->id;?>">
														</form>
														<div class="button_func_tb button_func_tb_red" onclick="console.log($('#delete_lesson_<?=$lesson->id;?>').click());"><img src="/resources/images/icon/bin.svg" alt="bin"></div>
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


<!-- Модальное окно -->
<div class="modal fade" id="add-lesson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
	      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Добавить группу</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <label for="inputNameGroup" class="form-label">Введите название предмета</label>
			<input type="text" name="name_lesson" id="inputNamelesson" class="form-control form-control-input">
	      </div>
	      <div class="modal-footer">
	        <input type="submit" name="add_lesson" class="btn btn-primary btn-def" value="Добавить предмет">
	      </div>
      </form>
    </div>
  </div>
</div>

<?php
//Вывод ошибок


if (count($error) != 0) {
	$error_text = "";
	foreach ($error as $value) {
		$error_text .= $value;
	}
	echo "<script>
	window.onload = function(){alert('".$error_text."');}
</script>";
}

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

<?php
if (isset($error_add_lesson)) { echo "<script>window.onload=function(){alert('".$error_add_lesson."');}</script>"; }
?>