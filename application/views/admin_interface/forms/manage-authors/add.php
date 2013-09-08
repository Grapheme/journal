<?=form_open(ADMIN_START_PAGE.'/authors/insert',array('class'=>'form-manage-authors')); ?>
	<ul id="ProductTab" class="nav nav-tabs">
		<li class="active"><a href="#ru" data-toggle="tab">Русский</a></li>
		<li><a href="#en" data-toggle="tab">English</a></li>
	</ul>
	<div id="ProductTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="ru">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="ru_page_title" class="span6" value="" placeholder="Title страницы" />
				<label>Description:</label>
				<textarea class="span6" name="ru_page_description" placeholder="Description страницы"></textarea>
				<label>H1: </label>
				<input type="text" name="ru_page_h1" class="span6" value="" placeholder="H1 страницы" />
			</div>
			<div class="control-group">
				<label>Имя:</label>
				<input type="text" name="ru_name" class="span3" value="" placeholder="Имя" />
				<label>Должность:</label>
				<input type="text" name="ru_position" class="span3" value="" placeholder="Должность" />
				<label>Адрес:</label>
				<textarea rows="2" class="span6" name="ru_address" placeholder="Адрес"></textarea>
			</div>
		</div>
		<div class="tab-pane fade" id="en">
			<div class="control-group">
				<label>Title: </label>
				<input type="text" name="en_page_title" class="span6" value="" placeholder="Title page" />
				<label>Description:</label>
				<textarea class="span6" name="en_page_description" placeholder="Description page"></textarea>
				<label>H1: </label>
				<input type="text" name="en_page_h1" class="span6" value="" placeholder="H1 page" />
			</div>
			<div class="control-group">
				<label>Name:</label>
				<input type="text" name="en_name" class="span3" value="" placeholder="Name" />
				<label>Position:</label>
				<input type="text" name="en_position" class="span3" value="" placeholder="Position" />
				<label>Address:</label>
				<textarea rows="2" class="span6" name="en_address" placeholder="Address"></textarea>
			</div>
		</div>
	</div>
	<hr/>
	<div class="control-group">
		<label>Email автора:</label>
		<input type="text" name="email" class="span3 valid-email" value="" placeholder="Email" />
	</div>
	<div class="control-group">
		<label>Учреждение:</label>
		<select name="institution" class="span4">
			<option value="0">Укажите место работы автора</option>
		<?php for($i=0;$i<count($institutions);$i++):?>
			<option value="<?=$institutions[$i]['id']?>"><?=$institutions[$i]['ru_small_title'];?></option>
		<?php endfor;?>
		</select>
	</div>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-success btn-submit no-clickable btn-loading">Добавить</button>
	</div>
<?=form_close();?>