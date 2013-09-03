<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("admin_interface/includes/head");?>
<link rel="stylesheet" href="<?=base_url('css/admin-panel/uploadzone.css');?>" />
</head>
<body>
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
	<?php $this->load->view("admin_interface/includes/navbar");?>
	<div class="container">
		<div class="row">
			<div class="span3">
				<?php $this->load->view("admin_interface/includes/sidebar");?>
			</div>
			<div class="span9">
				<?php $this->load->view('admin_interface/includes/nav-tab-edit-banners');?>
				<?php if($this->input->get('mode')=='image'):?>
				<?php $this->load->view('admin_interface/forms/manage-page/banners-image');?>
				<?php elseif($this->input->get('mode')=='caption'):?>
				<?php $this->load->view('admin_interface/forms/manage-page/banners-caption');?>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
<?php if($this->input->get('mode')=='image'):?>
	<script type="text/javascript" src="<?=site_url('js/libs/dropzone.js');?>"></script>
<?php endif;?>
</body>
</html>