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
			<!--<div class="answer">ответить</div>-->
		</div>
	</div>
</li>
<!--<li class="answer-elem">
	<div class="comment-from">
		<figure>
			<a href="#"><img src="<?=BaseURL('img/face.png');?>" alt=""></a>
		</figure>
		<div class="comment-from-info">
			<div class="name"><a href="#">Максим Килевой</a></div>
			<div class="comment-text">
				А где правильный ответ почитать?
			</div>
		</div>
	</div>
</li>-->