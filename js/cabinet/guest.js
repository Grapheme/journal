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
		var error = true;
		$("div.msg-alert").remove();
		if($("input.input-search-text").emptyValue() === false){
			error = false;
		}else if($("select.hasCustomSelect[name='year']").emptyValue() === false){
			error = false;
		}else if($("select.hasCustomSelect[name='number']").emptyValue() === false){
			error = false;
		}
		if(error){
			$(this).after('<div class="msg-alert error">'+Localize[mt.getLanguageURL()]['search_string_empty']+'</div>')
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
					$("ul.ul-publication-comments-list").prepend(response.responseText).find('li .show-answer-form:first').on('click',function(){setShowCommentForm(this)});
				}else{
					$("form.insert-form-comment").parents('li').after(response.responseText);
				}
				$("form.insert-form-comment").remove();
				$("div.show-answer-form").removeClass('hidden');
				$("div.div-answer-form").removeClass('hidden');
			}else{
				$(_form).after(response.responseText);
			}
		};
		$(_form).ajaxSubmit(options);
		return false;
	})
	$("div.show-answer-form").click(function(){setShowCommentForm(this);})
	$("button.btn-cancel-comment").click(function(){
		$("form.insert-form-comment").remove();$("div.show-answer-form").removeClass('hidden');
		$("div.div-answer-form").removeClass('hidden');
	})
	$("a.show-bibText").click(function(){
		var href = $(this).attr('href').trim();
		window.open(href,'bibtext',"top=140,left=150,width=960,height=350,resizable=yes,scrollbars=no,status=no");
	})

	function setShowCommentForm(answer){
		$("form.insert-form-comment").remove();$("div.show-answer-form").removeClass('hidden');
		$("div.div-answer-form form").clone(true).insertAfter(answer).addClass('insert-form-comment').find('button.btn-cancel-comment').removeClass('hidden');
		$("form.insert-form-comment").find('.input-parent-comment').val($(answer).attr('data-comment'));
		$(answer).addClass('hidden');
		$("div.div-answer-form").addClass('hidden');
	}
});