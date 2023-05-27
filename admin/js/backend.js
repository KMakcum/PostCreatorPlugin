(function( $ ) {
    'use strict';

    $(function() {
        $('#simple_creating').on('submit', function (e) {
            e.preventDefault();
            simple_create(this);
        });

        function simple_create(form) {
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
