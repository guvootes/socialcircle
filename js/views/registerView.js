
(function () {
	"use strict";
	define([
		'models/userModel',
		'text!templates/register.html',
		
	], function (userModel, template) {

		var registerView = Backbone.View.extend({
			
			el: $(".content"),
			
			initialize: function(){		
			},
			
			events: {
				"submit form": "submitForm"
			},
			
			submitForm: function(e){
				e.preventDefault();
				
				var newUser = new userModel();
				
				var data = {
					email: this.$('#email').val(),
					username:  this.$('#username').val()
				}
				 
				newUser.save(data,{
						error: function(model, error){ 
							console.log(error);
						}
					}
				);		
				
			},

			render: function () {
				// replace contents with template on render
				this.$el.html(template);
			},
			
		});
		
		return new registerView();
	});
}());