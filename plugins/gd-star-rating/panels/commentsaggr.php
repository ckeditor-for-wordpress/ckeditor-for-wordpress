<fieldset>
<legend><?php _e("Aggregated Comments Ratings", "gd-star-rating"); ?></legend>
<p><?php _e("This will render aggregated comments rating for the post.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("CAR", "srTemplateCAR", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Filter", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Calculate Votes From", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><select name="srCagShow" id="srCagShow" style="width: 130px">
            <option value="total"><?php _e("Everyone", "gd-star-rating"); ?></option>
            <option value="visitors"><?php _e("Visitors Only", "gd-star-rating"); ?></option>
            <option value="users"><?php _e("Users Only", "gd-star-rating"); ?></option>
        </select></td>
      </tr>
    </table>
</fieldset>
