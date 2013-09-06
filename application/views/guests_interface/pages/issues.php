<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?php $this->load->view('guests_interface/includes/head');?>
</head>
<body>
	<?php $this->load->view('guests_interface/includes/ie7');?>
	<div class="wrapper">
		<?php $this->load->view('guests_interface/includes/header');?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<?=(isset($page_content[$this->uri->language_string.'_content']))?$page_content[$this->uri->language_string.'_content']:'';?>
			<?php $this->load->view('html/select-years');?>
			<section class="section-all-issues">
				<ul class="month-issues">
				<?php $this->load->helper(array('date','text'));?>
				<?php for($i=0;$i<count($issues);$i++):?>
					<li class="month-issues-item">
						<div class="panel">
							<figure class="front">
								<div><?=lang('issue_number')?><span class="big"><?=$issues[$i]['number']?></span></div>
							</figure>
							<figure class="back">
								<a href="<?=site_url('issue/'.$issues[$i]['year'].'/'.$issues[$i]['month'].'/'.$issues[$i]['id'])?>">
									<div class="back-date">
										<span class="back-month"><?=mb_strtolower(getMonthName($issues[$i]['month'],$this->uri->language_string),'UTF-8');?></span>
										<span class="back-year"><?=$issues[$i]['year']?></span>
										<div class="delicate-design-stroke"></div>
									</div>
									<div class="publications-num"><?=$issues[$i]['publication'].' '.pluralPublications($issues[$i]['publication'],$this->uri->language_string);?></div>
								</a>
							</figure>
						</div>
					</li>
				<?php endfor;?>
				</ul>
			</section>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>