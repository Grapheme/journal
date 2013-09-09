/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("button.btn-submit").click(function(){
		var _form = $(this).parents('form');
		$(this).addClass('loading');
		$(_form).formSubmitInServer();
	})
	$("button.remove-item").click(function(){
		var _this = this;
		var itemID = $(this).attr('data-item');
		var action = $(this).parents('table').attr('data-action');
		$.ajax({
			url: action,type: 'POST',dataType: 'json',data:{'id':itemID},
			beforeSend: function(){
				return confirm('Удалить запись?');
			},
			success: function(response,textStatus,xhr){
				if(response.status){$(_this).parents('tr').remove();}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("button.btn-publication-submit").click(function(){
		$(this).addClass('loading');
		var _form = $(this).parents('form');
		$(_form).ajaxSubmit(uploadDocuments.multyDocuments);
		return false;
	});
	$("button.btn-exec-script-1").click(function(){
		$.ajax({
			url: mt.getBaseURL('edit/issue/exec-script-1'),type: 'POST',dataType: 'json',
			beforeSend: function(){
				return confirm('Выполнить скрипт №1?');
			},
			success: function(response,textStatus,xhr){
				if(response.status){alert(response.responseText)}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
	$("button.btn-exec-script-2").click(function(){
		$.ajax({
			url: mt.getBaseURL('edit/issue/exec-script-2'),type: 'POST',dataType: 'json',
			beforeSend: function(){
				return confirm('Выполнить скрипт №2?');
			},
			success: function(response,textStatus,xhr){
				if(response.status){alert(response.responseText)}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	});
});