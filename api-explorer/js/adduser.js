(function($) {

	var addUser = {

		state: {
			enabled: false
		},

		values: {},

		init: function (el) {

			this.element = el;
			this.inputs = this.element.find('input');

			if(!this.state.enabled) this.enable();

		},

		enable: function () {

			this.element.on('submit', $.proxy(this, 'onSubmit'));
			this.state.enabled = true;

		},

		onSubmit: function (e) {

			e.preventDefault();

			var self = this;

			$.each(this.inputs, function () {
				self.values[this.name] = $(this).val();
			});

			this.ajaxCall();

		},

		ajaxCall: function () {

			console.log(JSON.stringify(this.values));

			$.ajax({
				type: 'POST',
				// contentType: 'application/json',
				url: '../api/user',
				// dataType: "json",
				data: this.values,
				success: function(data, textStatus, jqXHR){
					console.log(data);
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log('error: ', jqXHR, textStatus, errorThrown);
				}
			});



		}

	}

	addUser.init($('#adduser'));
	window.addUser = addUser;

})(jQuery);