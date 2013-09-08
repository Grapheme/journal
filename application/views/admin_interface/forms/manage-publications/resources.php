<div class="clearfix">
<ul class="resources-items resources-documents" data-action="<?=site_url(ADMIN_START_PAGE.'/publications/remove/resources');?>">
<?php for($i=0;$i<count($resources);$i++):?>
	<li>
		<img src="<?=site_url(RUSLAN.'/publications/view-document/'.random_string('alnum',16).'?resource_id='.$resources[$i]['id'])?>" alt="">
		<a href="" data-resource-id="<?=$resources[$i]['id']?>" class="no-clickable delete-resource-item">&times;</a>
	</li>
<?php endfor;?>
</ul>
</div>
<?=$this->load->view('html/zone-upload-documents',array('action'=>site_url(ADMIN_START_PAGE.'/publications/upload/resources?issue='.$this->input->get('issue').'&publication='.$this->input->get('publication'))));?>
