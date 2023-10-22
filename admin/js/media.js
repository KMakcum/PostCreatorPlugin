jQuery(function($){

    $('.upload_image_button').click(function( event ){

        event.preventDefault();

        const button = $(this);

        const customUploader = wp.media({
            title: 'Выберите изображение',
            library : {
                // uploadedTo : wp.media.view.settings.post.id, // если для метобокса и хотим прилепить к текущему посту
                type : 'image'
            },
            button: {
                text: 'Выбрать изображение' // текст кнопки, по умолчанию "Вставить в запись"
            },
            multiple: false
        });

        // добавляем событие выбора изображения
        customUploader.on('select', function() {
            const imageObj = customUploader.state().get('selection').first().toJSON();
            const thumbBlock = button.closest('.thumb-add');
            const thumbInput = thumbBlock.find('input');
            const thumbImgWrapper = thumbBlock.find('.thumb-add__img');

            thumbImgWrapper.html('<img src="'+imageObj.url+'" width="150">')
            thumbInput.val(imageObj.id);
        });

        // и открываем модальное окно с выбором изображения
        customUploader.open();
    });
    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у <input type="hidden">
     */
    $('.remove_image_button').click(function(e){
        e.preventDefault();

        const thumbBlock = $(e.target).closest('.thumb-add');
        const thumbInput = thumbBlock.find('input');
        const thumbImgWrapper = thumbBlock.find('.thumb-add__img');

        thumbImgWrapper.html('')
        thumbInput.val('');
    });
});