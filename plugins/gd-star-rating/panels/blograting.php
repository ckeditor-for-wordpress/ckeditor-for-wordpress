<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("WBR", "srTemplateWBR", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Filter", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Include Articles", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select id="srSelectBR" name="srSelectBR" style="width: 130px">
                <option value="postpage"><?php _e("Posts And Pages", "gd-star-rating"); ?></option>
                <option value="post"><?php _e("Posts Only", "gd-star-rating"); ?></option>
                <option value="page"><?php _e("Pages Only", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Display Votes From", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><select name="srShowBR" id="srShowBR" style="width: 130px">
            <option value="total"><?php _e("Everyone", "gd-star-rating"); ?></option>
            <option value="visitors"><?php _e("Visitors Only", "gd-star-rating"); ?></option>
            <option value="users"><?php _e("Users Only", "gd-star-rating"); ?></option>
        </select></td>
      </tr>
    </table>
</fieldset>
