define([], function(){
	var userModel = Backbone.Model.extend({
 		defaults: {
  			"role"		:  "user"
  		},
  
  		url: 'api/user',
  
		validate: function (attrs) {
	    	var errors = [];
	  
	     	if (!attrs.email) {
	        	errors.push({name: 'email', message: 'Please fill email field.'});
	     	}
	     	if (!attrs.username) {
	        	errors.push({name: 'username', message: 'Please fill username field.'});
	     	}
	  
	     	return errors.length > 0 ? errors : false;
		},
	
		initialize: function () {
			console.log("userModel initialized");
		}
  });

  return userModel;
  
});