<!-- 
Essa div com a classe wrap e uma div padrão de toda página de plugin
-->
<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <!-- 
    O formulário deve sempre enviar para o arquivo options.php que e um arquivo
    padrão do WordPress para processamento de dados do formulário
    -->
    <form action="options.php" method="post">
        <?php
        settings_fields('mv_slider_group');
        do_settings_sections('mv_slider_page1');
        submit_button('Save Settings');
        ?>
    </form>
</div>