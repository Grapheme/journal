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
		<h1 class="article-h1">Фазовые переходы, упорядоченные состояния и новые материалы</h1>
		<div class="desc">
		Журнал «Фазовые переходы, упорядоченные состояния и новые материалы» - первый в России электронный журнал, посвященный широкому кругу вопросов из области физики конденсированных сред. 
		В нем публикуются результаты оригинальных исследований и обзоры, посвященные актуальным прикладным и фундаментальным вопросам по темам:     				
		</div>
		</header>
		<div class="themes"> 
		<ul class="themes-list">
		<li class="themes-item">Динамика и устойчивость кристаллической решетки
		<li class="themes-item">Магнетизм. Сегнетоэлектричество мультиферроики
		<li class="themes-item">Сверхпроводимость
		<li class="themes-item">Кристаллохимия, теория кристаллических структур
		<li class="themes-item">Теория фазовых диаграмм
		<li class="themes-item">Свойства металлов и сплавов
		<li class="themes-item">Фазовые переходы плавления и кристаллизации
		<li class="themes-item">Напряженные состояния и пластичность
		<li class="themes-item">Дефекты, дислокации, диффузия. Физика прочности
		<li class="themes-item">Низкоразмерные системы, физика поверхности
		<li class="themes-item">Полимеры, жидкие кристаллы
		<li class="themes-item">Электронные свойства твердых тел
		<li class="themes-item">Атомные кластеры, фуллерены
		</ul>
		</div>
		<div class="freq-div">
		<p>
		Периодичность журнала в свет - ежемесячно. Учредителем является Институт физики Южного федерального университета.
		</p>
		</div>
		</article>
		<footer>
		<div class="footer-content">
		<div class="delicate-design-stroke">
		</div>	
		<div class="issn">
		ISSN 2073-0373
		</div>
		<div class="massm-sert">
		<a href="#">Свидетельство регистрации СМИ</a>
		</div>
		<div class="age">
		<p>0+</p>
		</div>       
		</div> 		
		</footer>
	</div>

	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>