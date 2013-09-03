<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?php $this->load->view('guests_interface/includes/head');?>
	<link rel="stylesheet" href="<?=base_url('css/fotorama.css')?>" />
</head>
<body>
	<!--[if lt IE 7]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->
	<div class="wrapper">
		<div class="main clearfix">
			<?php $this->load->view('guests_interface/includes/bag-block');?>
			<div class="texture-left"></div>
			<div class="texture-right"></div>
			<div class="main-container">
				<?php $this->load->view('guests_interface/includes/small-menu');?>
				<?php $this->load->view('guests_interface/includes/header');?>
				<?php $this->load->view('guests_interface/includes/navigation');?>
				<div class="fotorama_container"> 
					<div class="fotorama" data-width="100%" data-height="282px" data-fit="scale-down">
					<?php for($i=0;$i<count($banners);$i++):?>
						<div class="fotorama-div" data-img="<?=base_url($banners[$i]['resource'])?>">
						<?php if(!empty($banners[$i]['product'])):?>
							<a href="<?=$banners[$i]['product'];?>" class="add-to-cart-btn">Узнать подробнее</a>
						<?php endif;?>
						</div>
					<?php endfor;?>
					</div>
				</div>
				<?php $this->load->view('guests_interface/includes/categories');?>
			</div>
			<div class="map-where-2-buy">
				<div class="header_bg">
		        		<h2 class="map-header">
							ГДЕ КУПИТЬ
						</h2>
					</div>
				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
	<?php $this->load->view('guests_interface/includes/small-footer');?>
	<?php $this->load->view('guests_interface/includes/footer');?>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<script type="text/javascript" src="<?=base_url('js/vendor/fotorama.js');?>"></script>
	<script type="text/javascript" src="<?=base_url('js/libs/fotorama-config.js');?>"></script>
	<?php $this->load->view('guests_interface/includes/points_sale_map');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>