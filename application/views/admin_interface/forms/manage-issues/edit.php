<?=form_open(ADMIN_START_PAGE.'/issues/update?mode=edit&id='.$this->input->get('id'),array('class'=>'form-manage-issues')); ?>
	<ul id="ProductTab" class="nav nav-tabs">
		<li class="active"><a href="#ru" data-toggle="tab">Русский</a></li>
		<li><a href="#en" data-toggle="tab">English</a></li>
	</ul>
	<div id="ProductTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="ru">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="ru_page_title" class="span6" value="<?=$issue['ru_page_title']?>" placeholder="Title страницы" />
				<label>Description:</label>
				<textarea class="span6" name="ru_page_description" placeholder="Description страницы"><?=$issue['ru_page_description']?></textarea>
				<label>H1: </label>
				<input type="text" name="ru_page_h1" class="span6" value="<?=$issue['ru_page_h1']?>" placeholder="H1 страницы" />
			</div>
			<div class="control-group">
				<label>Название:</label>
				<input type="text" name="ru_title" class="span6" value="<?=$issue['ru_title']?>" placeholder="" />
			</div>
		</div>
		<div class="tab-pane fade" id="en">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="en_page_title" class="span6" value="<?=$issue['en_page_title']?>" placeholder="Title page" />
				<label>Description:</label>
				<textarea class="span6" name="en_page_description" placeholder="Description page"><?=$issue['en_page_description']?></textarea>
				<label>H1: </label>
				<input type="text" name="en_page_h1" class="span6" value="<?=$issue['en_page_h1']?>" placeholder="H1 page" />
			</div>
			<div class="control-group">
				<label>Title:</label>
				<input type="text" name="en_title" class="span6" value="<?=$issue['en_title']?>" placeholder="" />
			</div>
		</div>
	</div>
	<hr/>
	<div class="control-group">
		<label>Номер выпуска:</label>
		<input type="text" name="number" class="span1 valid-required valid-numeric" value="<?=$issue['number']?>" placeholder="" />
		<?php $this->load->helper('date');?>
		<?=getMonthList(0,12,$issue['month']);?>
		<?=getYearsList(2013,2006,TRUE,$issue['year']);?>
	</div>
	<div class="div-form-operation">
		<a href="<?=site_url(ADMIN_START_PAGE.'/issue/'.$this->input->get('id').'/download-xml');?>" class="btn btn-info">Сформировать XML</a>
		<button type="button" class="btn btn-danger btn-exec-script-2 no-clickable">Запуск скрипта №2</button>
		<button type="submit" value="" name="submit" class="btn btn-success btn-submit no-clickable btn-loading">Сохранить</button>
	</div>
<?=form_close();?>