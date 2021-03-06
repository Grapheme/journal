<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<?php $this->load->view('guests_interface/includes/head');?>
	<link rel="stylesheet" href="<?=baseURL('css/styled-select.css');?>" />
</head>
<body>
	<?php $this->load->view('guests_interface/includes/ie7');?>
	<div class="wrapper">
		<?php $this->load->view('guests_interface/includes/header');?>
		<?php $this->load->view('guests_interface/includes/navigation');?>
		<article>
	<?php if($this->input->get('author') === FALSE && $this->input->get('word') === FALSE):?>
			<?=(isset($page_content[$this->uri->language_string.'_content']))?$page_content[$this->uri->language_string.'_content']:'';?>
			<?php $this->load->view('guests_interface/forms/search');?>
	<?php endif;?>
		<?php if(!empty($publications)):?>
			<div class="search-page-form">
				<div class="form-header">
			<?php if($this->input->get('author') === FALSE && $this->input->get('word') === FALSE):?>
				<?=lang('form_search_results');?>
			<?php elseif($this->input->get('author') === FALSE && $this->input->get('word') != '' && !is_array($search_text)):?>
				<?=$search_text;?>
			<?php elseif($this->input->get('word') === FALSE && $this->input->get('author') != '' && is_array($search_text)):?>
				<?=$search_text[$this->uri->language_string.'_name'];?>
			<?php endif;?>
				</div>
				<div class="publications-num"><?=lang('form_search_found');?>: <?=count($publications).' '.pluralPublications(count($publications),$this->uri->language_string);?>.</div>
			</div>
			<ol class="month-list search-page">
			<?php for($i=0;$i<count($publications);$i++):?>
				<li>
				<?php if(empty($publications[$i][$this->uri->language_string.'_document']) === FALSE):?>
					<div class="pdf-dl-link">
						<a href="<?=site_url('publication/get-publication?resourse='.$publications[$i]['id']);?>">
							<img src="<?=BaseURL('img/pdf.png');?>"><?=lang('publication_download');?>
						</a>
					</div>
				<?php endif;?>
					<h2 class="article-h2">
						<a href="<?=site_url('issue/publication/'.$publications[$i]['id'].'-'.getTranslit($publications[$i][$this->uri->language_string.'_title']))?>"><?=$publications[$i][$this->uri->language_string.'_title']?></a>
					</h2>
					<div class="publications-date">
						<?=$publications[$i]['year'];?><?php if(!empty($publications[$i]['page'])):?> (<?=lang('page_char').' '.$publications[$i]['page'];?>)<?php endif;?>
					</div>
					<div class="authors">
					<?php for($j=0;$j<count($publications[$i]['authors']);$j++):?>
						<a href="<?=site_url('author/'.getTranslit($publications[$i]['authors'][$j][$this->uri->language_string.'_name']).'/'.$publications[$i]['authors'][$j]['id']);?>"><?=getInitials($publications[$i]['authors'][$j][$this->uri->language_string.'_name']);?></a><?php if(isset($publications[$i]['authors'][$j+1])):?>, <?php endif;?>
					<?php endfor;?>
					</div>
				</li>
			<?php endfor;?>
			</ol>
		<?php else:?>
			<div>К сожалению, по указанным вами параметрам не найдено ни одной публикации.</div>
		<?php endif;?>
		</article>
		<?php $this->load->view('guests_interface/includes/footer');?>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
	<script type="text/javascript" src="<?=baseURL('js/libs/localize.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/libs/base.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/cabinet/guest.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/vendor/jquery.customSelect.min.js');?>"></script>
	<script type="text/javascript" src="<?=baseURL('js/cabinet/styled-select-init.js');?>"></script>	
	<?php $this->load->view('guests_interface/includes/typekit');?>
	<?php $this->load->view('guests_interface/includes/google-analytics');?>
</body>
</html>