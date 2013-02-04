(function () {
	"use strict";
	
	define([], function() {
		var AppRouter = Backbone.Router.extend({
			
			routes: {
				'*path'				: 	'defaultAction'
			},

			defaultAction: function(actions){
				console.log("Router defaultAction");	
			}
		});

		var initialize = function () {
			console.log("Router init");
			var app_router = new AppRouter();
			Backbone.history.start();
		};

		return {
			initialize: initialize
		};
	});
}());