 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Расписание для групп <span class="highlight"><?=Institution::$SHORT_NAME;?></span></h1>
					<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table">
								<div class="button_table_func button_table_func_opacity" onclick="generatingAuthInfo(<?=$info_group->id;?>)"><img src="/resources/images/icon/document.svg" alt="document"><span>Экспорт паролей</span></div>
								<div class="button_table_func button_table_func_blue" data-toggle="modal" data-target="#add-teachers"><img src="/resources/images/icon/add.svg" alt="document"><span>Добавить</span></div>
							</div>
						</div>
					</div>
					<div class="all_groups">
						<div class="row">
							<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12" >
								<div class="row" style="margin: 0px">
									<?php 
									foreach ($all_groups as $group):
										$count_students = R::count("accounts_generated", "group_id = ? AND account_type = ?", array($group->id, 1));
									?>
									<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 group_back">
										<a href="schedule/<?=$group->id;?>">
											<div class="group_info">
												<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
												<div class="title"><div class="name">Группа <?=$group->name;?></div><div class="option">Обучающихся: <?=$count_students;?></div></div>
												<div class="opt"><div class="on"></div></div>
											</div>
										</a>
									</div>
									<?php 
									endforeach;
									?>
									<!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 group_back">
										<div class="group_info">
											<div class="image"><div class="back"><img src="/resources/images/icon/hexagons.svg" alt="hexagons"></div></div>
											<div class="title"><div class="name">Группа 17П-1</div><div class="option">Обучающихся: 24</div></div>
											<div class="opt"><div class="on"></div></div>
										</div>
									</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
