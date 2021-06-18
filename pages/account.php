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
							<div class="row">
								<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12">
									<div class="block_func" style="width:auto;">
										<div class="name">
											<a href="/groups-all">
												<span name="title">Группы обучающихся</span>
												<span name="count"><?=$count_groups;?> гр.</span>
												<div class="arrow"><img src="/resources/images/icon/right-arrow-angle.svg" alt="right arrow angle"></div>
											</a>
										</div>
										<div class="inp_search" id="student">
											<label for="student_search">Быстрый поиск</label>
											<div class="search">
												<form>
													<input type="text" oninput="EDIT_DOM.student_search(Search_info.search_students($(this).val()), 'result_student_search');" id="student_search" name="student_search" class="form-control form-control-input" action='' autocomplete='off' placeholder="Название группы">
												</form>
											</div>
											<div class="content_search" id="result_student_search">
												<div class="none_search">
													<img src="resources/images/none_search.svg">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12">
									<div class="block_func" style="width: auto;">
											<div class="name">
												<span name="title">Ссылки на расписание</span>
											</div>
											<div class="all_url_group">
												<div class="group">Общая <div class="inp-copy" onclick="window.open('<?php echo $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"];?>/timetable-open?institution_id=<?=Account::$INSTITUTION_ID;?>', '_blank');"><div class="copy"><img src="/resources/images/icon/copy-p.svg"></div><input type="text" class="form-control form-control-input" id="link0" value="<?php echo $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"];?>/timetable-open?institution_id=<?=Account::$INSTITUTION_ID;?>"></div></div>
												<?php foreach ($all_group as $group):?>
													<div class="group"><?=$group->name;?> <div class="inp-copy" onclick="window.open('<?php echo $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"];?>/timetable-open?group_id=<?=$group->id;?>', '_blank');"><div class="copy"><img src="/resources/images/icon/copy-p.svg"></div><input type="text" class="form-control form-control-input" id="link<?=$group->id;?>" value="<?php echo $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"];?>/timetable-open?group_id=<?=$group->id;?>"></div></div>
												<?php endforeach; ?>
											</div>
										</div>
								</div>
								<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12">
									<div class="quick_actions">
										<div class="title"><span>Быстрые действия</span></div>
										<div class="all_quick_actions">
											<div class="item_quick_actions option" onclick="window.location.href='/replacing/edit/<?=date('Y');?>-<?=date('m');?>-<?=date('d', strtotime("+1 day"));?>'">
												<img src="/resources/images/icon/exchange-dark.svg" alt="exchange">
												<div class="txt_quick_actions"><p>Замены на завтра</p></div>
											</div>
											<div class="item_quick_actions" onclick="window.location.href='/replacing/<?=date('Y');?>-<?=date('m');?>'">
												<img src="/resources/images/icon/exchange.svg" alt="exchange">
												<div class="txt_quick_actions"><p>Календарь замен занятий</p></div>
											</div>
											<div class="item_quick_actions" onclick="window.location.href='/schedule'">
												<img src="/resources/images/icon/copy.svg" alt="copy">
												<div class="txt_quick_actions"><p>Основное расписание</p></div>
											</div>
											<div class="item_quick_actions" onclick="window.location.href='<?php echo $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["SERVER_NAME"];?>/timetable-open?institution_id=<?=Account::$INSTITUTION_ID;?>'">
												<img src="/resources/images/icon/group.svg" alt="group">
												<div class="txt_quick_actions"><p>Расписание общего доступа</p></div>
											</div>
										</div>
											<form method="post" class="generation_code">
												<input type="text" name="code_invite" class="form-control form-control-input" placeholder="Код приглашения в команду" value="<?=$last_code->key_invite;?>">
												<button type="submit" name="but_code_invite" class="btn btn-primary btn-def" style="width: 100%;">Сгенерировать</button>
											</form>
									</div>
								</div>
							</div> 
									<div class="row calendar">
										<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
											<?=$Calendar_use['calendar']; ?>
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
