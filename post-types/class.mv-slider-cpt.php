<?php
if (!class_exists('MV_Slider_Post_Type')) {
    class MV_Slider_Post_Type
    {
        function __construct()
        {
            add_action('init', [
                $this, 'create_post_type'
            ]);

            add_action('add_meta_boxes', [
                $this, 'add_meta_boxes'
            ]);
        }

        public function create_post_type()
        {
            register_post_type(
                'mv-slider',
                [
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => [
                        'name' => 'Sliders',
                        'singular_name' => 'Slider',
                    ],
                    'public' => true,
                    'supports' => [
                        'title',
                        'editor',
                        'thumbnail'
                    ],
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-slides',
                ]
            );
        }

        public function add_meta_boxes()
        {
            add_meta_box(
                'mv_slider_meta_box',
                'Link Options',
                [$this, 'add_inner_meta_boxes'],
                'mv-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes($post)
        {
            require_once MV_SLIDER_PATH . 'views/mv-slider_metabox.php';
        }
    }
}
