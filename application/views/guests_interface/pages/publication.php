<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?php $this->load->view('guests_interface/includes/head');?>
	<link href="<?=BaseURL('css/bootstrap.css');?>" rel="stylesheet" />
</head>
<body>
	<?php $this->load->view('guests_interface/includes/ie7');?>
	<div class="wrapper">
		<?php $this->load->view('guests_interface/includes/header');?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
			<header>
				<h1 class="article-h1"><?=mb_strtoupper(getMonthName($issue['month'],$this->uri->language_string));?>. <?=$issue['year'];?></h1>
				<div class="delicate-design-stroke"> </div>
			<?php if(empty($page_content[$this->uri->language_string.'_document']) === FALSE):?>
				<div class="pdf-dl-link single">
					<a href="<?=site_url('publication/get-publication?resourse='.$page_content['id']);?>">
						<img src="<?=BaseURL('img/pdf.png');?>"><?=lang('publication_download');?>
					</a>
				</div>
			<?php endif;?>
				<h2 class="article-h2"><?=$page_content[$this->uri->language_string.'_title']?></h2>
				<div class="desc">
					<?=$page_content[$this->uri->language_string.'_annotation'];?>
				</div>
			</header>
			<?php if(!empty($authors)):?>
			<div class="authors">
			<?php for($j=0;$j<count($authors);$j++):?>
				<a href="<?=site_url('author/'.getTranslit($authors[$j][$this->uri->language_string.'_name']).'/'.$authors[$j]['id']);?>"><?=$authors[$j][$this->uri->language_string.'_name'];?></a><?php if(isset($authors[$j+1])):?>, <?php endif;?>
			<?php endfor;?>
			</div>
			<?php endif;?>
			<div class="biblio-link">
				<strong><?=lang('bibliography_link')?></strong>: <?php for($j=0;$j<count($authors);$j++):?><?=$authors[$j][$this->uri->language_string.'_name'];?><?php if(isset($authors[$j+1])):?>, <?php endif;?><?php endfor;?> //<?=$page_content[$this->uri->language_string.'_title']?> – <?=$issue['year'];?>. - № <?=$issue['number'];?>. – <?=$page_content['page']?> <?=lang('page_char')?>.
				– <?=lang('ejournal');?>. – <?=site_url(uri_string())?><a class="no-clickable" href=""> [B<span class="capital">ib</span>T<span class="lower">E</span>X]</a>
			</div>
			<?php if(!empty($keywords)):?>
			<div class="key-words">
				<strong><?=lang('key_words')?></strong>: 
			<?php for($i=0;$i<count($keywords);$i++):?>
				<a href="<?=site_url('search/publication?mode=search&word='.md5(trim($keywords[$i])))?>"><?=$keywords[$i];?></a><?php if(isset($keywords[$i+1])):?>,<?php endif;?> 
			<?php endfor;?>
			</div>
			<?php endif;?>
			<?php if(!empty($publication_resources)):?>
			<section>
				<header>
					<h3><?=lang('publication_materials')?></h3>
				</header>
				<ul class="unord-list">
				<?php for($i=0;$i<count($publication_resources);$i++):?>
					<li class="unord-item clearfix">
						<div class="list-item-icon"> <!--video audio text-->
							<img class="" src="<?=site_url('publications/view-document/'.random_string('alnum',16).'?resource_id='.$publication_resources[$i]['id']);?>" alt="" />
							<a href="<?=site_url('publication/get-resource?resourse='.$publication_resources[$i]['id'])?>"></a>
						</div>
						<div class="list-item-desc">
							<div class="list-item-name"><?=$publication_resources[$i]['resource']['file_name'];?></div>
							<div class="list-item-name"><?=$publication_resources[$i]['caption'];?></div>
							<a href="<?=site_url('publication/get-resource?resourse='.$publication_resources[$i]['id']);?>" class="list-dl-link">скачать</a>
						</div>
					</li>
				<?php endfor;?>
				</ul>
			</section>
			<?php endif;?>
			<?php if(!empty($page_content[$this->uri->language_string.'_support'])):?>
			<section>
				<header>
					<h3><?=lang('with_support');?></h3>
				</header>
				<?=$page_content[$this->uri->language_string.'_support'];?>
			</section>
			<?php endif;?>
			<?php if(!empty($page_content[$this->uri->language_string.'_bibliography'])):?>
			<section>
				<header>
					<h3><?=lang('bibliography');?></h3>
				</header>
				<?=$page_content[$this->uri->language_string.'_bibliography'];?>
			</section>
			<?php endif;?>
			<section class="comments-section">
				<header>
					<h3><?=lang('comments_to_publication')?></h3>
				</header>
				<div class="comments">
					<?php $this->load->view('html/social-networks');?>
					<?php $this->load->view('guests_interface/forms/comments');?>
					<ul class="comments-list ul-publication-comments-list">
					<?php for($i=0;$i<count($comments);$i++):?>
						<?php $this->load->view('html/comments-list',array('comment'=>$comments[$i]));?>
						<?php if(isset($comments[$i]['sub_comments']) && !empty($comments[$i]['sub_comments'])):?>
							<?php for($j=0;$j<count($comments[$i]['sub_comments']);$j++):?>
								<?php $this->load->view('html/comments-answer-list',array('comment'=>$comments[$i]['sub_comments'][$j]));?>
							<?php endfor;?>
						<?php endif;?>
					<?php endfor;?>
					</ul>
				</div>
			</section>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<script type="text/javascript" src="<?=baseURL('js/vendor/jquery.form.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/libs/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/libs/upload-document.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/libs/localize.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/libs/base.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/cabinet/guest.js');?>"></script>
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>