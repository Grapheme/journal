<?php
	$navigation = array('issues','');
	if(array_search(uri_string(),$navigation) !== FALSE):
		$posNav = array_search(uri_string(),$navigation);
	endif;
?>
<nav>
	<ul class="nav-list">
		<li class="nav-item"><a <?=($posNav == 0)?'class="active"':''?> href="<?=site_url('issues');?>">Выпуски</a></li>
		<li class="nav-item"><a <?=($posNav == 1)?'class="active"':''?> href="<?=site_url('authors');?>">Авторы</a></li>
		<li class="nav-item"><a <?=($posNav == 2)?'class="active"':''?> href="<?=site_url('issues');?>">Для авторов</a></li>
		<li class="nav-item"><a <?=($posNav == 3)?'class="active"':''?> href="<?=site_url('issues');?>">Поиск</a></li>
		<li class="nav-item"><a <?=($posNav == 4)?'class="active"':''?> href="<?=site_url('issues');?>">Редколлегия</a></li>
		<li class="nav-item"><a <?=($posNav == 5)?'class="active"':''?> href="<?=site_url('issues');?>">Ключевые слова</a></li>
		<li class="nav-item"><a <?=($posNav == 6)?'class="active"':''?> href="<?=site_url('issues');?>">Полезные ссылки</a></li>
	</ul>
</nav>