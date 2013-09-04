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
			<div class="alphabet">
				<?=$this->load->helper('text');?>
				<ul class="alphabet-list">
			<?php for($i=1040;$i<=1071;$i++):?>
				<?php if(array_search($i,array(1049,1066,1067)) === FALSE):?>
					<li class="alphabet-item"><a data-code="<?=$i;?>" href="#"><?=unichr($i);?></a>
				<?php endif;?>
			<?php endfor;?>
				</ul>
				<ul class="alphabet-list-eng">
				<?php for($i=65;$i<91;$i++):?>
					<li class="alphabet-item"><a data-code="<?=$i;?>" href="#"><?=unichr($i);?></a>
				<?php endfor;?>
				</ul>
			</div>
		<?php if(!empty($keywords)):?>
			<div class="authors-full-list clearfix">
				<div class="left">
					<ul>
					<?php for($i=0;$i<(count($keywords)/2);$i++):?>
						<li><a href="#"><?=$$keywords[$i]['name'];?></a></li>
					<?php endfor;?>
					</ul>
				</div>
				<div class="right">
					<ul>
					<?php for($i=(count($keywords)/2);$i<count($keywords);$i++):?>
						<li><a href="#"><?=$keywords[$i]['name'];?></a></li>
					<?php endfor;?>
					</ul>
				</div>
			</div>
		<?php endif;?>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>