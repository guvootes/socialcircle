(function () {
	"use strict";
	define(['router'], function (Router) {
		
		var initialize = function () {
			Router.initialize();
		}

		return { initialize: initialize };
	});
}());