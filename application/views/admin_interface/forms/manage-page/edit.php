<?=form_open(ADMIN_START_PAGE.'/page/'.$this->uri->segment(3).'/update?mode=update&id='.$this->input->get('id'),array('class'=>'form-manage-page')); ?>
	<div class="control-group">
		<label>Title (RU): </label>
		<input type="text" name="ru_page_title" class="span6" value="<?=$content['ru_page_title'];?>" placeholder="Title" />
		<label>Title (EN): </label>
		<input type="text" name="en_page_title" class="span6" value="<?=$content['en_page_title'];?>" placeholder="Title" />
		<label>Description (RU):</label>
		<textarea class="span6" name="ru_page_description" placeholder="Описание"><?=$content['ru_page_description'];?></textarea>
		<label>Description (EN):</label>
		<textarea class="span6" name="en_page_description" placeholder="Описание"><?=$content['en_page_description'];?></textarea>
		<label>H1 (RU): </label>
		<input type="text" name="ru_page_h1" class="span6" value="<?=$content['ru_page_h1'];?>" placeholder="H1" />
		<label>H1 (EN): </label>
		<input type="text" name="en_page_h1" class="span6" value="<?=$content['en_page_h1'];?>" placeholder="H1" />
		<label>URL: <em>(обязательное)</em></label>
		<input type="text" name="page_url" class="span3 valid-required" readonly="readonly" value="<?=$content['page_url'];?>" placeholder="URL страницы" />
	</div>
	<hr/>
	<div class="control-group">
		<label>Название: <em>(обязательное)</em></label>
		<input type="text" name="title" class="span3 valid-required" value="<?=$content['title'];?>" placeholder="Название" />
	</div>
	<div class="control-group">
		<label>Контент страницы (RU):</label>
		<textarea class="redactor" rows="10" name="ru_content"><?=$content['ru_content'];?></textarea>
	</div>
	<div class="control-group">
		<label>Контент страницы (EN):</label>
		<textarea class="redactor" rows="10" name="en_content"><?=$content['en_content'];?></textarea>
	</div>
	<hr/>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-submit btn-success btn-loading no-clickable">Сохранить</button>
		<a class="btn btn-info" href="<?=site_url(ADMIN_START_PAGE.'/pages');?>">Вернуться к списку</a>
	</div>
<?= form_close(); ?>