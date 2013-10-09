<form action="<?=site_url(ADMIN_START_PAGE.'/password-save');?>" method="POST" class="form-profile">
	<div class="control-group">
		<label>Старый пароль:</label>
		<input type="password" class="valid-required" name="oldpassword" value="" placeholder=""><br/>
		<label>Новый пароль:</label>
		<input type="password" class="valid-required input-new-password" name="password" value="" placeholder=""><br/>
		<label>Повтор пароля:</label>
		<input type="password" class="valid-required input-confirm-password" name="confirm" value="" placeholder=""><br/>
	</div>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-submit btn-success no-clickable btn-loading">Сохранить</button>
	</div>
</form>