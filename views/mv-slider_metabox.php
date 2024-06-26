<?php
$slider_text = get_post_meta($post->ID, 'mv_slider_link_text', true);
$slider_url = get_post_meta($post->ID, 'mv_slider_link_url', true);
?>

<table class="form-table mv-slider-metabox">
    <tr>
        <th>
            <label for="mv_slider_link_text">Link Text</label>
        </th>
        <td>
            <input type="text" name="mv_slider_link_text" id="mv_slider_link_text" class="regular-text link-text" value="<?= $slider_text ?>" required>
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