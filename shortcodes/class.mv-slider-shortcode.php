<?php
if (!class_exists('MV_Slider_Shortcode')) {
    class MV_Slider_Shortcode
    {
        public function __construct()
        {
            add_shortcode('mv_slider', [$this, 'add_shortcode']);
        }

        public function add_shortcode($atts = [], $content = null, $tag = '')
        {
            $atts = array_change_key_case((array) $atts, CASE_LOWER);
            extract(
                shortcode_atts(
                    [
                        'id' => '',
                        'orderby' => 'date'
                    ],
                    $atts,
                    $tag
                )
            );

            if (!empty($id)) {
                $id = array_map('absint', explode(',', $id));
            }

            ob_start();
            require MV_SLIDER_PATH . 'views/mv-slider_shortcode.php';
            return ob_get_clean();
        }
    }
}