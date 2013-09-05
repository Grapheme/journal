<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?php $this->load->view('guests_interface/includes/head');?>
	<link rel="stylesheet" href="<?=baseURL('css/styled-select.css');?>" />
</head>
<body>
	<?php $this->load->view('guests_interface/includes/ie7');?>
	<div class="wrapper">
		<?php $this->load->view('guests_interface/includes/header',array('issue_number'=>'5/13'));?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<?=(isset($page_content[$this->uri->language_string.'_content']))?$page_content[$this->uri->language_string.'_content']:'';?>
			<?php $this->load->view('guests_interface/forms/search');?>
		<?php if(!empty($issues)):?>
			<div class="search-page-form">
				<div class="form-header">Результаты поиска</div>
				<div class="publications-num">Найдено публикаций: <?=count($issues);?></div>
			</div>
			<ol class="month-list search-page">
			<?php for($i=0;$i<count($issues);$i++):?>
				<li>
					<div class="pdf-dl-link">
						<a href=""><img src="<?=base_url('img/pdf.png')?>">Скачать</a>
					</div>
					<h2 class="article-h2">
						<a href="<?=site_url('issue/'.$issues[$i]['id']);?>"><?=$issues[$i]['title']?></a>
					</h2>
					<div class="publications-date">
						<?=$issues[$i]['date'];?>
					</div>
					<div class="authors">
					<?php for($j=0;$j<count($issues[$i]['authors']);$j++):?>
						<?=$issues[$i]['authors'][$j]['name'];?><?=(isset($issues[$i]['authors'][$j+1]))?',':'';?>
					<?php endfor;?>
					</div>
				</li>
			<?php endfor;?>
			</ol>
		<?php endif;?>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<script src="<?=baseURL('js/vendor/jquery.customSelect.min.js');?>"></script>
	<script src="<?=baseURL('js/cabinet/styled-select-init.js');?>"></script>	
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>