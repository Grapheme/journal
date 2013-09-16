<div class="clearfix">
	<ul class="nav nav-tabs">
		<li <?=($this->input->get('mode') == 'files')?'class="active"':''?>><a href="<?=site_url(ADMIN_START_PAGE.'/publications/resources?mode=files&issue='.$this->input->get('issue').'&publication='.$this->input->get('publication'));?>">Файлы</a></li>
		<li <?=($this->input->get('mode') == 'captions')?'class="active"':''?>><a href="<?=site_url(ADMIN_START_PAGE.'/publications/resources?mode=captions&issue='.$this->input->get('issue').'&publication='.$this->input->get('publication'));?>">Подписи</a></li>
	</ul>
</div>