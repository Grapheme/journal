<?=form_open(ADMIN_START_PAGE.'/page/'.$this->uri->segment(3).'/update?mode=update&id='.$this->input->get('id'),array('class'=>'form-manage-page')); ?>
	<div class="control-group">
		<label>Title: </label>
		<input type="text" name="page_title" class="span6" value="<?=$content['page_title'];?>" placeholder="Title" />
		<label>Description:</label>
		<textarea class="span6" name="page_description" placeholder="Описание"><?=$content['page_description'];?></textarea>
		<label>H1: </label>
		<input type="text" name="page_h1" class="span6" value="<?=$content['page_h1'];?>" placeholder="H1" />
		<label>URL: <em>(обязательное)</em></label>
		<input type="text" name="page_url" class="span3 valid-required" readonly="readonly" value="<?=$content['page_url'];?>" placeholder="URL страницы" />
	</div>
	<hr/>
	<div class="control-group">
		<label>Название: <em>(обязательное)</em></label>
		<input type="text" name="title" class="span3 valid-required" value="<?=$content['title'];?>" placeholder="Название" />
	</div>
	<div class="control-group">
		<label>Контент страницы:</label>
		<textarea class="redactor" rows="10" name="content"><?=$content['content'];?></textarea>
	</div>
	<hr/>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-submit btn-success no-clickable btn-loading">Сохранить</button>
		<a class="btn btn-info" href="<?=site_url(ADMIN_START_PAGE.'/pages');?>">Завершить</a>
	</div>
<?= form_close(); ?>