(function () {
	"use strict";
	
	define([
		'views/registerView',
		'views/loginView',
		'views/activitiesView'
	], function(registerView, loginView, activitiesView) {
		var AppRouter = Backbone.Router.extend({
			
			routes: {
				'/registreer'		:	'showRegister',
				'/activiteiten'		:	'showActivities',
				'*path'				: 	'defaultAction'
			},



			defaultAction: function(actions){
				loginView.render();	
			},
			
			showRegister: function(){
				registerView.render();
			},
			
			showActivities: function(){
				activitiesView.render();
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