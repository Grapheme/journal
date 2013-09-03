<div class="msg-alert">
<?php if($alert_header != FALSE || !empty($alert_header)):?>
	<h5><?=$alert_header;?></h5>
<?php endif;?>
	<p><?php print_r($array);?></p>
</div>