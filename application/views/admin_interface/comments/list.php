<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("admin_interface/includes/head");?>
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
					<li class="active">Комментарии</li>
				</ul>
				<div class="clear"></div>
				<?php $this->load->view('html/select-issues');?><br/>
				<?php $this->load->view('html/select-publications');?>
				<h2>Комментарии</h2>
				<?=$pages;?>
				<table class="table table-bordered table-striped table-hover table-condensed" data-action="<?=site_url(ADMIN_START_PAGE.'/comment/remove');?>">
					<thead>
						<tr>
							<th>Дата</th>
							<th>Выпуск</th>
							<th>Статья</th>
							<th>Содержание</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($comments);$i++):?>
						<tr>
							<td><?=swapDotDateWithTime($comments[$i]['date'])?></td>
							<td><?=$comments[$i]['issue_title'];?></td>
							<td><?=$comments[$i]['publication_title'];?></td>
							<td><?=word_limiter($comments[$i]['comment'],40);?></td>
							<td>
								<a href="<?=site_url('ru/issue/'.$comments[$i]['year'].'/'.$comments[$i]['month'].'/'.$comments[$i]['id'].'/publication/'.$comments[$i]['publication'].'#comments')?>" class="btn btn-link" target="_blank" ><i class="icon-eye-open"></i></a>
								<a href="<?=site_url(ADMIN_START_PAGE.'/comments/edit?id='.$comments[$i]['id'])?>" class="btn btn-link" ><i class="icon-pencil"></i></a>
								<button data-item="<?=$comments[$i]['id'];?>" class="btn btn-link remove-item"><i class="icon-remove"></i></button>
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
	<script type="text/javascript" src="<?=site_url('js/cabinet/selects.js');?>"></script>
</body>
</html>