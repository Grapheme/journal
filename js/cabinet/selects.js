/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$(".select-issue").change(function(){
		var url = mt.currentURL.replace(/\?(.+)?/,'');
		if($(this).emptyValue() == false){
			url = url+'?issue='+$(this).val();
		}
		mt.redirect(url);
	});
	$(".select-publication").change(function(){
		var url = mt.currentURL.replace(/\&publication=(\d+)?/,'');
		if($(this).emptyValue() == false){
			url = url+'&publication='+$(this).val();
		}
		mt.redirect(url);
	});
});