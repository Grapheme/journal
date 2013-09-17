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
					<li class="active">Публикации</li>
				</ul>
				<div class="clear"></div>
				<div class="inline">
					<?php $this->load->view('html/select-issues');?>
					<?php if($this->input->get('issue') !== FALSE):?>
					<a href="<?=site_url(ADMIN_START_PAGE.'/publications/add?issue='.$this->input->get('issue'))?>" class="btn add-btn btn-info">Добавить публикацию</a>
					<?php endif;?>
				</div>
				<h2>Публикации</h2>
				<table class="table table-bordered table-striped table-hover table-condensed" data-action="<?=site_url(ADMIN_START_PAGE.'/publications/remove');?>">
					<thead>
						<tr>
							<th class="span1">№</th>
							<th class="span6">Название</th>
							<th class="span2"></th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($publications);$i++):?>
						<tr>
							<td><?=$publications[$i]['id'];?></td>
							<td><?=$publications[$i]['ru_title'].' ('.$publications[$i]['en_title'].')';?></td>
							<td>
								<a href="<?=site_url(ADMIN_START_PAGE.'/publications/edit?issue='.$this->input->get('issue').'&id='.$publications[$i]['id'])?>" class="btn btn-link" ><i class="icon-pencil"></i></a>
								<a href="<?=site_url(ADMIN_START_PAGE.'/publications/resources?mode=files&issue='.$this->input->get('issue').'&publication='.$publications[$i]['id'])?>" title="Дополнительные материалы" class="btn btn-link" ><i class="icon-list"></i></a>
								<button data-item="<?=$publications[$i]['id'];?>" class="btn btn-link remove-item"><i class="icon-remove"></i></button>
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
	<script type="text/javascript" src="<?=site_url('js/cabinet/selects.js');?>"></script>
</body>
</html>