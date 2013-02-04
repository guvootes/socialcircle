(function () {
	"use strict";
	
	require.config({
		paths: {
			text: 'libs/text',
			templates: '../templates'
		}
	});

	require(['app'], function(App) {
		App.initialize();
	});

}());