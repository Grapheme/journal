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
		<?php 
			if(!isset($issue_number) || is_null($issue_number)):
				$issue_number = FALSE;
			endif;
		?>
		<?php $this->load->view('guests_interface/includes/header',array('issue_number'=>$issue_number));?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<?=(isset($page_content[$this->uri->language_string.'_content']))?$page_content[$this->uri->language_string.'_content']:'';?>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>