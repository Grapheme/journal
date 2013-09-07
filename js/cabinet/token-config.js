/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("input.authors-list").tokenInput(mt.getBaseURL('search-authors-list'),{
		theme: "facebook",
		hintText: "Введите слово для поиска",
		noResultsText: "Ничего не найдено",
		searchingText: "Поиск...",
	});
});