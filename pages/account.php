<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Панель администратора <span class="highlight"><?=Institution::$SHORT_NAME;?></span></h1>

					<div class="section_all_func">
						<div class="left_func">
							<div class="line_left_block">
								<div class="block_func">
									<div class="name">
										<a href="/groups-all">
											<span name="title">Обучающиеся</span>
											<span name="count"><?=$count_students;?> чел.</span>
											<div class="arrow"><img src="resources/images/icon/right-arrow-angle.svg" alt="right arrow angle"></div>
										</a>
									</div>
									<div class="inp_search" id="student">
										<label for="student_search">Быстрый поиск</label>
										<div class="search">
											<form>
												<input type="text" oninput="EDIT_DOM.student_search(Search_info.search_students($(this).val()), 'result_student_search');" id="student_search" name="student_search" class="form-control form-control-input" action='' autocomplete='off' placeholder="ФИО студента или группа">
											</form>
										</div>
										<div class="content_search" id="result_student_search">
											<div class="none_search">
												<img src="resources/images/none_search.svg">
											</div>
										</div>
									</div>
								</div>
								<div class="block_func">
									<div class="name">
										<a href="#">
											<span name="title">Преподаватели</span>
											<span name="count">71 чел.</span>
											<div class="arrow"><img src="resources/images/icon/right-arrow-angle.svg"></div>
										</a>
									</div>
									<div class="inp_search" id="teacher">
										<label for="teacher_search">Быстрый поиск</label>
										<div class="search">
											
											<form>
												<input type="text" id="teacher_search" name="teacher_search" class="form-control form-control-input" action='' autocomplete='off' placeholder="ФИО преподавателя">
											</form>
										</div>
										<div class="content_search">
											<div class="none_search">
												<img src="resources/images/none_search.svg">
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
