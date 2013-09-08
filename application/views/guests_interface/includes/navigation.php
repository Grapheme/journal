<?php
	$navigation = array('','issues','authors','for-authors','search','editorial','keywords','usefull-links','institutions');
	$posNav = -1;
	if(array_search(uri_string(),$navigation) !== FALSE):
		$posNav = array_search(uri_string(),$navigation);
	endif;
?>
<nav>
	<ul class="nav-list">
		<li class="nav-item"><a <?=($posNav == 0)?'class="active"':''?> href="<?=site_url('');?>"><?=lang('menu_home');?></a></li>
		<li class="nav-item"><a <?=($posNav == 1)?'class="active"':''?> href="<?=site_url('issues');?>"><?=lang('menu_issues');?></a></li>
		<li class="nav-item separator">&nbsp;</li>
		<li class="nav-item"><a <?=($posNav == 3)?'class="active"':''?> href="<?=site_url('for-authors');?>"><?=lang('menu_for_authors');?></a></li>
		<li class="nav-item"><a <?=($posNav == 5)?'class="active"':''?> href="<?=site_url('editorial');?>"><?=lang('menu_editorial');?></a></li>
		<li class="nav-item"><a <?=($posNav == 7)?'class="active"':''?> href="<?=site_url('usefull-links');?>"><?=lang('menu_usefull_links');?></a></li>
		<li class="nav-item separator">&nbsp;</li>		
		<li class="nav-item"><a <?=($posNav == 2)?'class="active"':''?> href="<?=site_url('authors');?>"><?=lang('menu_authors');?></a></li>
		<li class="nav-item"><a <?=($posNav == 6)?'class="active"':''?> href="<?=site_url('keywords');?>"><?=lang('menu_keywords');?></a></li>
		<li class="nav-item"><a <?=($posNav == 4)?'class="active"':''?> href="<?=site_url('search');?>"><?=lang('menu_search');?></a></li>		
		<!--li class="nav-item"><a <?=($posNav == 8)?'class="active"':''?> href="<?=site_url('institutions');?>"><?=lang('menu_institutions');?></a></li-->
	</ul>
</nav>