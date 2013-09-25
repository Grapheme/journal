<div class="lang">
	<ul class="lang-list">
		<li class="lang-item">
			<a <?=($this->uri->language_string == RUSLAN)?'class="active"':''?> href="<?=baseURL(RUSLAN.'/'.uri_string().urlGETParameters());?>">Ru</a>
		</li>
		<li class="lang-item">
			<a <?=($this->uri->language_string == ENGLAN)?'class="active"':''?> href="<?=baseURL(ENGLAN.'/'.uri_string().urlGETParameters());?>">En</a>
		</li>
	</ul>
</div>