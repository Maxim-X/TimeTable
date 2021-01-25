<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-4 col-lg-3 d-md-none d-none d-lg-block d-xl-block d-xxl-block">
				<img src="/resources/images/logo.svg" alt="Logo">
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="main_user_login">
					<h3>С возвращением!</h3>
					<p>Мы так рады видеть вас снова!</p>
					<form method="POST">
						<?php
						if (isset($error_auth)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_auth}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="inputLoginAuth" class="form-label">Логин</label>
							<input type="text" name="inputLogin" class="form-control" id="inputLoginAuth" placeholder="Введите ваш логин" value="<?=$login;?>" required>
						</div>
						<div class="mb-4">
						    <label for="inputPasswordAuth" class="form-label">Пароль</label>
							<input type="password" name="inputPassword" class="form-control" id="inputPasswordAuth" placeholder="Введите ваш пароль" required>
						</div>
						<div class="mb-3">

							<div class="g-recaptcha" data-sitekey="6LfauDoaAAAAAIunTLnBB5i4OvlC_GVVaBRzlW6X"></div>
							
						</div>
						<button type="submit" name="authUser" class="btn btn-primary btn-def" style="width: 100%;">Войти</button>
					</form>
					<div class="login_url">
						<a href="#">Забыли пароль?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<script src='https://www.google.com/recaptcha/api.js'></script>