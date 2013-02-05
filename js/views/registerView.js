
(function () {
	"use strict";
	define([
		'text!templates/register.html',
		
	], function (template) {

		var registerView = Backbone.View.extend({
			
			el: $(".content"),
			
			initialize: function(){		
			},
			
			events: {
			},

			render: function () {
				// replace contents with template on render
				this.$el.html(template);
			},
			
		});
		
		return new registerView();
	});
}());