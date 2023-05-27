<?php
$plugin_admin = new Post_Creator_Public('','');

?>

<div class="tabs-radio">
    <ul>
        <li>
            <label class="pk-radio">
                <input class="radio-select" type="radio" name="creating_type" data-tab="fast" checked="">
                <span>Быстрое создание</span>
            </label>
        </li>
        <li>
            <label class="pk-radio">
                <input class="radio-select" type="radio" name="creating_type" data-tab="advanced">
                <span>Продвинутое создание</span>
            </label>
        </li>
    </ul>
    <div class="radio-panel" data-panel="fast">
        <form id="simple_creating">
            <div class="form_section form_section--posts">
                <h2 class="form_section__title">Основные параметры</h2>

                <div class="form_area">

                    <div class="form_field form_field--full">
                        <label for="count_posts">Количествово постов</label>
                        <input type="number" id="count_posts" min="1" max="100" name="count_posts" required>
                    </div>

                    <?php
                    $post_types = get_post_types([ 'publicly_queryable'=>1 ] );

                    if (!empty($post_types)):
                        $post_types['page'] = 'page';
                        unset( $post_types['attachment'] ); ?>
                        <div class="form_field form_field--full">
                            <div class="form-field__label">Выберите категорию</div>
                            <ul>
                            <?php
                            $num = 1;
                            foreach ($post_types as $key => $type):
                                $obj = get_post_type_object( $type );
                                $post_name = $obj->labels->name;

                                echo '<li><label class="pk-radio">
                                                <input type="radio" name="post_type" value="'.$obj->name.'" '.($num++ == 1 ? ' checked' : '').'>
                                                <span>'.$post_name.'</span>
                                            </label></li>';
                            endforeach;?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <div class="form_section form_section--presets">
                <h2 class="form_section__title">Предустановки</h2>

                <div class="form_section__btns">
                    <div class="button button-primary" data-settings="default">По умолчанию</div>
                    <div class="button button-primary" data-settings="clear">Очистить все поля</div>
                </div>
            </div>

            <hr>

            <div class="form_section form_section--posts">

                <h2 class="form_section__title">Поля для типа записи</h2>

                <div class="form_area">

                    <div class="form_field form_field--half">
                        <label for="post_title">Заголовок</label>
                        <input type="text" id="post_title" name="post_title" required>
                    </div>

                    <div class="form_field form_field--half">
                        <label for="post_url">Ярлык записи

                            <span class="tooltip" data-tippy-content="«Ярлык» — это вариант названия, подходящий для URL. Обычно содержит только латинские буквы в нижнем регистре, цифры и дефисы.">
                                <svg class="tooltip_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="currentColor">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16ZM8 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1 3v4a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0Z"></path>
                                </svg>
                            </span>
                        </label>
                        <input type="text" id="post_url" name="post_url" required>
                    </div>


                    <div class="form_field form_field--half">
                        <label for="post_excerpt">Краткое описание</label>
                        <textarea id="post_excerpt" name="post_excerpt"></textarea>
                    </div>

                    <div class="form_field form_field--half">
                        <label for="post_content">Полное описание</label>
                        <textarea id="post_content" name="post_content"></textarea>
                    </div>

                    <div class="form_field form_field--half">
                        <div class="form-field__label">Выберите категорию</div>
                        <div class="form_field__cat-list">
                            <?php
                            $categories = get_terms('category', ['hide_empty' => false]);
                            $cat_hierarchy = [];
                            $plugin_admin->display_category_selector('category');
                            ?>
                        </div>
                    </div>

                </div>

            </div>


            <input type="hidden" name="action" value="create_posts" />
            <?php wp_nonce_field( 'create_posts__nonce' ); ?>
            <button class="button button-primary">Создать</button>
        </form>
    </div>
    <div class="radio-panel" data-panel="advanced" style="display:none;">
        2
    </div>
</div>
<?php

