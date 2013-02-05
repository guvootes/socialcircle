define([], function(){

  var userModel = Backbone.Model.extend({
  // Set model defaults *(backbone method)*
  defaults: {
  	"role"		:  "user"
  },
  
  url: 'api/user',
  
  
  initialize: function () {
    console.log("userModel initialized");
  }
  
});

  return userModel;
});