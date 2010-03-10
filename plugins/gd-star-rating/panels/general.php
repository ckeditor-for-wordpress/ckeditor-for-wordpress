<fieldset>
<legend><?php _e("Display", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Number Of Posts", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><input class="widefat widnumb" type="text" size="8" id="srRows" name="srRows" value="10" /></td>
      </tr>
      <tr>
        <td class="gdsrleft"><?php _e("Items Grouping", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="srGrouping" id="srGrouping" style="width: 130px" onchange="gdsrChangeTaxonomy(this.options[this.selectedIndex].value, 'tinymce')">
                <option value="post"><?php _e("No grouping", "gd-star-rating"); ?></option>
                <option value="user"><?php _e("User based", "gd-star-rating"); ?></option>
                <option value="category"><?php _e("Category based", "gd-star-rating"); ?></option>
                <option value="taxonomy"><?php _e("Taxonomy based", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-src-tax[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Taxonomy", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><select name="srTaxonomy" id="srTaxonomy" style="width: 130px"><?php GDSRHelper::render_taxonomy_select(); ?></select></td>
      </tr>
    </table>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Source", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Data Source", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="srDataSource" style="width: 130px" id="srDataSource" onchange="gdsrChangeSource(this.options[this.selectedIndex].value, 'tinymce')">
                <option value="standard"><?php _e("Standard Rating", "gd-star-rating"); ?></option>
                <?php if (count($gdst_multis) > 0) { ?><option value="multis"><?php _e("Multi Rating", "gd-star-rating"); ?></option><?php } ?>
                <option value="thumbs"><?php _e("Thumbs Rating", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-src-multi[tinymce]" style="display: none">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Multi Set", "gd-star-rating"); ?>:</td>
        <td class="gdsrright"><select name="srMultiSet" id="srMultiSet"><?php GDSRHelper::render_styles_select($gdst_multis); ?></select></td>
      </tr>
    </table>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Trend", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Rating trend display as", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="trendRating" style="width: 110px" id="trendRating" onchange="gdsrChangeTrend('tr', this.options[this.selectedIndex].value, 'tinymce')">
                <option value="txt"><?php _e("Text", "gd-star-rating"); ?></option>
                <option value="img"><?php _e("Image", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-tr-txt[tinymce]" style="display: block">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrreg"><?php _e("Up", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingRise" id="trendRatingRise" value="+" /></td>
            <td class="gdsrspc"></td>
            <td class="gdsrreg"><?php _e("Equal", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingSame" id="trendRatingSame" value="=" /></td>
            <td class="gdsrspc"></td>
            <td class="gdsrreg"><?php _e("Down", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendRatingFall" id="trendRatingFall" value="-" /></td>
          </tr>
        </table>
    </div>
    <div id="gdsr-tr-img[tinymce]" style="display: none">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"><?php _e("Image set", "gd-star-rating"); ?>:</td>
            <td class="gdsrright">
                <select name="trendRatingSet" id="trendRatingSet">
                    <?php GDSRHelper::render_styles_select($gdsr_trends); ?>
                </select>
            </td>
          </tr>
        </table>
    </div>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrleft"><?php _e("Voting trend display as", "gd-star-rating"); ?>:</td>
        <td class="gdsrright">
            <select name="trendVoting" style="width: 110px" id="trendVoting" onchange="gdsrChangeTrend('tv', this.options[this.selectedIndex].value, 'tinymce')">
                <option value="txt"><?php _e("Text", "gd-star-rating"); ?></option>
                <option value="img"><?php _e("Image", "gd-star-rating"); ?></option>
            </select>
        </td>
      </tr>
    </table>
    <div id="gdsr-tv-txt[tinymce]" style="display: block">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrreg"><?php _e("Up", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingRise" id="trendVotingRise" value="+" /></td>
            <td class="gdsrspc"></td>
            <td class="gdsrreg"><?php _e("Equal", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingSame" id="trendVotingSame" value="=" /></td>
            <td class="gdsrspc"></td>
            <td class="gdsrreg"><?php _e("Down", "gd-star-rating"); ?>:</td>
            <td width="40" class="gdsrright"><input class="widefat" style="width: 35px" type="text" name="trendVotingFall" id="trendVotingFall" value="-" /></td>
          </tr>
        </table>
    </div>
    <div id="gdsr-tv-img[tinymce]" style="display: none">
        <table border="0" cellpadding="3" cellspacing="0" width="100%">
          <tr>
            <td class="gdsrleft"><?php _e("Image set", "gd-star-rating"); ?>:</td>
            <td class="gdsrright">
                <select name="trendVotingSet" id="trendVotingSet">
                    <?php GDSRHelper::render_styles_select($gdsr_trends); ?>
                </select>
            </td>
          </tr>
        </table>
    </div>
</fieldset>

<fieldset>
<legend><?php _e("Hiding", "gd-star-rating"); ?></legend>
    <input type="checkbox" size="5" id="srHidemptyBayes" name="srHidemptyBayes" value="on" /><label for="srHidemptyBayes"> <?php _e("Bayesian minumum votes required.", "gd-star-rating"); ?></label><br />
    <input type="checkbox" size="5" id="srHidempty" name="srHidempty" checked value="on" /><label for="srHidempty"> <?php _e("Hide articles with no recorded votes.", "gd-star-rating"); ?></label><br />
    <input type="checkbox" size="5" id="srHidemptyReview" name="srHidemptyReview" value="on" /><label for="srHidemptyReview"> <?php _e("Hide articles with no review values.", "gd-star-rating"); ?></label>
</fieldset>
