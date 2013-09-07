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
});