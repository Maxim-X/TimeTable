 <div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-1">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-11 col-sm-12 col-12">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Календарь замен занятий</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<div class="bar_table" style="justify-content: space-between;">
								<div class="menu_month">
									<?php if(date('Y-m', strtotime('-1 MONTH', strtotime($full_calendar_use))) < date('Y-m')){$hidden = 'hidden';}?>
									<div class="back <?=$hidden;?>">
										<a href="<?php if(!isset($hidden)){ ?>
											/replacing/<?=date('Y-m', strtotime('-1 MONTH', strtotime($full_calendar_use)));?>
											<?php } else {echo "#";}?>">
											<img src="/resources/images/icon/calendar-menu-arrow.svg" alt="arrow">
										</a>
									</div>
									<div class="name_month"><?=$Calendar_use['month'];?> <?=$Calendar_use['year'];?></div>
									<div class="next"><a href="/replacing/<?=date('Y-m', strtotime('+1 MONTH', strtotime($full_calendar_use)));?>"><img src="/resources/images/icon/calendar-menu-arrow.svg" alt="arrow"></a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row calendar">
						<div class="col-xxl-10 col-xl-12 col-lg-12 col-md-12">
							<?=$Calendar_use['calendar']; ?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
