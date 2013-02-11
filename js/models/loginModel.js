define([], function(){
	var loginModel = Backbone.Model.extend({
// 		defaults: {
//  			"role"		:  "user"
//  		},
  
  		url: 'api/login',
  
		validate: function (attrs) {
	    	var errors = [];
	     	
	     	// email validation
	     	if (!attrs.email) {
	     		errors.push({name: 'email', message: 'Vul een e-mailadres in'});
	     	}
	     	
	     	// password validation
	     	if (!attrs.password) {
	     		errors.push({name: 'password', message: 'Vul een wachtwoord in'});
	     	}
	 
	     	return errors.length > 0 ? errors : false;
		},
	
		initialize: function () {
			console.log("loginModel initialized");
		}
  });

  return loginModel;
  
});