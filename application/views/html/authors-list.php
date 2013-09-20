<div class="authors-full-list clearfix">
	<div class="left">
		<ul>
		<?php for($i=0;$i<round((count($authors)/2));$i++):?>
			<li>
				<a href="<?=site_url('author/'.getTranslit($authors[$i][$langName.'_name']).'/'.$authors[$i]['id']);?>">
				<?php if(isset($abbr) && $abbr == TRUE):
					echo getInitials($authors[$i][$langName.'_name']);
				else:
					$authors[$i][$langName.'_name'];
				endif;?>
				</a>
			</li>
		<?php endfor;?>
		</ul>
	</div>
	<div class="right">
		<ul>
		<?php for($i=round((count($authors)/2));$i<count($authors);$i++):?>
			<li><a href="<?=site_url('author/'.getTranslit($authors[$i][$langName.'_name']).'/'.$authors[$i]['id']);?>">
				<?php if(isset($abbr) && $abbr == TRUE):
					echo getInitials($authors[$i][$langName.'_name']);
				else:
					$authors[$i][$langName.'_name'];
				endif;?>
				</a>
			</li>
		<?php endfor;?>
		</ul>
	</div>
</div>