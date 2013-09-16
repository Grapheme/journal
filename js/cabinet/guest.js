/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("a.a-get-authors").click(function(){
		var _this = this;
		var chr = $(_this).html().trim();
		var lng = $(_this).attr('data-lang').trim();
		$.ajax({
			url: mt.getLangBaseURL('get-authors-list'),
			type: 'POST',dataType: 'json',data:{'char':chr,'lang':lng},
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					$("a.a-get-authors").removeClass('active-char');
					$(_this).addClass('active-char');
					$("#authors-list").html(response.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	})
	$("a.a-get-keywords").click(function(){
		var _this = this;
		var chr = $(_this).html().trim();
		var lng = $(_this).attr('data-lang').trim();
		$.ajax({
			url: mt.getLangBaseURL('get-keywords-list'),
			type: 'POST',dataType: 'json',data:{'char':chr,'lang':lng},
			beforeSend: function(){},
			success: function(response,textStatus,xhr){
				if(response.status){
					$("a.a-get-keywords").removeClass('active-char');
					$(_this).addClass('active-char');
					$("#keywords-list").html(response.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	})
	$("form.form-search-publications").submit(function(){
		if($("input.input-search-text").emptyValue()){
			return false;
		}
	})
	$("form.form-sent-publication-comments .btn-submit").click(function(){
		var options = {target: null,beforeSubmit: mt.ajaxBeforeSubmit,dataType:'json',type:'post'};
		var _form = $(this).parents('form');
		var _this = this;
		$(this).addClass('loading');
		options.success = function(response,status,xhr,jqForm){
			mt.ajaxSuccessSubmit(response,status,xhr,jqForm);
			if(response.status){
				if(response.parent_comment == 0){
					$(_form).find('textarea').val('');
					$("ul.ul-publication-comments-list").prepend(response.responseText);
				}else{
					$("form.insert-form-comment").parents('li').after(response.responseText);
					$("form.insert-form-comment").remove();
					$("div.show-answer-form").removeClass('hidden');
				}
			}else{
				$(_form).after(response.responseText);
			}
		};
		$(_form).ajaxSubmit(options);
		return false;
	})

	$("div.show-answer-form").click(function(){
		$("form.insert-form-comment").remove();$("div.show-answer-form").removeClass('hidden');
		$("div.div-answer-form form").clone(true).insertAfter(this).addClass('insert-form-comment').find('button.btn-cancel-comment').removeClass('hidden');
		$("form.insert-form-comment").find('.input-parent-comment').val($(this).attr('data-comment'));
		$(this).addClass('hidden');
		$("div.div-answer-form").addClass('hidden');
	})
	$("button.btn-cancel-comment").click(function(){
		$("form.insert-form-comment").remove();$("div.show-answer-form").removeClass('hidden');
		$("div.div-answer-form").removeClass('hidden');
	})
});