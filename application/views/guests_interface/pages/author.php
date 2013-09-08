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
		<?php $this->load->view('guests_interface/includes/header');?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<header>
				<h1 class="article-h1"><?=lang('author')?></h1>
				<div class="delicate-design-stroke"></div>
			</header>
			<section class="author">
				<header>
					<h2 class="article-h2"><?=$page_content[$this->uri->language_string.'_name'];?></h2>
				</header>
				<div>
					<?=$page_content[$this->uri->language_string.'_position'];?>
				</div>
				<div>
					<span class="gray"><?=$page_content['institution'][$this->uri->language_string.'_title'];?></span> 
				</div>
				<address>
					<?=$page_content[$this->uri->language_string.'_address'];?>
				</address>
				<a href="mailto:alexa@irinoch.irk.ru"><?=safe_mailto($page_content['email'],$page_content['email'])?></a>
				<div class="go-to-author-pubs">
					<a href="<?=site_url('search?author='.$page_content['id']);?>"><?=lang('all_publication_authors');?></a>
				</div>
			</section>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>