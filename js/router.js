(function () {
	"use strict";
	
	define([
		'views/registerView',
		'views/loginView'
	], function(registerView, loginView) {
		var AppRouter = Backbone.Router.extend({
			
			routes: {
				'/registreer'		:	'showRegister',
				'*path'				: 	'defaultAction'
			},



			defaultAction: function(actions){
				loginView.render();	
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