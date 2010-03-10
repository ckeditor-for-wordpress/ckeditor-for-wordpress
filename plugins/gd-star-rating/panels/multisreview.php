<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("RMB", "srTemplateRMB", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Multi Reviews", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srMultiReviewSet" name="srMultiReviewSet" style="width: 200px">
                <option value="0"><?php _e("Default", "gd-star-rating"); ?></option>
                <?php GDSRHelper::render_styles_select($gdst_multis, 1); ?>
            </select>
        </td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Source", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Post ID", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input class="widefat widnumb" style="text-align: right;" size="8" type="text" name="srMultiReviewPostID" id="srMultiReviewPostID" value="0" /></td>
      </tr>
    </table>
</fieldset>

<fieldset>
<legend><?php _e("Elements Stars", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srStarsStyleMRREl" name="srStarsStyleMRREl">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_star_sizes_tinymce("srStarsSizeMRREl"); ?>
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
            <select id="srStarsStyleMRRAv" name="srStarsStyleMRRAv">
                <?php GDSRHelper::render_styles_select($gdsr_styles, 'oxygen'); ?>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Size", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <?php GDSRHelper::render_star_sizes_tinymce("srStarsSizeMRRAv"); ?>
        </td>
      </tr>
    </table>
</fieldset>
