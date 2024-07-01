<?php

/**
 * Plugin Name: MV Slider
 * Description: Um simples plugin de slider para WordPress
 * Version: 1.0.0
 * Requires at least: 5.6
 * Author: Jonathan Matheus
 * Author URI: https://github.com/jonathan-matheus
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mv-slider
 * Domain Path: /languages
 */

/*
MV Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

MV Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MV Slider. If not, see http://www.gnu.org/licenses/gpl-2.0.html
*/

// Caso o código esteja sendo executado diretamente, aborte a execução
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe principal do plugin com seu construtor
 */
if (!class_exists('MV_Slider')) {
    class MV_Slider
    {
        function __construct()
        {
            // Define as constantes para o plugin
            $this->define_constants();

            add_action('admin_menu', [$this, 'add_menu']);

            require_once MV_SLIDER_PATH . 'post-types/class.mv-slider-cpt.php';
            $MV_Slider_Post_Type = new MV_Slider_Post_Type();
        }

        /**
         * Define as constantes do plugin.
         *
         * Esta função define três constantes:
         * - MV_SLIDER_PATH: O caminho absoluto do plugin.
         * - MV_SLIDER_URL: O URL absoluto do plugin.
         * - MV_SLIDER_VERSION: A versão do plugin.
         *
         * @return void
         */
        public function define_constants()
        {
            // Constante para o caminho absoluto do plugin
            define('MV_SLIDER_PATH', plugin_dir_path(__FILE__));

            // Constante para o caminho absoluto do URL do plugin
            define('MV_SLIDER_URL', plugin_dir_url(__FILE__));

            // Constante que define a versão do plugin
            define('MV_SLIDER_VERSION', '1.0.0');
        }

        /**
         * Ativa o plugin atualizando a opção de regras de reescrita.
         *
         * Esta função atualiza a opção 'rewrite_rules' definindo-a como uma 
         * string vazia.
         *
         * @return void
         */
        public static function activate()
        {
            update_option('rewrite_rules', '');
        }

        /**
         * Desativa o plugin, limpando as regras de redirecionamento.
         *
         * Esta função é responsável por desativar o plugin, limpando as regras 
         * de redirecionamento. Certifica que quaisquer alterações feitas nas 
         * regras de redirecionamento durante a ativação são limpas e aplicadas.
         *
         * @return void
         */
        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('mv-slider');
        }

        public static function uninstall()
        {
        }

        public function add_menu()
        {
            add_menu_page(
                'MV Slider Options',
                'MV Slider',
                'manage_options',
                'mv_slider_admin',
                [$this, 'mv_slider_settings_page'],
                'dashicons-images-alt2',
            );
        }

        public function mv_slider_settings_page()
        {
            echo "This is a test page";
        }
    }
}

/**
 * Instancie a classe MV Slider
 */
if (class_exists('MV_Slider')) {
    register_activation_hook(__FILE__, ['MV_Slider', 'activate']);
    register_deactivation_hook(__FILE__, ['MV_Slider', 'deactivate']);
    register_uninstall_hook(__FILE__, ['MV_Slider', 'uninstall']);
    $mv_slider = new MV_Slider();
}
