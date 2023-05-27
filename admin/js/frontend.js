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

        // Заполнение всех полей кнопкой
        const formSetBtns = document.querySelectorAll('.form_section__btns .button');
        formSetBtns && formSetBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                const target = e.target,
                    targetSettings = target.dataset.settings,
                    form = target.closest('form');

                switch (targetSettings) {
                    case 'default':
                        setDefaultFields();
                        break;
                    case 'clear':
                        clearFields(form);
                        break;
                    default:
                        console.log('Выбрана несуществующая кнопка');
                }
            });
        })

        const postTitleInput = document.querySelector('#post_title');
        postTitleInput && postTitleInput.addEventListener('change', function () {
            updateURL(document.querySelector('#post_url'), this)
        });

        const catNameInput = document.querySelector('#post_cat_name');
        catNameInput && catNameInput.addEventListener('change', function () {
            updateURL(document.querySelector('#post_cat_url'), this)
        });


        function updateURL(urlField, nameField) {
            if (!urlField || !nameField) return false;
            const nameVal = nameField.value;

            urlField.value = translit(nameVal)
        }

        function getDefaultFieldsArray(type) {
            let defaultArr;
            const defaultArrPost = new Map( [
                ['post_title', 'Заголовок записи'],
                // ['post_date', datePub],
                ['post_date', getDateFormat()],
                ['post_content', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum possimus quaerat quos tempora tenetur? Commodi dolore est incidunt natus necessitatibus odio quas sequi vero voluptatum! Aut consectetur cupiditate debitis deserunt dolor error fugiat harum hic id labore, molestiae nostrum obcaecati, pariatur quibusdam quidem soluta voluptatum. Blanditiis corporis fugit possimus quam?'],
                ['post_excerpt', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, quisquam.'],
                ['post_url', 'zagolovok_zapisi'],
                ['post_cat_name', 'Категория'],
                ['post_cat_url', 'kategoriya'],
            ]);
            const defaultArrPage = new Map( [
                ['post_title', 'Заголовок страницы'],
                // ['post_date', datePub],
                ['post_date', getDateFormat()],
                ['post_content', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum possimus quaerat quos tempora tenetur? Commodi dolore est incidunt natus necessitatibus odio quas sequi vero voluptatum! Aut consectetur cupiditate debitis deserunt dolor error fugiat harum hic id labore, molestiae nostrum obcaecati, pariatur quibusdam quidem soluta voluptatum. Blanditiis corporis fugit possimus quam?'],
                ['post_excerpt', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, quisquam.'],
                ['post_url', 'zagolovok_stranicy'],
                ['post_cat_name', 'Категория'],
                ['post_cat_url', 'kategoriya'],
            ]);
            const defaultArrProd = new Map( [
                ['post_title', 'Заголовок товара'],
                // ['post_date', datePub],
                ['post_date', getDateFormat()],
                ['post_content', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum possimus quaerat quos tempora tenetur? Commodi dolore est incidunt natus necessitatibus odio quas sequi vero voluptatum! Aut consectetur cupiditate debitis deserunt dolor error fugiat harum hic id labore, molestiae nostrum obcaecati, pariatur quibusdam quidem soluta voluptatum. Blanditiis corporis fugit possimus quam?'],
                ['post_excerpt', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat, quisquam.'],
                ['post_url', 'zagolovok_tovara'],
                ['post_cat_name', 'Категория'],
                ['post_cat_url', 'kategoriya'],
            ]);

            switch (type) {
                case 'post':
                    defaultArr = defaultArrPost;
                    break
                case 'page':
                    defaultArr = defaultArrPage
                    break;
                case 'product':
                    defaultArr = defaultArrProd
                    break;
                default:
                    defaultArr = defaultArrPost;
            }

            return defaultArr;
        }

        function setDefaultFields() {
            let defaultArr = [];

            let postTypes = document.querySelectorAll('input[name="post_type"]');
            postTypes && postTypes.forEach(postType => {
                if (postType.checked) {
                    defaultArr = getDefaultFieldsArray(postType.value);
                }
            });

            defaultArr.forEach(function(value,key) {
                let input = document.querySelector('#'+key);
                if (input) input.value = value;
            });
        }

        function clearFields(form) {
            let inputs = form.querySelectorAll('input[type="text"], textarea');
            inputs.forEach(input => {
                input.value = '';
            });
        }

        function getDateFormat() {
            let date = new Date();
            return date.toLocaleString("sv-SE");
        }

        function translit(word){
            var converter = {
                'а': 'a',    'б': 'b',    'в': 'v',    'г': 'g',    'д': 'd',
                'е': 'e',    'ё': 'e',    'ж': 'zh',   'з': 'z',    'и': 'i',
                'й': 'y',    'к': 'k',    'л': 'l',    'м': 'm',    'н': 'n',
                'о': 'o',    'п': 'p',    'р': 'r',    'с': 's',    'т': 't',
                'у': 'u',    'ф': 'f',    'х': 'h',    'ц': 'c',    'ч': 'ch',
                'ш': 'sh',   'щ': 'sch',  'ь': '',     'ы': 'y',    'ъ': '',
                'э': 'e',    'ю': 'yu',   'я': 'ya'
            };

            word = word.toLowerCase();

            var answer = '';
            for (var i = 0; i < word.length; ++i ) {
                if (converter[word[i]] == undefined){
                    answer += word[i];
                } else {
                    answer += converter[word[i]];
                }
            }

            answer = answer.replace(/[^-0-9a-z]/g, '-');
            answer = answer.replace(/[-]+/g, '-');
            answer = answer.replace(/^\-|-$/g, '');
            return answer;
        }
    });

    $( window ).load(function() {
    });

})( jQuery );
