<?PHP 
if ($_GET['step'] == "1") {
?>
<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-lg-8 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3>Регистрация</h3>
					<p class="title_head">Зарегистрируйтесь, чтобы добавить ваше учебное заведение или вступить в команду!</p>
					<form method="POST" name="signup">
						<?php
						if (isset($error_reg)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reg}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="inputLoginreg" class="form-label">Логин</label>
							<input type="text" name="inputLogin" class="form-control form-control-input" id="inputLoginreg" placeholder="Введите ваш логин" value="<?=$login;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputEmailreg" class="form-label">Email</label>
							<input type="email" name="inputEmail" class="form-control form-control-input" id="inputEmailreg" placeholder="Введите ваш Email" value="<?=$email;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputPasswordreg" class="form-label">Пароль</label>
							<input type="password" name="inputPassword" class="form-control form-control-input" id="inputPasswordreg" placeholder="Введите ваш пароль" required>
						</div>
						<div class="mb-3">

							<div class="g-recaptcha" data-theme="dark" data-sitekey="6Lc4rdYaAAAAACEBCkiHOjJgrTh3fCk5jCUTk_-v"></div>
							
						</div>
						<button type="submit" name="reg_step_1"  class="btn btn-primary btn-def" style="width: 100%;">Отправить</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?PHP 
}
?>

<?PHP 
if ($_GET['step'] == "2") {
?>
<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-lg-8 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3>Создать учетную запись</h3>
					<p class="title_head">Зарегистрируйтесь чтобы добавить ваше учебное заведение или вступить в команду!</p>
					<form method="POST">
						<?php
						if (isset($error_reg)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reg}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="inputName" class="form-label">Имя</label>
							<input type="text" name="inputName" class="form-control form-control-input" id="inputName" placeholder="Введите ваше имя" value="<?=$Name;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputSurname" class="form-label">Фамилия</label>
							<input type="text" name="inputSurname" class="form-control form-control-input" id="inputSurname" placeholder="Введите вашу фамилию" value="<?=$surname;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputMiddlename" class="form-label">Отчество</label>
							<input type="text" name="inputMiddlename" class="form-control form-control-input" id="inputMiddlename" placeholder="Введите ваше отчество" value="<?=$Middlename;?>" required>
						</div>
						<button type="submit" name="reg_step_2" class="btn btn-primary btn-def" style="width: 100%;">Отправить</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?PHP 
}
?>

<?PHP 
if ($_GET['step'] == "3") {
?>
<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-lg-8 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3>Каков ваш путь?</h3>
					<form method="POST">
						<?php
						if (isset($error_reg)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reg}</div>";
						}
						?>
						<div class="mb-3">
							<p class="title_head_l">Я сотрудник учебного заведения и у меня есть приглашение в команду.</p>
						    <label for="inputCode" class="form-label">Введите код приглашения</label>
							<input type="text" name="inputCode" class="form-control form-control-input" id="inputCode" required>
						</div>
						<div class="mb-3">
							<input type="submit" name="reg_step_3" class="btn btn-primary btn-def" style="width: 100%;" value="Присоединиться">
						</div>
						<div class="lineOR"><div class="line"></div><div class="txt">ИЛИ</div><div class="line"></div></div>
						<div class="mb-3">
						   <p class="title_head_l">Я сотрудник учебного заведения и хочу добавить его в ваш сервис.</p>
						   <a href="/reg/4" class="btn btn-primary btn-def">Добавить</a>
						</div>
					</form>
					<div class="lineOR"><div class="line"></div><div class="txt">А ВОЗМОЖНО</div><div class="line"></div></div>
					<div class="mb-3">
						<form method="POST">
							<input type="submit" name="deleteUser" class="btn-link" style="width: 100%;" value="Я тут по ошибке, удалите мой аккаунт!">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?PHP 
}
?>

<?PHP 
if ($_GET['step'] == "4") {
?>
<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-lg-8 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3 class="mb-4">Учебное заведение</h3>
					<form method="POST">
						<?php
						if (isset($error_reg)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reg}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="type_inst" class="form-label">Шаблон учебного заведения</label>
						    <div class="all-radio-line">
						    	<?php
								foreach ($all_type_inst as $key => $inst):
								?>
									<input type="radio" name="type_inst" class="btn-check" value="<?=$inst->id;?>" id="btn-radio-<?=$inst->id;?>" autocomplete="off" <?php ($key == 0) ? "checked":""; ?>>
									<label class="btn btn-primary btn-radio-ch" for="btn-radio-<?=$inst->id;?>"><?=$inst->name;?></label>
								<?php
							  		endforeach;
							  	?>
						    </div>
						</div>
						<div class="mb-3">
						    <label for="inputFullNameInst" class="form-label">Полное название учебного заведения</label>
							<input type="text" name="inputFullNameInst" class="form-control form-control-input" id="inputFullNameInst" required>
						</div>
						<div class="mb-3">
						    <label for="inputShortNameInst" class="form-label">Краткое название учебного заведения</label>
							<input type="text" name="inputShortNameInst" class="form-control form-control-input" id="inputShortNameInst" required>
						</div>
						<div class="mb-3">
						    <label for="inputTimeZoneInst" class="form-label">Часовой пояс</label>
							<select class="form-select form-select-md form-control-input" name="inputTimeZoneInst" aria-label=".form-select-sm example">
								<?php
									foreach ($all_time_zone as $key => $time_zone):
								?>
									<option value="<?=$time_zone->id;?>" <?php ($key == 0) ? "selected":""; ?> ><?=$time_zone->city;?> (UTC <?=$time_zone->utc;?>)</option>
								<?php
							  		endforeach;
							  	?>
							</select>
						</div>
						<div class="mb-4">
							<div class="inf-acc">
								<div class="image"><img src="/resources/images/icon/insurance.svg" alt="insurance"></div>
								<div class="title">Создать аккаунт учебного заведения могут только сотрудники данной организации.</div>
							</div>
						</div>
						<div class="mb-4">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" name="officialRepresentative" id="officialRepresentative" required>
							  <label class="form-check-label form-check-label-dark" for="officialRepresentative">
							    Я являюсь официальным представителем учебного заведения
							  </label>
							</div>
						</div>
						<div class="mb-3">
							<button type="submit" name="reg_step_4" class="btn btn-primary btn-def" style="width: 100%;">Создать</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?PHP 
}
?>


<script src='https://www.google.com/recaptcha/api.js'></script>