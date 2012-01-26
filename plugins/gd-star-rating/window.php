<?php

    require_once("../../../gd-star-rating/config.php");
    $wpload = get_gdsr_wpload_path();
    require($wpload);
    global $gdsr;
    require_once(STARRATING_PATH."code/adm/db.php");
    require_once(STARRATING_PATH."code/adm/elements.php");

    $gdsr_styles = $gdsr->g->stars;
    $gdsr_thumbs = $gdsr->g->thumbs;
    $gdsr_trends = $gdsr->g->trend;
    $gdst_multis = GDSRDBMulti::get_multis_tinymce();
    $wpv = $gdsr->wp_version;
    $gdsr->load_translation();

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>StarRating</title>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
  <script type="text/javascript">
    var tinyMCEPopup = window.parent.tinyMCEPopup;
  </script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo CKEDITOR_PLUGIN_URL ?>plugins/gd-star-rating/tinymce.js"></script>
  <link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=327-1235100-vvq6.2.14line3" />
  <link rel="stylesheet" href="<?php echo CKEDITOR_PLUGIN_URL ?>plugins/gd-star-rating/ckeditor.css" type="text/css" media="screen" />
  <base target="_self" />
</head>
<body>
<form name="StarRating" action="#">
<div class="tabs">
    <ul>
        <li id="shortcode_tab" class="current"><span><a href="javascript:mcTabs.displayTab('shortcode_tab','shortcode_panel');" onmousedown="return false;"><?php _e("Insert", "gd-star-rating"); ?></a></span></li>
        <li id="general_tab"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;"><?php _e("General", "gd-star-rating"); ?></a></span></li>
        <li id="filter_tab"><span><a href="javascript:mcTabs.displayTab('filter_tab','filter_panel');" onmousedown="return false;"><?php _e("Filter", "gd-star-rating"); ?></a></span></li>
        <li id="styles_tab"><span><a href="javascript:mcTabs.displayTab('styles_tab','styles_panel');" onmousedown="return false;"><?php _e("Graphics", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="multis_tab"><span><a href="javascript:mcTabs.displayTab('multis_tab','multis_panel');" onmousedown="return false;"><?php _e("Multi Rating", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="multisreview_tab"><span><a href="javascript:mcTabs.displayTab('multisreview_tab','multisreview_panel');" onmousedown="return false;"><?php _e("Multi Review", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="articlesreview_tab"><span><a href="javascript:mcTabs.displayTab('articlesreview_tab','articlesreview_panel');" onmousedown="return false;"><?php _e("Articles Review", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="articlesrater_tab"><span><a href="javascript:mcTabs.displayTab('articlesrater_tab','articlesrater_panel');" onmousedown="return false;"><?php _e("Articles Rating Block", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="commentsaggr_tab"><span><a href="javascript:mcTabs.displayTab('commentsaggr_tab','commentsaggr_panel');" onmousedown="return false;"><?php _e("Aggregated Comments", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="blograting_tab"><span><a href="javascript:mcTabs.displayTab('blograting_tab','blograting_panel');" onmousedown="return false;"><?php _e("Blog Rating", "gd-star-rating"); ?></a></span></li>
        <li style="display: none" id="thumbsrating_tab"><span><a href="javascript:mcTabs.displayTab('thumbsrating_tab','thumbsrating_panel');" onmousedown="return false;"><?php _e("Thumbs Rating", "gd-star-rating"); ?></a></span></li>
    </ul>
</div>

<div class="panel_wrapper">

<div id="shortcode_panel" class="panel current">
<fieldset>
<legend><?php _e("Shortcode", "gd-star-rating"); ?></legend>
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
      <tr>
        <td class="gdsrright">
            <label>
                <select onchange="gdsrChangeShortcode('tinymce', <?php echo $wpv; ?>)" id="srShortcode" name="srShortcode" style="width: 200px">
                    <option value="starrating"><?php _e("Results", "gd-star-rating"); ?>: StarRating</option>
                    <option value="blograting"><?php _e("Results", "gd-star-rating"); ?>: BlogRating</option>
                    <option value="starrating">--------------------</option>
                    <option value="starratingmulti"><?php _e("Multi", "gd-star-rating"); ?>: StarRatingMulti</option>
                    <option value="starreviewmulti"><?php _e("Multi", "gd-star-rating"); ?>: StarReviewMulti</option>
                    <option value="starrating">--------------------</option>
                    <option value="starreview"><?php _e("Articles", "gd-star-rating"); ?>: StarReview</option>
                    <option value="starrater"><?php _e("Articles", "gd-star-rating"); ?>: StarRater</option>
                    <option value="starthumbsblock"><?php _e("Articles", "gd-star-rating"); ?>: StarThumbsBlock</option>
                    <option value="starrating">--------------------</option>
                    <option value="starcomments"><?php _e("Comments", "gd-star-rating"); ?>: StarComments</option>
                </select>
            </label>
        </td>
      </tr>
    </table>
</fieldset>
<fieldset>
<legend><?php _e("Shortcode Info", "gd-star-rating"); ?></legend>
<p><?php _e("Change shortcode to see additional options you can set.", "gd-star-rating"); ?></p>
</fieldset>
</div>

<div id="general_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/general.php"); ?>
</div>
<div id="filter_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/filter.php"); ?>
</div>
<div id="styles_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/styles.php"); ?>
</div>

<div id="multis_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/multis.php"); ?>
</div>
<div id="multisreview_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/multisreview.php"); ?>
</div>

<div id="articlesreview_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/articlesreview.php"); ?>
</div>
<div id="articlesrater_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/articlesrater.php"); ?>
</div>

<div id="commentsaggr_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/commentsaggr.php"); ?>
</div>

<div id="blograting_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/blograting.php"); ?>
</div>

<div id="thumbsrating_panel" class="panel">
<?php include(dirname(__FILE__)."/panels/thumbsrating.php"); ?>
</div>

</div>
</form>
</body>
</html>
