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
			<header>
				<h1 class="article-h1">Поиск</h1>
				<div class="delicate-design-stroke"></div>
			</header>
			<?php $this->load->view('guests_interface/forms/search');?>
		<?php if(!empty($issues)):?>
			<div class="search-page-form">
				<div class="form-header">Результаты поиска</div>
				<div class="publications-num">Найдено публикаций: <?=count($issues);?></div>
			</div>
			<ul class="month-list search-page">
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
			</ul>
		<?php endif;?>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>