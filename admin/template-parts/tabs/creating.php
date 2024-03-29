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

                <div class="form_area form_area-three-col">

                    <div class="form_field">
                        <label for="count_posts">Количествово постов</label>
                        <input type="number" id="count_posts" min="1" max="100" name="count_posts" required>
                    </div>

                    <?php
                    $post_types = get_post_types([ 'publicly_queryable'=>1 ] );

                    if (!empty($post_types)):
                        $post_types['page'] = 'page';
                        unset( $post_types['attachment'] ); ?>
                        <div class="form_field">
                            <div class="form-field__label">Тип поста</div>
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

                    <div class="form_field">
                        <div class="form-field__label">Статус поста</div>
                        <ul>
                            <li>
                                <label class="pk-radio">
                                    <input type="radio" name="post_status" value="publish" checked>
                                    <span>Опубликовать</span>
                                </label>
                            </li>
                            <li>
                                <label class="pk-radio">
                                    <input type="radio" name="post_status" value="draft">
                                    <span>В черновик</span>
                                </label>
                            </li>
                        </ul>
                    </div>

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

                <div class="form_area form_area-two-col">

                    <div class="form_field form_field--half">
                        <label for="post_title">Заголовок</label>
                        <input type="text" id="post_title" name="post_title" required>
                    </div>

                    <div class="form_field form_field--half">
                        <label>Изображение записей</label>
                        <div class="thumb-add">
                            <div class="thumb-add__wrapper">
                                <input type="hidden" name="post_image" id="post_image" value="" />
                                <div type="submit" class="upload_image_button button">Добавить изображение</div>
                                <div type="submit" class="remove_image_button button">×</div>
                            </div>
                            <div class="thumb-add__img upload_image_button"></div>
                        </div>
                    </div>


                    <div class="form_field form_field--half">
                        <label for="post_excerpt">Краткое описание</label>
                        <textarea id="post_excerpt" name="post_excerpt"></textarea>
                    </div>

                    <div class="form_field form_field--half">
                        <label for="post_content">Полное описание</label>
                        <textarea id="post_content" name="post_content"></textarea>
                    </div>

                    <div id="cat-select" class="form_field form_field--half">
                        <div class="form-field__label">Выберите категорию</div>
                        <div class="form_field__cat-list">
                            <?php $plugin_admin->display_category_selector('post'); ?>
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

