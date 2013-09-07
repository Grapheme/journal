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
				<h1 class="article-h1"><?=mb_strtoupper(getMonthName($issue['month'],$this->uri->language_string));?>. <?=$issue['year'];?></h1>
				<div class="delicate-design-stroke"> </div>
			<?php if(empty($page_content[$this->uri->language_string.'_document']) === FALSE):?>
				<div class="pdf-dl-link single">
					<a href="<?=BaseURL('download/'.$page_content[$this->uri->language_string.'_document']);?>">
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
				Чежина Н. В., Королев Д. А., Холмичева Н. Н.
			</div>
			<?php endif;?>
			<section>
				<header>
					<h3><?=lang('bibliography_link')?></h3>
				</header>
				<div class="biblio-link">
					Анчаров А.И., Болдырев В.В., Солдатов А . //<?=$page_content[$this->uri->language_string.'_title']?> – <?=$issue['year'];?>. - № <?=$issue['number'];?>. – <?=$page_content['page']?> <?=lang('page_char')?>.
					– <?=lang('ejournal');?>. – <?=site_url(uri_string())?><a class="no-clickable" href=""> [B<span class="capital">ib</span>T<span class="lower">E</span>X]</a>
				</div>
			</section>
			<?php if(!empty($keywords)):?>
			<div class="key-words">
				<?=lang('key_words')?>:
			<?php for($i=0;$i<count($keywords);$i++):?>
				<a href="<?=site_url('search/publication?mode=search&word='.md5(trim($keywords[$i])))?>">
					<?=$keywords[$i];?><?php if(isset($keywords[$i+1])):?>, <?php endif;?>
				</a>
			<?php endfor;?>
			</div>
			<?php endif;?>
			<?php if(!empty($publication_resources)):?>
			<section>
				<header>
					<h3>Дополнительные материалы</h3>
				</header>
				<ul class="unord-list">
				<?php for($i=0;$i<count($publication_resources);$i++):?>
					<li class="unord-item clearfix">
						<div class="list-item-icon video audio text">
							<a href="<?=site_url($publication_resources[$i]['file_path'])?>"></a>
						</div>
						<div class="list-item-desc">
							<div class="list-item-name"><?=$publication_resources[$i]['file_name'];?></div>
							<a href="<?=site_url($publication_resources[$i]['file_path'])?>" class="list-dl-link">скачать</a>
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
					<div class="auth-to-comment">
					<?=lang('signin_for_comment')?>
					</div>
					<div class="auth-icons">
						<div class="facebook">
							<a href="#"> </a>
						</div>
						<div class="twitter">
							<a href="#"> </a>
						</div>
						<div class="vk">
							<a href="#"> </a>
						</div>
					</div>
					<?php $this->load->view('guests_interface/forms/comments');?>
					<ul class="comments-list">
						<li>
							<div class="comment-from">
								<figure>
									<a href="#"><img src="<?=BaseURL('img/face.png');?>" alt=""></a>
								</figure>
								<div class="comment-from-info">
									<div class="name"><a href="#">Лариса Карповская</a></div>
									<div class="comment-text">
										Спасибо, Лариса Германовна! Великолепные стихотворения. Как много красивых слов сказано о физике!
									</div>
									<div class="answer">
										ответить
									</div>
								</div>
							</div>
						</li>
						<li class="answer-elem">
							<div class="comment-from">
								<figure>
									<a href="#"><img src="<?=BaseURL('img/face.png');?>" alt=""></a>
								</figure>
								<div class="comment-from-info">
									<div class="name"><a href="#">Максим Килевой</a></div>
									<div class="comment-text">
										А где правильный ответ почитать?
									</div>
								</div>
							</div>
						</li>
					</ul>
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