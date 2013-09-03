/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("button.btn-submit").click(function(){
		var _form = $(this).parents('form');
		$(this).addClass('loading');
		$(_form).formSubmitInServer();
	});
});