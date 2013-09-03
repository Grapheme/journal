/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

var History = History || {};
History.pathname = null;
History.previousHash = null;
History.hashCheckInterval = -1;
History.stack = [];
History.initialize = function () {
	if(History.supportsHistoryPushState()){
		History.pathname = document.location.pathname;
		$(window).bind("popstate", History.onHistoryChanged);
	}else{
		History.hashCheckInterval = setInterval(History.onCheckHash,200);
	}
};
History.supportsHistoryPushState = function () {
	return ("pushState" in window.history) && window.history.pushState !== null;
};
History.onCheckHash = function () {
	if(document.location.hash !== History.previousHash){
		History.navigateToPath(document.location.hash.slice(1));
		History.previousHash = document.location.hash;
	}
};
History.pushState = function (url) {
	if(History.supportsHistoryPushState()){
		window.history.pushState("", "", url);
	}else{
		History.previousHash = url;
		document.location.hash = url;
	}
	History.stack.push(url);
};
History.onHistoryChanged = function (event){
	if(History.supportsHistoryPushState()){
		if(History.pathname != document.location.pathname){
			History.pathname = null;
			History.navigateToPath(document.location.pathname);
		}
	}
};
History.navigateToPath = function(pathname) {
	History.pushState(pathname);
};