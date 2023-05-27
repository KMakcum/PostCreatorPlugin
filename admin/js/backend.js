(function( $ ) {
    'use strict';

    $(function() {
        $('#create_form').on('submit', function (e) {
            e.preventDefault();
            get_list_product(this);
        });

        function get_list_product(form) {

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: $(form).serialize(),
                method: 'POST',
                success: function (success) {
                    if (success.data.content) {
                        // innerContent.html(success.data.content);
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
