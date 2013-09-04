<div class="lang">
	<ul class="lang-list">
		<li class="lang-item">
			<a <?=($this->uri->language_string == RUSLAN)?'class="active"':''?> href="<?=baseURL(RUSLAN.'/'.uri_string());?>">Ru</a>
		</li>
		<li class="lang-item">
			<a <?=($this->uri->language_string == ENGLAN)?'class="active"':''?> href="<?=baseURL(ENGLAN.'/'.uri_string());?>">En</a>
		</li>
	</ul>
</div>