<header>
	<div class="logo">
		<div class="logo-icon"><a href="<?=site_url();?>"></a></div>
	</div>
	<div class="r-head-content clearfix">
		<?php $this->load->view('guests_interface/includes/languages');?>
	<?php if(uri_string()== ''):?>
		<div class="issue">
			<a href="#">
				<span class="issue-text">Выпуск №</span>
				<span class="issue-num"><?=$issue_number;?></span>
			</a>
		</div>
	<?php endif;?>
	</div>
</header>