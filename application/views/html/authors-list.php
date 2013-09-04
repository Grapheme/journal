<div class="authors-full-list clearfix">
	<div class="left">
		<ul>
		<?php for($i=0;$i<round((count($authors)/2));$i++):?>
			<li><a href="<?=site_url('author/'.getTranslit($authors[$i][$langName.'_name']).'/'.$authors[$i]['id']);?>"><?=$authors[$i][$langName.'_name'];?></a></li>
		<?php endfor;?>
		</ul>
	</div>
	<div class="right">
		<ul>
		<?php for($i=round((count($authors)/2));$i<count($authors);$i++):?>
			<li><a href="<?=site_url('author/'.getTranslit($authors[$i][$langName.'_name']).'/'.$authors[$i]['id']);?>"><?=$authors[$i][$langName.'_name'];?></a></li>
		<?php endfor;?>
		</ul>
	</div>
</div>