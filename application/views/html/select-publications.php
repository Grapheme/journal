<select name="publication" class="span9 select-publication">
	<option value="">Статья не указана</option>
<?php for($i=0;$i<count($publications);$i++):?>
	<option value="<?=$publications[$i]['id']?>"<?=($publications[$i]['id'] == $this->input->get('publication'))?' selected':'';?>><?=word_limiter(mb_strtolower($publications[$i]['ru_title']),10);?></option>
<?php endfor;?>
</select>