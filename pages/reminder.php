<section id="reminder">
	<div class="container">
		<div class="row">
			<div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mx-auto">
				<div class="main_user_login">
					<h3 style="font-size: 32px;">Восстановление пароля</h3>
					<p class="title_head">Какой-то текст!</p>
					<form method="POST" class="mt-5">
						<?php
						if (isset($error_reminder)) {
							echo "<div class='alert alert-danger' role='alert'>{$error_reminder}</div>";
						}else if(isset($success_reminder)){
							echo "<div class='alert alert-success' role='alert'>{$success_reminder}</div>";
						}
						?>
						<div class="mb-3">
						    <label for="inputReminderReminder" class="form-label">E-mail</label>
							<input type="text" name="inputEmail" class="form-control form-control-input" id="inputReminderReminder" placeholder="Введите ваш E-mail" value="<?=$reminder_email;?>" required>
						</div>
						<div class="mb-3">

							<div class="g-recaptcha" data-theme="dark" data-sitekey="6LfauDoaAAAAAIunTLnBB5i4OvlC_GVVaBRzlW6X"></div>
							
						</div>
						<button type="submit" name="reminderUser" class="btn btn-primary btn-def" style="width: 100%;">Отправить</button>
					</form>
					<div class="inform_blue mb-3 mt-4">
						<p>Функция восстановления пароля доступна только для сотрудников учебной организации. </p>
						<p>Если вы ученик/учитель, то вы можете обратиться к администрации своего учебного заведения для восстановления пароля.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<script src='https://www.google.com/recaptcha/api.js'></script>