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
					$("#authors-list").html(response.responseText);
				}
			},
			error: function(xhr,textStatus,errorThrown){}
		});
	})
});