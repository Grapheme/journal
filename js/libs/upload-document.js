/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */
var uploadDocuments = uploadDocuments || {};
uploadDocuments.singleDocument = {
	target: null, type: 'post', dataType:'json',
	beforeSubmit: function(formData,jqForm,options){
		if(mt.ajaxBeforeSubmit(formData,jqForm,options)){
			if($(jqForm).find('input[type="file"]').emptyValue() == false){
				var percentVal = '0%';
				$("div.bar").width(percentVal).html(percentVal);
				$("#div-upload-photo").removeClass('hidden');
			}
		}else{return false;}
	},
	uploadProgress: function(event,position,total,percentComplete){
		var percentVal = percentComplete + '%';
		$("div.bar").width(percentVal).html(percentVal);
	},
	success: function(response,statusText,xhr,jqForm){
		var percentVal = '100%';
		$("button.btn-loading").removeClass('loading');
		$("div.bar").width(percentVal).html(percentVal);
		if(response.status){
			$("div.bar").parents('div.progress').removeClass('progress-info active').addClass('progress-success');
			$("div.div-form-operation").after('<div class="msg-alert">'+response.responseText+'</div>');
			if(response.responsePhotoSrc != false){
				$("img.destination-photo").attr('src',response.responsePhotoSrc);
			}
			if($(jqForm).find('input.checkbox-delete-image').is(':checked') == true){
				$("img.destination-photo").attr('src',mt.getBaseURL('img/no-photo.png'));
			}
			if(response.redirect){
				setTimeout(function(){mt.redirect(response.redirect);},3000);
			}
		}else{
			$("div.bar").parents('div.progress').removeClass('progress-info active').addClass('progress-danger');
			$("div.div-form-operation").after('<div class="msg-alert error">'+response.responseText+'</div>');
		}
	}
}
uploadDocuments.multyDocuments = {
	target: null, type: 'post', dataType:'json',
	beforeSubmit: function(formData,jqForm,options){
		return mt.ajaxBeforeSubmit(formData,jqForm,options);
	},
	uploadProgress: function(event,position,total,percentComplete){},
	success: function(response,statusText,xhr,jqForm){
		$("button.btn-loading").removeClass('loading');
		if(response.status){
			$("div.div-form-operation").after('<div class="msg-alert">'+response.responseText+'</div>');
			if(response.redirect){
				mt.redirect(response.redirect);
			}
		}else{
			$("div.div-form-operation").after('<div class="msg-alert error">'+response.responseText+'</div>');
		}
	}
}