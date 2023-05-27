(function( $ ) {
    'use strict';

    $(function() {
        $( ".tabs" ).tabs({active: 0});
        tippy('.tooltip');

        $('.tabs-radio input[type="radio"].radio-select').on('click', function () {
            const panelID = $(this).data('tab');

            $('.radio-panel').hide();
            $('[data-panel="'+panelID+'"]').show();
        });

        $('.switcher-select input[type="radio"], .switcher-select input[type="checkbox"]').on('change', function () {
            const fieldID = $(this).val();
            const switcher = $(this).closest('.switcher-select');
            const switcherFields = switcher.find('.switcher-select__field');
            const selectedField = switcher.find('[data-panel="'+fieldID+'"]');

            console.log($(this).attr('type'))
            if ($(this).attr('type') == 'checkbox'){
                if (this.checked == true) {
                    switcher.find('[data-panel="'+fieldID+'"]').show(300);
                } else {
                    switcher.find('[data-panel="'+fieldID+'"]').hide(300);
                }
            } else {
                switcherFields && switcherFields.hide(300);
                selectedField && selectedField.show(300);
            }
        })
    });

    $( window ).load(function() {
    });

})( jQuery );
