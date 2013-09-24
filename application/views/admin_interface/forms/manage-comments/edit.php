<?=form_open(ADMIN_START_PAGE.'/comment/update?mode=update&id='.$this->input->get('id'),array('class'=>'form-manage-comments')); ?>
	<div class="control-group">
		<label>Комментарий:</label>
		<textarea class="redactor" rows="10" name="comment"><?=$content['comment'];?></textarea>
	</div>
	<div class="div-form-operation">
		<button type="submit" value="" name="submit" class="btn btn-submit btn-success no-clickable btn-loading">Сохранить</button>
		<a class="btn btn-info" href="<?=$this->session->userdata('backpath');?>">Завершить</a>
	</div>
<?= form_close(); ?>