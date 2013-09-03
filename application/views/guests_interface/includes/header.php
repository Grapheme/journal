<header>
	<div class="logo">
		<div class="logo-icon"><a href="<?=site_url();?>"></a></div>
	</div>
	<div class="r-head-content clearfix">
		<div class="lang">
			<ul class="lang-list">
				<li class="lang-item"><a class="active" href="#">Ru</a></li>
				<li class="lang-item"><a href="#">En</a></li>
			</ul>
		</div>
	<?php if(uri_string()== ''):?>
		<div class="issue">
			<div class="issue-text">Выпуск №</div>
			<div class="issue-num"><?=$issue_number;?></div>
		</div>
	<?php endif;?>
	</div>
</header>