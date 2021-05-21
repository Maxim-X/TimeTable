<section id="reminder">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-5 col-lg-8 col-md-8 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3 style="font-size: 32px;">Восстановление пароля</h3>
					
					<form method="POST" class="mt-5">
						<?php
						if (isset($error_reminder)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reminder}</div>";
						}else if(isset($success_reminder)){
							echo "<div class='alert alert-success' role='alert'>{$success_reminder}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="inputReminderPass" class="form-label">Новый пароль</label>
							<input type="text" name="inputPassword" class="form-control form-control-input" id="inputReminderPass" placeholder="Введите новый пароль" required>
						</div>

						<div class="mb-3">

							<div class="g-recaptcha" data-theme="dark" data-sitekey="6Lc4rdYaAAAAACEBCkiHOjJgrTh3fCk5jCUTk_-v"></div>
							
						</div>
						<button type="submit" name="reminderEditUser" class="btn btn-primary btn-def" style="width: 100%;">Отправить</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>



<script src='https://www.google.com/recaptcha/api.js'></script>