<section id="login">
	<div class="container">
		<div class="row">
			<div class="offset-xxl-4 offset-md-2 col-xxl-4 col-md-8 col-sm-12 col-12">
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
							<input type="text" name="inputLogin" class="form-control" id="inputLoginAuth" placeholder="Введите ваш логин" required>
						</div>
						<div class="mb-3">
						    <label for="inputPasswordAuth" class="form-label">Пароль</label>
							<input type="password" name="inputPassword" class="form-control" id="inputPasswordAuth" placeholder="Введите ваш пароль" required>
						</div>
						<button type="submit" name="authUser" class="btn btn-primary" style="width: 100%;">Войти</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>