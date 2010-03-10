<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("MRB", "srTemplateMRB", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Multi Ratings", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srMultiRatingSet" name="srMultiRatingSet" style="width: 200px">
                <?php GDSRHelper::render_styles_select($gdst_multis, 1); ?>
            </select>
        </td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Settings", "gd-star-rating"); ?></legend>
    <input type="checkbox" size="5" id="srMultiRead" name="srMultiRead" /><label for="srMultiRead"> <?php _e("Display rating block as read only.", "gd-star-rating"); ?></label><br />
</fieldset>

<fieldset>
<legend><?php _e("Elements Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srStarsStyleMUREl" name="srStarsStyleMUREl">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_star_sizes_tinymce("srStarsSizeMUREl"); ?>
        </td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Average Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srStarsStyleMURAv" name="srStarsStyleMURAv">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_star_sizes_tinymce("srStarsSizeMURAv"); ?>
        </td>
      </tr>
    </table>
</fieldset>
