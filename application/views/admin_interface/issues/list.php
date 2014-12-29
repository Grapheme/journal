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
					<li class="active">Выпуски</li>
				</ul>
				<div class="clear"></div>
				<div class="inline">
					<a href="<?=site_url(ADMIN_START_PAGE.'/issues/add')?>" class="btn btn-info">Добавить выпуск</a>
				</div>
				<h2>Выпуски</h2>
				<?php $this->load->view('html/select-years',array('issues'=>$issues));?>
				<table class="table table-bordered table-striped table-hover table-condensed" data-action="<?=site_url(ADMIN_START_PAGE.'/issues/remove');?>">
					<thead>
						<tr>
							<th class="span1">№</th>
							<th class="span6">Название</th>
							<th class="span2"></th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($issues);$i++):?>
						<tr>
							<td><?=$issues[$i]['id'];?></td>
							<td>
								<a href="<?=site_url(ADMIN_START_PAGE.'/issues/edit?mode=text&id='.$issues[$i]['id'])?>">
									<?=$issues[$i]['ru_title'].' ('.$issues[$i]['en_title'].')';?>
								</a>
							</td>
							<td>
								<a href="<?=site_url(ADMIN_START_PAGE.'/issues/edit?mode=text&id='.$issues[$i]['id'])?>" class="btn btn-link" ><i class="icon-pencil"></i></a>
								<button data-item="<?=$issues[$i]['id'];?>" class="btn btn-link remove-item"><i class="icon-remove"></i></button>
							</td>
						</tr>
					<?php endfor;?>
					</tbody>
				</table>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>