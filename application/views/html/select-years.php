<div class="production-years">
	<ul class="production-years-list">
	<?php $year = date("Y");?>
	<?php for($i=$year;$i>=$year-7;$i--):?>
		<li><a href="<?=site_url(uri_string().'?year='.$i);?>"><?=$i?></a></li>
	<?php endfor;?>
	</ul>
</div>