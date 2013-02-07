
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
					succes: function(){
						self.hideErrors();
					},
					
					error: function(model, error){
						$(".formlist li").removeClass('error').find('span').remove();
						self.showErrors(error);
					}
					
				});		
				
			},
			
			showErrors: function(errors) {
			    _.each(errors, function (error) {
			        var controlGroup = this.$('#' + error.name).parent();
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
		
		return new registerView();
	});
}());