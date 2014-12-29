<select name="issue" class="span4 select-issue">
<?php for($i=0;$i<count($issues);$i++):?>
	<option value="<?=$issues[$i]['id']?>"<?=($issues[$i]['id'] == $this->input->get('issue'))?' selected':'';?>><?=$issues[$i]['ru_title'].' ('.$issues[$i]['year'].')'?></option>
<?php endfor;?>
</select>