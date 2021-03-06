<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("admin_interface/includes/head");?>
<link rel="stylesheet" href="<?=site_url('css/admin-panel/redactor.css');?>" />
<link rel="stylesheet" href="<?=site_url('css/admin-panel/token-input.css');?>" type="text/css" />
<link rel="stylesheet" href="<?=site_url('css/admin-panel/token-input-facebook.css');?>" type="text/css" />
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
				<ul class="breadcrumb">
					<li><a href="<?=site_url(ADMIN_START_PAGE);?>">Панель управления</a> <span class="divider">/</span></li>
					<li><a href="<?=site_url(ADMIN_START_PAGE.'/publications?issue='.$this->input->get('issue'));?>">Публикации</a> <span class="divider">/</span></li>
					<li class="active">Редактирование публикации</li>
				</ul>
				<div class="clear"></div>
				<?php $this->load->view('admin_interface/forms/manage-publications/edit');?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('js/vendor/redactor.min.js');?>"></script>
	<script type="text/javascript" src="<?=site_url('js/cabinet/redactor-config.js');?>"></script>
	<script type="text/javascript" src="<?=site_url('js/vendor/jquery.tokeninput.js');?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input.authors-list").tokenInput(mt.getBaseURL('search-authors-list'),{
				prePopulate:[
				<?php for($i=0;$i<count($authors);$i++):?>
					{id:<?=$authors[$i]['id'];?>, name: "<?=$authors[$i]['name'];?>"}<?php if(isset($authors[$i+1])):?>,<?php endif;?>
				<?php endfor;?>
				],
				theme: "facebook",
				hintText: "Введите слово для поиска",
				noResultsText: "Ничего не найдено",
				searchingText: "Поиск...",
			});
		});
	</script>
</body>
</html>