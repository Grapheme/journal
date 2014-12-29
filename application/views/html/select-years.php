<div class="production-years">
	<ul class="production-years-list">
	<?php $year = date("Y");?>
	<?php for($i=$year;$i>=2007;$i--):?>
		<li><a <?=($this->input->get('year') == $i)?'class="active"':''?> href="<?=site_url(uri_string().'?year='.$i);?>"><?=$i?></a></li>
	<?php endfor;?>
	</ul>
</div>