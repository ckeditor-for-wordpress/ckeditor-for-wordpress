<fieldset>
<legend><?php _e("Thumbs Rating Block", "gd-star-rating"); ?></legend>
<p><?php _e("StarRater will render actual rating block if you choose not to have it automatically inserted. This way you can position it wherever you want in the contnents.", "gd-star-rating"); ?></p>
</fieldset>

<fieldset>
<legend><?php _e("Template", "gd-star-rating"); ?></legend>
    <?php gdTemplateHelper::render_templates_section("TAB", "srThumbsTemplate", 0, 300); ?>
</fieldset>

<fieldset>
<legend><?php _e("Settings", "gd-star-rating"); ?></legend>
    <input type="checkbox" size="5" id="srThumbsRead" name="srThumbsRead" /><label for="srThumbsRead"> <?php _e("Display rating block as read only.", "gd-star-rating"); ?></label><br />
</fieldset>
