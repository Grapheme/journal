<header>
	<div class="logo">
		<div class="logo-icon"><a href="<?=site_url();?>"></a></div>
	</div>
	<div class="r-head-content clearfix">
		<?php $this->load->view('guests_interface/includes/languages');?>
	<?php if(uri_string()== '' && $issue_number !== FALSE):?>
		<div class="issue">
			<a href="<?=$issue_link;?>">
				<div class="issue-text">Выпуск №</div>
				<div class="issue-num"><?=$issue_number;?></div>
			</a>
		</div>
	<?php endif;?>
	</div>
</header>