// # Define game collection #
define([
  'models/activityModel'
], function(model){
	
	var rankingCollection = Backbone.Collection.extend({

  		model: model,
  
		url: 'api/activities'
  
		parse: function(data) {
			console.log(data);
			return data;
		},
  
		initialize: function () {
			console.log("Ranking collection initialized");
		} 
  
	});

return activityCollection;

});