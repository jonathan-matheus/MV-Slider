<?php
if (!class_exists('MV_Slider_Settings')) {
    class MV_Slider_Settings
    {
        public static $options;
        public function __construct()
        {
            self::$options = get_option('mv_slider_options');
            add_action('admin_init', [$this, 'admin_init']);
        }

        /**
         * Função admin_init para inicializar as configurações do slider.
         */
        public function admin_init()
        {
            register_setting(
                'mv_slider_group',
                'mv_slider_options'
            );

            add_settings_section(
                'mv_slider_main_section',
                'How does it work?',
                null,
                'mv_slider_page1'
            );

            add_settings_section(
                'mv_slider_second_section',
                'Other Plugin Options',
                null,
                'mv_slider_page2'
            );

            add_settings_field(
                'mv_slider_shortcode',
                'Shortcode',
                [$this, 'mv_slider_shortcode_callback'],
                'mv_slider_page1',
                'mv_slider_main_section'
            );

            add_settings_field(
                'mv_slider_title',
                'Slider Title',
                [$this, 'mv_slider_title_callback'],
                'mv_slider_page2',
                'mv_slider_second_section',
                [
                    'label_for' => 'mv_slider_title'
                ]
            );

            add_settings_field(
                'mv_slider_bullets',
                'Display Bullets',
                [$this, 'mv_slider_bullets_callback'],
                'mv_slider_page2',
                'mv_slider_second_section',
                [
                    'label_for' => 'mv_slider_bullets'
                ]
            );

            add_settings_field(
                'mv_slider_style',
                'Slider Style',
                [$this, 'mv_slider_style_callback'],
                'mv_slider_page2',
                'mv_slider_second_section',
                [
                    'items' => [
                        'style-1',
                        'style-2'
                    ],
                    'label_for' => 'mv_slider_style'
                ]
            );
        }

        /**
         * Função de retorno para exibir o shortcode [mv_slider] para exibição 
         * do slider em qualquer página/post/widget.
         */
        public function mv_slider_shortcode_callback()
        {
?>
            <span>Use the shortcode [mv_slider] to display the slider in any page/post/widget</span>
        <?php
        }

        public function mv_slider_title_callback($args)
        {
            echo '<input type="text" id="mv_slider_title" name="mv_slider_options[title]" value="' . self::$options['title'] . '" />';
        }

        public function mv_slider_second_section()
        {
        ?>
            <input type="text" name="mv_slider_options[mv_slider_title]" id="mv_slider_title" value="<?php echo isset(self::$options['mv_slider_title']) ? esc_attr(self::$options['mv_slider_title']) : ''; ?>">
        <?php
        }

        public function mv_slider_bullets_callback($args)
        {
        ?>
            <input type="checkbox" name="mv_slider_options[mv_slider_bullets]" id="mv_slider_bullets" value="1" <?php
                                                                                                                if (isset(self::$options['mv_slider_bullets'])) {
                                                                                                                    checked("1", self::$options['mv_slider_bullets'], true);
                                                                                                                } ?>>
            <label for="mv_slider_bullets">Whether to display bullets or not</label>
        <?php
        }

        public function mv_slider_style_callback($args)
        {
        ?>
            <select name="mv_slider_options[mv_slider_style]" id="mv_slider_style">
                <?php
                foreach ($args['items'] as $item) {
                ?>
                    <option value="<?= esc_attr($item) ?>" <?php isset(self::$options['mv_slider_style']) ? selected($item, self::$options['mv_slider_style']) : ''; ?>>
                        <?= esc_html(ucfirst($item)) ?>
                    </option>
                <?php
                }
                ?>
            </select>
<?php
        }
    }
}
