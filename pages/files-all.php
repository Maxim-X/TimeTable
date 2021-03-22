<div class="container-fluad">
	<div class="row" style="margin-right: 0px;">
		<div class="col-xxl-2 col-xl-2 col-lg-2">
			<?php include("inc/menu.php"); ?>
		</div>

		<div class="col-xxl-10 col-xl-10 col-lg-10">
			<?php include("inc/menu.top.php"); ?>
			<section id="content">
				<div class="main_content">
					<h1 class="main_header">Ваши файлы</h1>
					<div class="row all_content_mg">
						<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12">
							<div class="info_drive info_drive_big">
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
						</div>
						<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12">
							<div class="drag_and_drop_file">
								<div class="image"><img src="/resources/images/icon/file-folder.svg" alt="file"></div>
									<div class="title"><p>Перетащите файл сюда или <br> <span id="upload_but">выберите файл</span> 
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


<script src="/resources/js/dropzone.js"></script>

<script>
	window.onload = function(){
		EDIT_DOM.reload_all_files();
	}
</script>