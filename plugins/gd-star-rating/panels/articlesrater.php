<fieldset>
<legend><?php _e("Articles Rating Block", "gd-star-rating"); ?></legend>
<p><?php _e("StarRater will render actual rating block if you choose not to have it automatically inserted. This way you can position it wherever you want in the contnents.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("SRB", "srRatingBlockTemplate", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Settings", "gd-star-rating"); ?></legend>
    <input type="checkbox" size="5" id="srArticleRead" name="srArticleRead" /><label for="srArticleRead"> <?php _e("Display rating block as read only.", "gd-star-rating"); ?></label><br />
</fieldset>

<fieldset>
<legend><?php _e("Rating Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srRTGStarsStyle" name="srRTGStarsStyle">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <label><?php GDSRHelper::render_star_sizes_tinymce("srRTGStarsSize"); ?></label>
        </td>
      </tr>
    </table>
</fieldset>
