<?=form_open($form_action,array('class'=>'form-search-suggest','method'=>'GET')); ?>
	<div class="controls">
		<label>Поиск:</label>
		<input type="text" value="" data-search-action="<?=$search_action;?>" class="suggest-searching" name="search" />
		<p class="text-info">Возможен групповой поиск</p>
	</div>
	<div class="div-form-operation">
		<button type="submit" class="btn btn-info btn-suggest-searching">Найти</button>
		<a href="<?=site_url($form_action);?>">Сброс</a>
	</div>
<?=form_close();?>