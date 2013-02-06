define([], function(){
	var userModel = Backbone.Model.extend({
 		defaults: {
  			"role"		:  "user"
  		},
  
  		url: 'api/user',
  
		validate: function (attrs) {
	    	var errors = [];
	  
	  		// username validation
	     	if (!attrs.username) {
	        	errors.push({name: 'username', message: 'Vul een gebruikersnaam in'});
	     	}else if(attrs.username.length < 4 ){
	     		errors.push({name: 'username', message: 'De opgegeven naam is te kort'});
	     	}
	     	
	     	// email validation
	     	if (!attrs.email) {
	     		errors.push({name: 'email', message: 'Vul een e-mailadres in'});
	     	}
	     	
	     	// password validation
	     	if (!attrs.password) {
	     		errors.push({name: 'password', message: 'Vul een wachtwoord in'});
	     	}else if(attrs.password.length < 5 ){
	     		errors.push({name: 'password', message: 'Het wachtwoord moet ten minste 5 tekens bevatten'});
	     	}
	     	
	     	// birthday validation
	     	if (!attrs.birthday) {
	     		errors.push({name: 'birthday', message: 'Vul een geboortedatum in'});
	     	}
	  
	     	return errors.length > 0 ? errors : false;
		},
	
		initialize: function () {
			console.log("userModel initialized");
		}
  });

  return userModel;
  
});