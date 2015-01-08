<?
$years = array();
if (isset($all_issues) &&!empty($all_issues)):
	foreach($all_issues as $issue):
		$years[$issue['year']] = $issue['year'];
	endforeach;
endif;
?>

<div class="production-years">
	<ul class="production-years-list">
	<?php foreach($years as $year_index => $year):?>
		<li><a <?=($this->input->get('year') == $year_index)?'class="active"':''?> href="<?=site_url(uri_string().'?year='.$year_index);?>"><?=$year_index?></a></li>
	<?php endforeach;?>
	</ul>
</div>