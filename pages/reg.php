<?PHP 
if ($_GET['step'] == "1") {
?>
<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3>Регистрация</h3>
					<p class="title_head">Зарегистрируйтесь чтобы добавить ваше учебное заведение или вступить в команду!</p>
					<form method="POST">
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

							<div class="g-recaptcha" data-theme="dark" data-sitekey="6LfauDoaAAAAAIunTLnBB5i4OvlC_GVVaBRzlW6X"></div>
							
						</div>
						<button type="submit" name="reg_step_1"  class="btn btn-primary btn-def" style="width: 100%;">Войти</button>
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
			<div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 mx-auto">
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
						    <label for="inputNamereg" class="form-label">Имя</label>
							<input type="text" name="inputName" class="form-control" id="inputNamereg" placeholder="Введите ваше имя" value="<?=$Name;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputSurnamereg" class="form-label">Фамилия</label>
							<input type="text" name="inputSurname" class="form-control" id="inputSurnamereg" placeholder="Введите вашу фамилию" value="<?=$surname;?>" required>
						</div>
						<div class="mb-3">
						    <label for="inputMiddlenamereg" class="form-label">Отчество</label>
							<input type="text" name="inputMiddlename" class="form-control" id="inputMiddlenamereg" placeholder="Введите ваше отчество" value="<?=$Middlename;?>" required>
						</div>
						<button type="submit" name="regUser" class="btn btn-primary btn-def" style="width: 100%;">Войти</button>
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
			<div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mx-auto">
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
						    <label for="inputNamereg" class="form-label">Введите код приглашения</label>
							<input type="text" name="inputLogin" class="form-control" id="inputNamereg" required>
						</div>
						<div class="mb-3">
							<button type="submit" name="regUser" class="btn btn-primary btn-def" style="width: 100%;">Присоединиться</button>
						</div>
						<div class="lineOR"><div class="line"></div><div class="txt">ИЛИ</div><div class="line"></div></div>
						<div class="mb-3">
						   <p class="title_head_l">Я сотрудник учебного заведения и хочу добавить его в ваш сервис.</p>
						   <a href="/reg/4" class="btn btn-primary btn-def">Добавить</a>
						</div>
						<div class="lineOR"><div class="line"></div><div class="txt">А ВОЗМОЖНО</div><div class="line"></div></div>
						<div class="mb-3">
							<button type="submit" name="regUser" class="btn-link" style="width: 100%;">Я тут по ошибке, удалите мой аккаунт!</button>
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