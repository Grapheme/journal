/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$(".select-issue").change(function(){
		var url = mt.currentURL.replace(/\?issue=(\d+)?/,'');
		if($(this).emptyValue() == false){
			url = url+'?issue='+$(this).val();
		}
		mt.redirect(url);
//		alert(url);
	});
});