<?=form_open(ADMIN_START_PAGE.'/page/insert?mode=insert',array('class'=>'form-manage-page')); ?>
	<div class="control-group">
		<label>Title: </label>
		<input type="text" name="page_title" class="span6" value="" placeholder="Title" />
		<label>Description:</label>
		<textarea class="span6" name="page_description" placeholder="Описание"></textarea>
		<label>H1: </label>
		<input type="text" name="page_h1" class="span6" value="" placeholder="H1" />
		<label>URL: <em>(обязательное)</em></label>
		<input type="text" name="page_url" class="span3 valid-required" value="" placeholder="URL страницы" />
	</div>
	<hr/>
	<div class="control-group">
		<label>Название: <em>(обязательное)</em></label>
		<input type="text" name="title" class="span3 valid-required" value="" placeholder="Название" />
		<label>Меню:</label>
		<select class="span4" name="menu_position">
		<?php for($i=0;$i<count($menu);$i++):?>
			<option value="<?=$menu[$i]['id']?>"><?=$menu[$i]['comments']?></option>
		<?php endfor;?>
		</select>
	</div>
	<div class="control-group">
		<label>Контент страницы:</label>
		<textarea class="redactor" rows="10" name="content"></textarea>
	</div>
	<hr/>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-submit btn-success no-clickable btn-loading">Создать</button>
	</div>
<?= form_close(); ?>