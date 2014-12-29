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
				<h1 class="article-h1"><?=$page_content[$this->uri->language_string.'_page_h1'];?></h1>
				<div class="delicate-design-stroke"> </div>
				<ol class="month-list">
				<?php foreach((array)$publications as $publication):?>
					<li>
					<?php if(empty($publication[$this->uri->language_string.'_document']) === FALSE):?>
						<div class="pdf-dl-link">
							<a href="<?=site_url('publication/get-publication?resourse='.$publication['id']);?>">
								<img src="<?=BaseURL('img/pdf.png');?>"><?=lang('publication_download');?>
							</a>
						</div>
					<?php endif;?>
						<h2 class="article-h2">
							<a href="<?=site_url('issue/publication/'.$publication['id'].'-'.getTranslit($publication[$this->uri->language_string.'_title']))?>"><?=$publication[$this->uri->language_string.'_title']?></a>
						</h2>
						<div class="authors">
						<?php for($j=0;$j<count($publication['authors']);$j++):?>
							<a href="<?=site_url('author/'.getTranslit($publication['authors'][$j][$this->uri->language_string.'_name']).'/'.$publication['authors'][$j]['id']);?>"><?=getInitials($publication['authors'][$j][$this->uri->language_string.'_name']);?></a><?php if(isset($publication['authors'][$j+1])):?>, <?php endif;?>
						<?php endfor;?>
						</div>
					</li>
				<?php endforeach;?>
				</ol>
			</header>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>