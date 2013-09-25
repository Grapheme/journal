<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("admin_interface/includes/head");?>

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
					<li class="active">Авторы</li>
				</ul>
				<div class="clear"></div>
				<div class="inline">
					<a href="<?=site_url(ADMIN_START_PAGE.'/authors/add')?>" class="btn btn-info">Добавить автора</a>
				</div>
				<h2>Авторы</h2>
				<?php $this->load->view('html/multy-search-form',array('form_action'=>uri_string(),'search_action'=>'search-authors-list')); ?>
				<?=$pages;?>
				<table class="table table-bordered table-striped table-hover table-condensed" data-action="<?=site_url(ADMIN_START_PAGE.'/authors/remove');?>">
					<thead>
						<tr>
							<th class="span6">Имя автора</th>
							<th class="span2"></th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($authors);$i++):?>
						<tr>
							<td><?=$authors[$i]['ru_name'].' ('.$authors[$i]['en_name'].')';?></td>
							<td>
								<a <?=($this->input->get('search') != '' && count($authors) > 1)?'target="_blank"':''?> href="<?=site_url(ADMIN_START_PAGE.'/authors/edit?mode=text&id='.$authors[$i]['id'])?>" class="btn btn-link" ><i class="icon-pencil"></i></a>
								<button data-item="<?=$authors[$i]['id'];?>" class="btn btn-link remove-item"><i class="icon-remove"></i></button>
							</td>
						</tr>
					<?php endfor;?>
					</tbody>
				</table>
				<?=$pages;?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	
	<script type="text/javascript" src="<?=site_url('js/vendor/jquery.tokeninput.js');?>"></script>
	<script type="text/javascript" src="<?=site_url('js/cabinet/token-config.js');?>"></script>
</body>
</html>