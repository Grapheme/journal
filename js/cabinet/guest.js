/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	var mainOptions = {target: null,beforeSubmit: mt.ajaxBeforeSubmit,success: mt.ajaxSuccessSubmit,dataType:'json',type:'post'};
	$("input.sign-up-agree").click(function(){
		if($(this).is(":checked")){
			$("button.btn-signup").removeAttr("disabled");
		}else{
			$("button.btn-signup").attr("disabled","disabled");
		}
	})
	$("button.btn-signup").click(function(){
		var _form = $("form.form-signup");
		var _this = this;
		$(_this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).clearForm();
				$(_this).parents('div.popup').addClass('hidden');
				showMessageBlock(response.responseText);
			}else{
				$("div.div-form-operation").before('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("button.btn-signin").click(function(){
		var _form = $("form.form-signin");
		var _this = this;
		$(_this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).clearForm();
				$(_this).parents('div.popup').addClass('hidden');
				if(response.redirect !== false){
					mt.redirect(response.redirect);
				}else{
					$("div.div-account-block").html(response.responseText);
				}
			}else{
				$("div.div-form-operation").before('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("button.btn-link-account-sn").click(function(){
		$("div.bound-popup .popup-header").fadeOut(400,function(){
			$("div.bound-popup .popup-body").removeClass('hidden');
			History.navigateToPath(clearGetURL(mt.currentURL));
		});
	})
	$(".btn-reg-account-sn").click(function(){
		$.ajax({
			url: mt.baseURL+'get-registering-data',type: 'POST',dataType: 'json',
			beforeSend: function(){
				$("button.btn-reg-account-sn").addClass('loading');
			},
			success: function(data,textStatus,xhr){
				if(data.status === true){
					$.each(data.reg_data,function(name,value){
						$("form.form-signup input[name='"+name+"']").val(value);
					})
					$("div.bound-popup").fadeOut(400,function(){
						$("div.signup-popup").removeClass('hidden');
					});
					History.navigateToPath(clearGetURL(mt.currentURL));
				}
			},
			error: function(xhr,textStatus,errorThrown){
				$("button.btn-reg-account-sn").removeClass('loading');
			}
		});
	})
	$("button.btn-link-account").click(function(){
		var _form = $('form.form-link-account');
		var _this = this;
		$(_this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).clearForm();
				$(_this).parents('div.popup').addClass('hidden');
				$("div.div-account-block").html(response.responseText);
			}else{
				$("div.div-form-operation").before('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("button.btn-forgot-password").click(function(){
		var _form = $('form.form-forgot-password');
		var _this = this;
		$(_this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).clearForm();
				$(_this).parents('div.popup').addClass('hidden');
				showMessageBlock(response.responseText);
			}else{
				$("div.div-form-operation").before('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("button.btn-new-password").click(function(){
		var _form = $("form.form-new-password");
		var _this = this;
		$(_this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).clearForm();
				$(_this).parents('div.popup').addClass('hidden');
				showMessageBlock(response.responseText);
			}else{
				$("div.div-form-operation").before('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	function showMessageBlock(text){
		$("div.popup-message-block").html('<div class="msg-alert">'+text+'</div>');
		$("div.message-popup").removeClass('hidden');
		setTimeout(function(){$("div.message-popup").addClass('hidden');History.navigateToPath(clearGetURL(mt.currentURL));},6000);
	}
});