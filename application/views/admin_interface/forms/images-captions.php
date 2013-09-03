<ul class="resources-items clearfix" data-action="<?=site_url(ADMIN_START_PAGE.'/collection/caption/resource');?>">
<?php for($i=0;$i<count($images);$i++):?>
	<li class="span2">
		<img class="img-rounded" src="<?=site_url($images[$i]['thumbnail'])?>" alt="">
		RU:<input type="text" name="ru_caption" class="image-ru-caption" value="<?=$images[$i]['ru_caption'];?>" />
		EN:<input type="text" name="en_caption" class="image-en-caption" value="<?=$images[$i]['en_caption'];?>" />
		<input type="text" name="number" class="span1 image-number" value="<?=$images[$i]['number'];?>" />
		<button data-item="<?=$images[$i]['id'];?>" class="btn btn-info btn-image-caption"><i class="icon-ok"></i></button>
	</li>
<?php endfor;?>
</ul>