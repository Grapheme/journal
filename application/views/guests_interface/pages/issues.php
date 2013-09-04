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
		<?php $this->load->view('guests_interface/includes/header',array('issue_number'=>'5/13'));?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<?=(isset($page_content[$this->uri->language_string.'_content']))?$page_content[$this->uri->language_string.'_content']:'';?>
			<div class="production-years">
				<ul class="production-years-list">
				<?php $year = date("Y");?>
				<?php for($i=$year;$i>=$year-7;$i--):?>
					<li><a href="#"><?=$i?></a></li>
				<?php endfor;?>
				</ul>
			</div>
			<section class="section-all-issues">
				<ul class="month-issues">
				<?php for($i=0;$i<count($issues);$i++):?>
					<li class="month-issues-item">
						<div class="panel">
							<figure class="front">
								<div><span class="big"><?=$issues[$i]['number']?></span>номер</div>
							</figure>
							<figure class="back">
								<a href="<?=site_url('issue/'.$issues[$i]['id'])?>">
									<div class="back-date">
										<span class="back-month">декабрь</span>
										<span class="back-year">2013</span>
										<div class="delicate-design-stroke"></div>
									</div>
									<div class="publications-num">6 публикаций</div>
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