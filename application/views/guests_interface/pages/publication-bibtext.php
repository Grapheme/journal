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
		<pre>
@article{
<?php if(!empty($authors)):?>
	author = {[<?php for($j=0;$j<count($authors);$j++):?><?=getInitials($authors[$j][$this->uri->language_string.'_name']);?><?php if(isset($authors[$j+1])):?>, <?php endif;?><?php endfor;?>]},
<?php endif;?>
	title = {[<?=$page_content[$this->uri->language_string.'_title']?>]},
	journal = {[<?=lang('ejournal');?> "<?=lang('journal_name');?>", <?=site_url();?>]},
	year = {[<?=$issue['year'];?>]},
	number = {[<?=$issue['number'];?>]}<?php if(!empty($page_content['page'])):?>,<?php endif;?>
	
<?php if(!empty($page_content['page'])):?>
	pages = {[<?=$page_content['page'];?>]}
<?php endif;?>
}
		</pre>
	</div>
	<?php $this->load->view('guests_interface/includes/scripts');?>
</body>
</html>