<ul class="resources-items clearfix" data-action="<?=site_url(ADMIN_START_PAGE.'/collection/remove/resource');?>">
<?php for($i=0;$i<count($images);$i++):?>
	<li class="span2">
		<img class="img-rounded" src="<?=site_url($images[$i]['thumbnail'])?>" alt="">
		<a href="" data-resource-id="<?=$images[$i]['id']?>" class="no-clickable delete-resource-item">&times;</a>
	</li>
<?php endfor;?>
</ul>
<?=$this->load->view('html/zone-upload-file',array('action'=>site_url(ADMIN_START_PAGE.'/collection/upload/resource?id='.$this->input->get('id'))));?>