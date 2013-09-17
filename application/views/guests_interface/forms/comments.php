<?php if($this->loginstatus && $this->account['group'] == USER_GROUP_VALUE):?>
<a name="comments-form"></a>
<div class="div-answer-form">
	<form method="POST" class="form-sent-publication-comments" action="<?=site_url('send-publication-comment');?>">
		<input type="hidden" name="issue" value="<?=$this->uri->segment(4);?>"/>
		<input type="hidden" name="publication" value="<?=$this->uri->segment(6);?>"/>
		<input type="hidden" class="input-parent-comment" name="parent" value="0"/>
		<textarea class="valid-required" name="comment"></textarea>
		<div class="comment-from-form clearfix">
			<figure>
				<a href="<?=$this->profile['link']?>" target="_blank"><img src="<?=site_url('load-image/avatar/'.$this->account['id']);?>" alt="<?=$this->profile['name'];?>"></a>
			</figure>
			<input class="btn-submit btn-loading" type="submit" value="Отправить">
			<button class="btn-cancel-comment hidden" type="button">Отмена</button>
			<div class="comment-from-info">
				<div class="name"><a href="<?=$this->profile['link']?>" target="_blank"><?=$this->profile['name'];?></a></div>
				<div class="social-addr"><?=$this->profile['link'];?></div>
			</div>
		</div>
	</form>
</div>
<?php endif;?>