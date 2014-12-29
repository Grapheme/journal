<form action="<?=site_url(uri_string());?>" method="GET" class="search-page-form form-search-publications">
	<div class="form-header"><?=lang('form_search_publication');?></div>
	<input name="text" class="input-search-text" type="text" value="<?=$this->input->get('text');?>" placeholder="<?=lang('form_search_publication');?>">
	<div class="year-select">
		<div class="select-caption"><?=lang('form_search_year');?>:</div>
		<select name="year" class="styled-select">
			<option value="">--</option>
		<?php foreach ($years as $years_index => $year): ?>
			<option value="<?=$years_index;?>" <?=($years_index == $this->input->get('year'))?'selected':'';?>><?=$years_index;?></option>
		<?php endforeach;?>
		</select>
	</div>
	<div class="num-select">
		<div class="select-caption"><?=lang('form_search_number');?>:</div>
		<select name="number" class="styled-select">
			<option value="">--</option>
		<?php foreach ($numbers as $numbers_index => $number): ?>
			<option value="<?=$number;?>"<?=($number == $this->input->get('number'))?'selected':'';?>><?=$number;?></option>
		<?php endforeach;?>
		</select>
	</div>
	<input class="btn-loading btn-submit" type="submit" value="<?=lang('form_search_button');?>">
</form>