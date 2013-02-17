
(function () {
	"use strict";
	define([
		'models/registerModel',
		'text!templates/register.php',
		
	], function (userModel, template) {

		var registerView = Backbone.View.extend({
			
			el: $(".content"),
			
			initialize: function(){		
			},
			
			events: {
				"submit form#registerform": "submitForm"
			},
			
			submitForm: function(e){
				e.preventDefault();
				
				var self = this;
				
				
				var data = {
					username	: this.$('#username').val(),
					email		: this.$('#email').val(),
					password	: this.$('#password').val(),
					birthday	: this.$('#birthday').val()					
				};
				
				var newUser = new userModel(data);
				console.log(newUser.toJSON());
				 				 
				newUser.save(newUser.toJSON(),{
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
				this.hideErrors();
			
			    _.each(errors, function (error) {
			        var controlGroup = this.$('#' + error.name).parent(); 
			        controlGroup.children('span').remove();
			        controlGroup.parent().addClass('error');
			        controlGroup.append("<span class='help-inline'>"+error.message+"</span>");
			    }, this);
			},
			 
			hideErrors: function () {
			    this.$('.formlist li').removeClass('error');
			    this.$('.help-inline').remove();
			},

			render: function () {
				// replace contents with template on render
				this.$el.html(template);
			},
			
		});
		
		return new registerView();
	});
}());