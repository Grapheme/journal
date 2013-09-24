<li>
	<div class="comment-from">
		<figure>
			<a href="<?=$comment['link'];?>"><img src="<?=site_url('load-image/avatar/'.$comment['id']);?>" alt="<?=$comment['name'];?>"></a>
		</figure>
		<div class="comment-from-info">
			<div class="name"><a href="<?=$comment['link'];?>"><?=$comment['name'];?></a></div>
			<div class="comment-text">
				<?=$comment['comment'];?>
			</div>
		<?php if($this->loginstatus === TRUE && $this->account['group'] == USER_GROUP_VALUE):?>
			<div data-comment="<?=$comment['comment_id'];?>" class="answer show-answer-form">ответить</div>
		<?php endif;?>
		</div>
	</div>
</li>