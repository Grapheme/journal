<footer>
	<div class="footer-items">
		<ul class="subnav-left">
		<?php for($i=0;$i<(count($footer_menu)/2);$i++):?>
			<li class="subnav-item"><a href="<?=site_url($footer_menu[$i]['page_url']);?>"><?=$footer_menu[$i]['title']?></a></li>
		<?php endfor;?>
		</ul>
		<ul class="subnav-right">
		<?php for($i=(count($footer_menu)/2);$i<count($footer_menu);$i++):?>
			<li class="subnav-item"><a href="<?=site_url($footer_menu[$i]['page_url']);?>"><?=$footer_menu[$i]['title']?></a></li>
		<?php endfor;?>
		</ul>
		<div class="contact-addresses">
			<address>г. Балашиха, Щелковское шоссе 54-Б</address>
			<address>+7 (495) 502-92-90</address>
			<address>+7 (495) 227-62-63</address>
			<address>+7 (499) 685-12-76</address>
			<address>email: <a href="mailto:info@conferum.ru">info@conferum.ru</a></address> 
		</div>
		<div class="contact-us-bottom">
			<div class="contact-call-link summon-call-form">
				<div class="contact-icon contact-icon-call"></div>
				<a class="no-clickable" href="#">Заказать звонок</a>
			</div>
			<div class="contact-call-link">
				<div class="contact-icon contact-icon-cons"></div>
				<a href="<?=site_url('consultation');?>">Консультация специалиста</a>
			</div>
		</div>
	</div>
</footer>
<?php $this->load->view('guests_interface/modal/order-a-call');?>