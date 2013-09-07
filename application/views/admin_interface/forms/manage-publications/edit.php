<?=form_open(ADMIN_START_PAGE.'/publications/update?issue='.$this->input->get('issue').'&id='.$this->input->get('id'),array('class'=>'form-manage-publications')); ?>
	<ul id="ProductTab" class="nav nav-tabs">
		<li class="active"><a href="#ru" data-toggle="tab">Русский</a></li>
		<li><a href="#en" data-toggle="tab">English</a></li>
	</ul>
	<div id="ProductTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="ru">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="ru_page_title" class="span6" value="<?=$publication['ru_page_title']?>" placeholder="Title страницы" />
				<label>Description:</label>
				<textarea class="span6" name="ru_page_description" placeholder="Description страницы"><?=$publication['ru_page_description']?></textarea>
				<label>H1: </label>
				<input type="text" name="ru_page_h1" class="span6" value="<?=$publication['ru_page_h1']?>" placeholder="H1 страницы" />
			</div>
			<div class="control-group">
				<label>Название:</label>
				<input type="text" name="ru_title" class="span6" value="<?=$publication['ru_title']?>" placeholder="" />
			</div>
			<div class="controls">
				<label>Документ:</label>
				<input type="file" autocomplete="off" name="ru_document" size="52">
				<p class="help-block">Поддерживаются форматы: PDF</p>
			</div>
			<div class="control-group">
				<label>Аннотация:</label>
				<textarea class="redactor" rows="4" name="ru_annotation"><?=$publication['ru_annotation']?></textarea>
				<label>При поддержке:</label>
				<textarea class="redactor" rows="4" name="ru_support"><?=$publication['ru_support']?></textarea>
				<label>Библиографический список:</label>
				<textarea class="redactor" rows="4" name="ru_bibliography"><?=$publication['ru_bibliography']?></textarea>
			</div>
		</div>
		<div class="tab-pane fade" id="en">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="en_page_title" class="span6" value="<?=$publication['en_page_title']?>" placeholder="Title page" />
				<label>Description:</label>
				<textarea class="span6" name="en_page_description" placeholder="Description page"><?=$publication['en_page_description']?></textarea>
				<label>H1: </label>
				<input type="text" name="en_page_h1" class="span6" value="<?=$publication['en_page_h1']?>" placeholder="H1 page" />
			</div>
			<div class="control-group">
				<label>Title:</label>
				<input type="text" name="en_title" class="span6" value="<?=$publication['en_title']?>" placeholder="" />
			</div>
			<div class="controls">
				<label>Documenet:</label>
				<input type="file" autocomplete="off" name="en_document" size="52">
				<p class="help-block">Supported formats: PDF</p>
			</div>
			<div class="control-group">
				<label>Annotation:</label>
				<textarea class="redactor redactor-row4" name="en_annotation"><?=$publication['en_annotation']?></textarea>
				<label>With support:</label>
				<textarea class="redactor redactor-row4" name="en_support"><?=$publication['en_support']?></textarea>
				<label>Bibliographic list:</label>
				<textarea class="redactor redactor-row4" name="en_bibliography"><?=$publication['en_bibliography']?></textarea>
			</div>
		</div>
	</div>
	<div class="controls">
		<label>Номер страницы:</label>
		<input type="text" name="page" class="span1 valid-numeric" value="<?=$publication['page']?>" placeholder="Номер страницы" />
		<label>Ключевые слова:</label>
		<input type="text" name="keywords" class="span9" value="<?=$publication['keywords'];?>" placeholder="Введите ключевые слова через запятую" />
		<label>Авторы:</label>
		<input type="text" value="" class="span6 authors-list" name="authors" />
		<p>Вводить только на русском языке</p>
	</div>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-success btn-publication-submit no-clickable btn-loading">Сохранить</button>
	</div>
<?=form_close();?>