<fieldset>
<legend><?php _e("Articles Review Rating", "gd-star-rating"); ?></legend>
<p><?php _e("StarReview will render stars representing review value assigned to the post or page.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("RSB", "srTemplateRSB", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Source", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Post ID", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input class="widefat widnumb" style="text-align: right;" size="8" type="text" name="srRVWPostID" id="srRVWPostID" value="0" /></td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Review Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srRVWStarsStyle" name="srRVWStarsStyle">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_star_sizes_tinymce("srRVWStarsSize"); ?>
        </td>
      </tr>
    </table>
</fieldset>
