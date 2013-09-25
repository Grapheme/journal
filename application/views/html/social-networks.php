<?php if($this->loginstatus === FALSE || $this->account['group'] == ADMIN_GROUP_VALUE):?>
<div class="auth-to-comment">
	<?=lang('signin_for_comment')?>
</div>
<div class="auth-icons">
	<div class="facebook">
		<a href="<?=OAUTH_FACEBOOK.site_url('sign-in/facebook');?>"></a>
	</div>
	<div class="vk">
		<a href="<?=OAUTH_VK.site_url('sign-in/vk');?>"></a>
	</div>
</div>
<?php endif;?>