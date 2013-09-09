<?=form_open(ADMIN_START_PAGE.'/institutions/insert',array('class'=>'form-manage-institutions')); ?>
	<ul id="ProductTab" class="nav nav-tabs">
		<li class="active"><a href="#ru" data-toggle="tab">Русский</a></li>
		<li><a href="#en" data-toggle="tab">English</a></li>
	</ul>
	<div id="ProductTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="ru">
			<div class="control-group">
				<label>Короткое название: </label>
				<input type="text" class="span4" name="ru_small_title" value="">
				<label>Ссылка на сайт:</label>
				<input type="text" name="ru_site_link" class="span6" value="" />
				<label>Название: </label>
				<textarea class="redactor redactor-row4" name="ru_title"></textarea>
				<label>Контактная информация:</label>
				<textarea class="redactor redactor-row4" name="ru_contacts"></textarea>
				<label>Описание:</label>
				<textarea class="redactor redactor-row4" name="ru_description"></textarea>
			</div>
		</div>
		<div class="tab-pane fade" id="en">
			<div class="control-group">
				<label>Short title: </label>
				<input type="text" class="span4" name="en_small_title" value="">
				<label>Link to site:</label>
				<input type="text" name="en_site_link" class="span6" value="" />
				<label>Title: </label>
				<textarea class="redactor redactor-row4" name="en_title"></textarea>
				<label>Contact:</label>
				<textarea class="redactor redactor-row4" name="en_contacts"></textarea>
				<label>Description:</label>
				<textarea class="redactor redactor-row4" name="en_description"></textarea>
			</div>
		</div>
	</div>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-success btn-submit no-clickable btn-loading">Добавить</button>
	</div>
<?=form_close();?>