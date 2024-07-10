<?php
$slider_text = esc_html(get_post_meta($post->ID, 'mv_slider_link_text', true));
$slider_text = isset($slider_text) ? $slider_text : '';

$slider_url = esc_url(get_post_meta($post->ID, 'mv_slider_link_url', true));
$slider_url = isset($slider_url) ? $slider_url : '';
?>

<table class="form-table mv-slider-metabox">
    <input type="hidden" name="mv_slider_nonce" value="<?= wp_create_nonce('mv-slider-nonce') ?>">
    <tr>
        <th>
            <label for="mv_slider_link_text">Link Text</label>
        </th>
        <td>
            <input type="text" name="mv_slider_link_text" id="mv_slider_link_text" class="regular-text link-text" value="<?= $slider_text ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="mv_slider_link_url">Link URL</label>
        </th>
        <td>
            <input type="url" name="mv_slider_link_url" id="mv_slider_link_url" class="regular-text link-url" value="<?= $slider_url ?>" required>
        </td>
    </tr>
</table>