<form action="<?=site_url('login-in');?>" method="POST" class="form-signin">
	<h2 class="form-signin-heading text-center">Панель управления</h2>
	<input type="text" class="input-block-level valid-required" name="login" value="" placeholder="Ваш логин">
	<input type="password" class="input-block-level valid-required" name="password" value="" placeholder="Пароль">
	<div class="div-form-operation">
		<button class="btn input-block-level btn-loading no-clickable btn-submit" type="submit">Войти</button>
	</div>
</form>