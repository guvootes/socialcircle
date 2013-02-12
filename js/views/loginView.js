
(function () {
	"use strict";
	define([
		'models/loginModel',
		'text!templates/login.php',
		
	], function (loginModel, template) {

		var loginView = Backbone.View.extend({
			
			el: $(".content"),
			
			initialize: function(){		
			},
			
			events: {
				"submit form#loginform": "submitForm"
			},
			
			submitForm: function(e){
				e.preventDefault();
				
				var self = this;
				
				
				var data = {
					email		: this.$('#email').val(),
					password	: this.$('#password').val()				
				};
				
				var newLogin = new loginModel(data);
				
				console.log(newLogin.toJSON());
				 				 
				newLogin.save(newLogin.toJSON(),{
					success: function(model, response){
						console.log(model, response);
						self.showResponse(response);
					},
					
					error: function(model, response){
						
						if(response.statusText){
							alert(response.statusText);
						}
						
						$('ul.formlist li span.helper').remove();

						self.showResponse(response);
					}
					
				});		
				
			},
			
			showResponse: function(errors) {
			    _.each(errors, function (error) {
			        var controlGroup = this.$('#' + error.name).parent(); 
			        controlGroup.children('span').remove();
			        controlGroup.addClass('error');
			        controlGroup.append("<span class='helper'>"+error.message+"</span>");
			    }, this);
			},
			 
			hideErrors: function () {
			    this.$('.formlist li').removeClass('error');
			    this.$('.helper').remove();
			},

			render: function () {
				// replace contents with template on render
				this.$el.html(template);
			},
			
		});
		
		return new loginView();
	});
}());