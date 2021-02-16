<section id="reminder">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-4 col-lg-3 d-md-none d-none d-lg-block d-xl-block d-xxl-block">
				<img src="/resources/images/logo.svg" alt="Logo">
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
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

							<div class="g-recaptcha" data-theme="dark" data-sitekey="6LfauDoaAAAAAIunTLnBB5i4OvlC_GVVaBRzlW6X"></div>
							
						</div>
						<button type="submit" name="reminderEditUser" class="btn btn-primary btn-def" style="width: 100%;">Отправить</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>



<script src='https://www.google.com/recaptcha/api.js'></script>