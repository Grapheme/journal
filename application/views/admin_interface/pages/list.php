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
					<li class="active">Страницы</li>
				</ul>
				<div class="clear"></div>
				<h2>Страницы</h2>
				<blockquote>
					<a href="<?=site_url(ADMIN_START_PAGE.'/pages/add?mode=insert');?>" class="btn btn-small" type="button">Добавить страницу</a>
				</blockquote>
				<table class="table table-bordered" data-action="<?=site_url(ADMIN_START_PAGE.'/pages/remove');?>">
					<thead>
						<tr>
							<th class="span1">№ ID</th>
							<th class="span7">Название</th>
							<th class="span1"></th>
						</tr>
					</thead>
					<tbody>
					<?php for($i=0;$i<count($pages);$i++):?>
						<tr>
							<td><?=$pages[$i]['id'];?></td>
							<td><?=$pages[$i]['title'];?></td>
							<td>
								<a href="<?=site_url(ADMIN_START_PAGE.'/pages/'.$pages[$i]['page_url'].'/edit?mode=text&id='.$pages[$i]['id'])?>" class="btn btn-link" ><i class="icon-edit"></i></a>
							<?php if($pages[$i]['manage'] == 1):?>
								<a href="" data-item="<?=$pages[$i]['id']?>" class="no-clickable btn-remove-page" ><i class="icon-remove"></i></a>
							<?php endif;?>
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