<?php
	$navigation = array('issues','authors','for-authors','search','editorial','keywords','usefull-links');
	$posNav = -1;
	if(array_search(uri_string(),$navigation) !== FALSE):
		$posNav = array_search(uri_string(),$navigation);
	endif;
?>
<nav>
	<ul class="nav-list">
		<li class="nav-item"><a <?=($posNav == 0)?'class="active"':''?> href="<?=site_url('issues');?>">Выпуски</a></li>
		<li class="nav-item"><a <?=($posNav == 1)?'class="active"':''?> href="<?=site_url('authors');?>">Авторы</a></li>
		<li class="nav-item"><a <?=($posNav == 2)?'class="active"':''?> href="<?=site_url('for-authors');?>">Для авторов</a></li>
		<li class="nav-item"><a <?=($posNav == 3)?'class="active"':''?> href="<?=site_url('search');?>">Поиск</a></li>
		<li class="nav-item"><a <?=($posNav == 4)?'class="active"':''?> href="<?=site_url('editorial');?>">Редколлегия</a></li>
		<li class="nav-item"><a <?=($posNav == 5)?'class="active"':''?> href="<?=site_url('keywords');?>">Ключевые слова</a></li>
		<li class="nav-item"><a <?=($posNav == 6)?'class="active"':''?> href="<?=site_url('usefull-links');?>">Полезные ссылки</a></li>
	</ul>
</nav>