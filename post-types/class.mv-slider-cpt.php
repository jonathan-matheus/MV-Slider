<?php
if (!class_exists('MV_Slider_Post_Type')) {
    class MV_Slider_Post_Type
    {
        function __construct()
        {
            add_action('init', [
                $this,
                'create_post_type'
            ]);

            add_action('add_meta_boxes', [
                $this,
                'add_meta_boxes'
            ]);

            add_action(
                'save_post',
                [
                    $this,
                    'save_post'
                ],
                10,
                2
            );

            /**
             * Adiciona um filtro para gerenciar as colunas da postagem.
             * 
             * Importante: O primeiro argumento desta função deve ser sempre
             * 'manage_mv-slider_posts_columns', a logica do nome e 'manage_' +
             * 'nome do tipo de postagem + '_sortable_columns' 
             */
            add_filter(
                'manage_mv-slider_posts_columns',
                [$this, 'mv_slider_cpt_columns']
            );

            /**
             * Adiciona o conteúdo da caixa de metadados ao tipo de postagem
             * 
             * Importante: O primeiro argumento desta função deve ser sempre
             * 'manage_mv-slider_posts_custom_column', a logica do nome e 
             * 'manage_' + 'nome do tipo de postagem + '_posts_custom_column'
             */
            add_action(
                'manage_mv-slider_posts_custom_column',
                [$this, 'mv_slider_custom_columns'],
                10
            );

            /**
             * Adiciona a opção de ordenar as colunas da postagem.
             * 
             * Importante: O primeiro argumento desta função deve ser sempre
             * 'manage_edit-mv-slider_sortable_columns', a logica do nome e 
             * 'manage_edit_' + 'nome do tipo de postagem + '_sortable_columns'
             */
            add_filter(
                'manage_edit-mv-slider_sortable_columns',
                [$this, 'mv_slider_sortable_columns']
            );
        }

        /**
         * Registra o tipo de postagem personalizado para o slider.
         */
        public function create_post_type()
        {
            register_post_type(
                'mv-slider',
                [
                    'label' => esc_html__('Slider', 'mv-slider'),
                    'description' => esc_html__('Sliders', 'mv-slider'),
                    'labels' => [
                        'name' => __('Sliders', 'mv-slider'),
                        'singular_name' => esc_html__('Slider', 'mv-slider'),
                    ],
                    'public' => true,
                    'supports' => [
                        'title',
                        'editor',
                        'thumbnail'
                    ],
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true
                ]
            );
        }

        /**
         * Registra as colunas personalizadas para o tipo de postagem 'mv-slider'.
         *
         * @param array $columns Array contendo as colunas existentes.
         * @return array Colunas atualizadas com 'Link Text' e 'Link URL'.
         */
        public function mv_slider_cpt_columns($columns)
        {
            $columns['mv_slider_link_text'] = esc_html__('Link Text', 'mv-slider');
            $columns['mv_slider_link_url'] = esc_html__('Link URL', 'mv-slider');
            return $columns;
        }

        /**
         * Exibe o conteúdo das colunas personalizadas para o tipo de post 
         * 'mv-slider'.
         *
         * @param string $column O nome da coluna.
         * @return void
         */
        public function mv_slider_custom_columns($column)
        {
            if ($column == 'mv_slider_link_text') {
                echo esc_html(
                    get_post_meta(
                        get_the_ID(),
                        'mv_slider_link_text',
                        true
                    )
                );
            } elseif ($column == 'mv_slider_link_url') {
                echo esc_url(
                    get_post_meta(
                        get_the_ID(),
                        'mv_slider_link_url',
                        true
                    )
                );
            }
        }

        /**
         * Adiciona colunas ordenáveis ao tipo de post 'mv_slider'.
         *
         * @param array $columns As colunas atuais.
         * @return array As colunas atualizadas.
         */
        public function mv_slider_sortable_columns($columns)
        {
            $columns['mv_slider_link_text'] = 'mv_slider_link_text';
            $columns['mv_slider_link_url'] = 'mv_slider_link_url';
            return $columns;
        }

        /**
         * Adiciona uma caixa de metadados ao tipo de postagem 'mv-slider'.
         *
         * @return void
         */
        public function add_meta_boxes()
        {
            add_meta_box(
                'mv_slider_meta_box',
                esc_html__('Link Options'),
                [$this, 'add_inner_meta_boxes'],
                'mv-slider',
                'normal',
                'high'
            );
        }

        /**
         * Adiciona o conteúdo da caixa de metadados ao tipo de postagem 
         * 'mv-slider'.
         *
         * @param datatype $post O objeto de postagem.
         * @return void
         */
        public function add_inner_meta_boxes($post)
        {
            require_once MV_SLIDER_PATH . 'views/mv-slider_metabox.php';
        }

        /**
         * Verifica se o nonce e valido, caso não seja valido, retorna(nada).
         * 
         * Verifica se o WordPress está realizando autosave, caso esteja, 
         * retorna(nada).
         * 
         * Verifica se o usuário que esta realizando a ação tem permissão para
         * editar página ou postagem. Caso não, retorna(nada).
         *  
         * Salva os dados do post quando a ação 'editpost' está definida no 
         * array $_POST. 
         * 
         * Se o campo 'mv_slider_link_text' estiver vazio, 
         * define o campo de metadados 'mv_slider_link_text' como 
         * 'Adicione um texto'. Caso contrário, sanitiza a entrada e atualiza o 
         * campo de metadados 'mv_slider_link_text'.
         *
         * Se o campo 'mv_slider_link_url' estiver vazio, define o campo de 
         * metadados 'mv_slider_link_url' como '#'. Caso contrário, sanitiza a 
         * entrada e atualiza o campo de metadados 'mv_slider_link_url'.
         *
         * @param int $post_id O ID do post sendo salvo.
         * @return void
         */
        public function save_post($post_id)
        {
            if (isset($_POST['mv-slider-nonce'])) {
                if (!wp_verify_nonce($_POST['mv-slider-nonce'], 'mv-slider-nonce')) {
                    return;
                }
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (isset($_POST['post_type']) && $_POST['post_type'] == 'mv-slider') {
                if (!current_user_can('edit_page', $post_id)) {
                    return;
                } else if (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                if (empty($_POST['mv_slider_link_text'])) {
                    update_post_meta(
                        $post_id,
                        'mv_slider_link_text',
                        esc_html__('Add some text')
                    );
                } else {
                    update_post_meta(
                        $post_id,
                        'mv_slider_link_text',
                        sanitize_text_field($_POST['mv_slider_link_text'])
                    );
                }

                if (empty($_POST['mv_slider_link_url'])) {
                    update_post_meta(
                        $post_id,
                        'mv_slider_link_url',
                        '#'
                    );
                } else {
                    update_post_meta(
                        $post_id,
                        'mv_slider_link_url',
                        sanitize_text_field($_POST['mv_slider_link_url'])
                    );
                }
            }
        }
    }
}
