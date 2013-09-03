<form class="search-page-form">
	<div class="form-header">Найти статью</div>
	<input type="text" placeholder="Введите запрос">
	<div class="year-select">
		<div class="select-caption">Год:</div>
		<select name="year" class="styled-select">
			<option value="0" selected>--</option>
		<?php $year = date("Y");?>
		<?php for($i=$year;$i>=$year-7;$i--):?>
			<option value="<?=$i;?>"><?=$i;?></option>
		<?php endfor;?>
		</select>
	</div>
	<div class="num-select">
		<div class="select-caption">Номер:</div>
		<select name="" class="styled-select">
			<option value="0" selected>--</option>
		<?php for($i=1;$i<=12;$i++):?>
			<option value="<?=$i;?>"><?=$i;?></option>
		<?php endfor;?>
		</select>
	</div>
	<input type="submit" value="Искать">
</form>