(function( $ ) {
	'use strict';

	$(function() {
		$( "#tabs" ).tabs({active: 0});


		$('#create_form').on('submit', function (e) {
			e.preventDefault();
			get_list_product(this);
		});

		function get_list_product(form) {
			console.log($(form))

			$.ajax({
				url: '/wp-admin/admin-ajax.php',
				data: {
					action: 'create_post',
					option: option,
				},
				method: 'POST',
				success: function (success) {
					if (success.data.content) {
						innerContent.html(success.data.content);
					}
				},
				error: function (jqXHR, exception) {
					console.log('jqXHR: ', jqXHR);
					console.log('exception: ', exception);
				}
			})
		}
	});

	$( window ).load(function() {
	});

})( jQuery );
