<form action="<?=site_url(uri_string());?>" method="GET" class="search-page-form form-search-publications">
	<div class="form-header"><?=lang('form_search_publication');?></div>
	<input name="text" class="input-search-text" type="text" value="<?=$this->input->get('text');?>" placeholder="<?=lang('form_search_publication');?>">
	<div class="year-select">
		<div class="select-caption"><?=lang('form_search_year');?>:</div>
		<select name="year" class="styled-select">
			<option value="">--</option>
		<?php $year = date("Y");?>
		<?php for($i=$year;$i>=2007;$i--):?>
			<option value="<?=$i;?>" <?=($i == $this->input->get('year'))?'selected':'';?>><?=$i;?></option>
		<?php endfor;?>
		</select>
	</div>
	<div class="num-select">
		<div class="select-caption"><?=lang('form_search_number');?>:</div>
		<select name="number" class="styled-select">
			<option value="">--</option>
		<?php for($i=1;$i<=12;$i++):?>
			<option value="<?=$i;?>"<?=($i == $this->input->get('number'))?'selected':'';?>><?=$i;?></option>
		<?php endfor;?>
		</select>
	</div>
	<input class="btn-loading btn-submit" type="submit" value="<?=lang('form_search_button');?>">
</form>