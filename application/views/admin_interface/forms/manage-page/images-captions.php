<ul class="resources-items clearfix" data-action="<?=site_url(ADMIN_START_PAGE.'/page/caption/resource');?>">
<?php for($i=0;$i<count($images);$i++):?>
	<li class="span3">
		<img class="img-rounded" src="<?=site_url($images[$i]['thumbnail'])?>" alt=""><br/>
		<label>Подпись:</label><input type="text" name="caption" class="image-caption" value="<?=$images[$i]['caption'];?>" /><br/>
		<label>№ п.п.:</label><input type="text" name="number" class="span1 image-number" value="<?=$images[$i]['number'];?>" />
		<button data-item="<?=$images[$i]['id'];?>" class="btn btn-info btn-images-caption"><i class="icon-ok"></i></button>
	</li>
<?php endfor;?>
</ul>