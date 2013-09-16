<ul class="resources-items clearfix" data-action="<?=site_url(ADMIN_START_PAGE.'/publications/resources/caption');?>">
<?php for($i=0;$i<count($resources);$i++):?>
	<li class="span3">
		<img src="<?=site_url(RUSLAN.'/publications/view-document/'.random_string('alnum',16).'?resource_id='.$resources[$i]['id'])?>" alt="" title="<?=$resources[$i]['resource']['file_name'];?>">
		<label>Подпись:</label><input type="text" name="caption" class="resource-caption" value="<?=$resources[$i]['caption'];?>" /><br/>
		<label>№ п.п.:</label><input type="text" name="number" class="span1 resource-number" value="<?=$resources[$i]['number'];?>" />
		<button data-item="<?=$resources[$i]['id'];?>" class="btn btn-info btn-resources-caption"><i class="icon-ok"></i></button>
	</li>
<?php endfor;?>
</ul>