<div class="authors-full-list clearfix">
	<div class="left">
		<ul>
		<?php for($i=0;$i<round((count($keywords)/2));$i++):?>
			<li><a href="<?=site_url('search/'.$keywords[$i]['id']);?>"><?=$keywords[$i]['word'];?></a></li>
		<?php endfor;?>
		</ul>
	</div>
	<div class="right">
		<ul>
		<?php for($i=round((count($keywords)/2));$i<count($keywords);$i++):?>
			<li><a href="<?=site_url('search/'.$keywords[$i]['id']);?>"><?=$keywords[$i]['word'];?></a></li>
		<?php endfor;?>
		</ul>
	</div>
</div>