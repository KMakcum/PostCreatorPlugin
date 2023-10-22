(function( $ ) {
    'use strict';

    $(function() {
        $('#simple_creating').on('submit', function (e) {
            e.preventDefault();
            simpleCreate(this);
        });
        $('[name="post_type"]').on('change', function (e) {
            updateCats($(this).val());
        });

        function updateCats(postType) {
            const catSelect = $('#cat-select');
            catSelect.addClass('pc_loading')

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'update_categories',
                    'post_type': postType,
                },
                method: 'POST',
                success: function (request) {
                    if (request.success) {
                        const calList = catSelect.find('.form_field__cat-list');
                        calList.html(request.data);
                        catSelect.slideDown();
                    } else {
                        catSelect.slideUp();
                    }
                    catSelect.removeClass('pc_loading')
                },
                error: function (jqXHR, exception) {
                    catSelect.removeClass('pc_loading')
                    catSelect.slideUp();
                    console.log('jqXHR: ', jqXHR);
                    console.log('exception: ', exception);
                }
            })
        }

        function simpleCreate(form) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: $(form).serialize(),
                method: 'POST',
                success: function (request) {
                    if (request.data.content) {
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
