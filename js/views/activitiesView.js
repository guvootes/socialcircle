
(function () {
	"use strict";
	define([
		'models/activityModel',
		'text!templates/activities.php'
		
	], function (loginModel, template, app) {

		var activitiesView = Backbone.View.extend({
			
			el: $(".content"),
			
			render: function () {
				// replace contents with template on render
				this.$el.html(template);
			},
			
		});
		
		return new activitiesView();
	});
}());