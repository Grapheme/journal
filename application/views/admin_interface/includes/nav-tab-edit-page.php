<ul class="breadcrumb">
	<li><a href="<?=site_url(ADMIN_START_PAGE);?>">Панель управления</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url(ADMIN_START_PAGE.'/pages');?>">Страницы</a> <span class="divider">/</span></li>
	<li class="active"><?=$pageTitle;?></li>
</ul>
<div class="clear"></div>
<!--<div class="clearfix">
	<ul class="nav nav-tabs">
		<li <?=($this->input->get('mode') == 'text')?'class="active"':''?>><a href="<?=site_url(ADMIN_START_PAGE.'/pages/'.$this->uri->segment(3).'/edit?mode=text&id='.$this->input->get('id'));?>">Текстовая информация</a></li>
		<li <?=($this->input->get('mode') == 'image')?'class="active"':''?>><a href="<?=site_url(ADMIN_START_PAGE.'/pages/'.$this->uri->segment(3).'/edit?mode=image&id='.$this->input->get('id'));?>">Изображения</a></li>
		<li <?=($this->input->get('mode') == 'caption')?'class="active"':''?>><a href="<?=site_url(ADMIN_START_PAGE.'/pages/'.$this->uri->segment(3).'/edit?mode=caption&id='.$this->input->get('id'));?>">Подписи к изображениям</a></li>
	</ul>
</div>-->