(function () {
	"use strict";
	
	define([
		'views/registerView'
	], function(registerView) {
		var AppRouter = Backbone.Router.extend({
			
			routes: {
				'/registreer'		:	'showRegister',
				'*path'				: 	'defaultAction'
			},



			defaultAction: function(actions){
				console.log("Router defaultAction "+actions);	
			},
			
			showRegister: function(){
				registerView.render();
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