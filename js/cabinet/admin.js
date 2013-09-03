/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	var mainOptions = {target: null,beforeSubmit: mt.ajaxBeforeSubmit,success: mt.ajaxSuccessSubmit,dataType:'json',type:'post'};
	/*---------------------------- courses ---------------------------------------- */
	$("form.form-signup-admin .btn-submit").click(function(event){
		event.stopPropagation();
		var _form = $("form.form-signup-admin");
		$(this).addClass('loading');
		var options = mainOptions;
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				$(_form).resetForm();
				$("div.div-form-operation").after('<div class="msg-alert">'+response.responseText+'</div>');
			}else{
				$("div.div-form-operation").after('<div class="msg-alert error">'+response.responseText+'</div>');
			}
		}
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("input.input-change-account-status").click(function(){
		var _this = this;
		var setStatus = 0;
		if($(_this).is(':checked')){setStatus = 1;}
		var accountID = $(_this).attr('data-account');
		$.ajax({
			url: mt.baseURL+'change-account-status',data: {'accountID':accountID,'setStatus':setStatus},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(data,textStatus,xhr){
				if(data.status == false){
					alert(data.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Возникла ошибка');
			}
		});
	})
	$("input.input-change-expert-status").click(function(event){
		var _this = this;
		var setStatus = 0;
		if($(_this).is(':checked')){setStatus = 1;}
		var accountID = $(_this).attr('data-account');
		$.ajax({
			url: mt.baseURL+'change-account-expert-status',data: {'accountID':accountID,'setStatus':setStatus},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(data,textStatus,xhr){
				if(data.status == false){
					alert(data.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Возникла ошибка');
			}
		});
	})
	$("a.show-expert-statement").click(function(){
		var requestID = $(this).attr('data-request-id');
		$.ajax({
			url: mt.baseURL+'load-view/expert-statement',type: "POST",dataType: "json",data: {'requestID':requestID},
			beforeSend: function(){$("#preview-content").html('').addClass('loading');},
			success: function(data,textStatus,xhr){$("#preview-content").removeClass('loading').html(data.message);},
			error: function(xhr,textStatus,errorThrown){$("#preview-content").removeClass('loading').html(textStatus);}
		});
	})
	$("button.button-change-request-expert-status").click(function(){
		var _this = this;
		var setStatus = $(_this).attr('data-request-status');
		var requestID = $(_this).attr('data-request');
		$.ajax({
			url: mt.baseURL+'change-request-expert-status',data: {'requestID':requestID,'setStatus':setStatus},type: 'POST',dataType: 'json',
			beforeSend: function(){$(_this).addClass('loading');},
			success: function(data,textStatus,xhr){
				if(data.status == true){
					if(setStatus == 1){
						$(_this).parents('td').html('<div class="msg-alert">Одобрено</div>');
					}else if(setStatus == 2){
						$(_this).parents('td').html('<div class="msg-alert error">Отклонено</div>');
					}
				}else{
					$(_this).removeClass('loading');
					alert(data.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Возникла ошибка');
			}
		});
	})
	$("input.input-change-course-status").click(function(event){
		var _this = this;
		var setStatus = 4;
		if($(_this).is(':checked')){setStatus = 1;}
		var courseID = $(_this).attr('data-course');
		$.ajax({
			url: mt.baseURL+'admin/change-course-status',data: {'courseID':courseID,'setStatus':setStatus},type: 'POST',dataType: 'json',
			beforeSend: function(){},
			success: function(data,textStatus,xhr){
				if(data.status == false){
					alert(data.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Возникла ошибка');
			}
		});
	})

	$("button.button-change-project-modaration-status").click(function(){
		var _this = this;
		var setStatus = $(_this).attr('data-course-status');
		var courseID = $(_this).attr('data-course');
		$.ajax({
			url: mt.baseURL+'change-project-modaration-status',data: {'courseID':courseID,'setStatus':setStatus},type: 'POST',dataType: 'json',
			beforeSend: function(){$(_this).addClass('loading');},
			success: function(response,textStatus,xhr){
				if(response.status == true){
					$(_this).parents('td').html('<div class="msg-alert">'+response.responseText+'</div>');
				}else{
					$(_this).removeClass('loading');
					alert(response.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){
				alert('Возникла ошибка');
			}
		});
	})
	
});