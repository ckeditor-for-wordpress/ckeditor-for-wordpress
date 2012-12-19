<?php

// look up for the path
//require_once( dirname( dirname( dirname(__FILE__) ) ) . '/ngg-config.php');
require_once('../../../nextgen-gallery/ngg-config.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
  wp_die(__("You are not allowed to be here"));

global $wpdb, $nggdb;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>NextGEN Gallery</title>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
    <script type="text/javascript">
    var tinyMCEPopup = window.parent.tinyMCEPopup;
  </script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo CKEDITOR_PLUGIN_URL ?>plugins/nggallery/tinymce.js"></script>
  <link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=327-1235100-vvq6.2.14line3" />
  <base target="_self" />
</head>
<body id="link">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
  <form name="NextGEN" action="#">
  <div class="tabs">
    <ul>
      <li id="gallery_tab" class="current"><span><a href="javascript:mcTabs.displayTab('gallery_tab','gallery_panel');" onmousedown="return false;"><?php echo _n( 'Gallery', 'Galleries', 1, 'nggallery' ) ?></a></span></li>
      <li id="album_tab"><span><a href="javascript:mcTabs.displayTab('album_tab','album_panel');" onmousedown="return false;"><?php echo _n( 'Album', 'Albums', 1, 'nggallery' ) ?></a></span></li>
      <li id="singlepic_tab"><span><a href="javascript:mcTabs.displayTab('singlepic_tab','singlepic_panel');" onmousedown="return false;"><?php _e('Picture', 'nggallery'); ?></a></span></li>
    </ul>
  </div>

  <div class="panel_wrapper">
    <!-- gallery panel -->
    <div id="gallery_panel" class="panel current">
    <br />
    <table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="gallerytag"><?php _e("Select gallery", 'nggallery'); ?></label></td>
            <td><select id="gallerytag" name="gallerytag" style="width: 200px">
                <option value="0"><?php _e("No gallery", 'nggallery'); ?></option>
        <?php
          $gallerylist = $nggdb->find_all_galleries('gid', 'DESC');
          if (is_array($gallerylist)) {
            foreach($gallerylist as $gallery) {
              $name = ( empty($gallery->title) ) ? $gallery->name : $gallery->title;
              echo '<option value="' . $gallery->gid . '" >' . $gallery->gid . ' - ' . $name . '</option>' . "\n";
            }
          }
        ?>
            </select></td>
          </tr>
          <tr>
            <td nowrap="nowrap" valign="top"><label for="showtype"><?php _e("Show as", 'nggallery'); ?></label></td>
            <td><label><input name="showtype" type="radio" value="nggallery" checked="checked" /> <?php _e('Image list', 'nggallery') ;?></label><br />
      <label><input name="showtype" type="radio" value="slideshow"  /> <?php _e('Slideshow', 'nggallery') ;?></label><br />
      <label><input name="showtype" type="radio" value="imagebrowser"  /> <?php _e('Imagebrowser', 'nggallery') ;?></label></td>
          </tr>
        </table>
    </div>
    <!-- gallery panel -->

    <!-- album panel -->
    <div id="album_panel" class="panel">
    <br />
    <table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="albumtag"><?php _e("Select album", 'nggallery'); ?></label></td>
            <td><select id="albumtag" name="albumtag" style="width: 200px">
                <option value="0"><?php _e("No album", 'nggallery'); ?></option>
        <?php
          $albumlist = $wpdb->get_results("SELECT * FROM $wpdb->nggalbum ORDER BY id DESC");
          if (is_array($albumlist)) {
            foreach($albumlist as $album) {
              echo '<option value="' . $album->id . '" >' . $album->id . ' - ' . $album->name . '</option>'."\n";
            }
          }
        ?>
            </select></td>
          </tr>
          <tr>
            <td nowrap="nowrap" valign="top"><label for="showtype"><?php _e("Show as", 'nggallery'); ?></label></td>
            <td><label><input name="albumtype" type="radio" value="extend" checked="checked" /> <?php _e('Extended version', 'nggallery') ;?></label><br />
      <label><input name="albumtype" type="radio" value="compact"  /> <?php _e('Compact version', 'nggallery') ;?></label></td>
          </tr>
        </table>
    </div>
    <!-- album panel -->

    <!-- single pic panel -->
    <div id="singlepic_panel" class="panel">
    <br />
    <table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="singlepictag"><?php _e("Select picture", 'nggallery'); ?></label></td>
            <td><select id="singlepictag" name="singlepictag" style="width: 200px">
                <option value="0"><?php _e("No picture", 'nggallery'); ?></option>
        <?php
          $picturelist = $wpdb->get_results("SELECT * FROM $wpdb->nggpictures ORDER BY pid DESC");
          if (is_array($picturelist)) {
            foreach($picturelist as $picture) {
              echo '<option value="' . $picture->pid . '" >'. $picture->pid . ' - ' . $picture->filename.'</option>'."\n";
            }
          }
        ?>
            </select></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><?php _e("Width x Height", 'nggallery'); ?></td>
            <td><input type="text" size="5" id="imgWidth" name="imgWidth" value="320" /> x <input type="text" size="5" id="imgHeight" name="imgHeight" value="240" /></td>
          </tr>
          <tr>
            <td nowrap="nowrap" valign="top"><?php _e("Effect", 'nggallery'); ?></td>
            <td>
        <label><select id="imgeffect" name="imgeffect">
          <option value="none"><?php _e("No effect", 'nggallery'); ?></option>
          <option value="watermark"><?php _e("Watermark", 'nggallery'); ?></option>
          <option value="web20"><?php _e("Web 2.0", 'nggallery'); ?></option>
        </select></label>
      </td>
          </tr>
          <tr>
            <td nowrap="nowrap" valign="top"><?php _e("Float", 'nggallery'); ?></td>
            <td>
        <label><select id="imgfloat" name="imgfloat">
          <option value=""><?php _e("No float", 'nggallery'); ?></option>
          <option value="left"><?php _e("Left", 'nggallery'); ?></option>
          <option value="center"><?php _e("Center", 'nggallery'); ?></option>
          <option value="right"><?php _e("Right", 'nggallery'); ?></option>
        </select></label>
      </td>
          </tr>

        </table>
    </div>
    <!-- single pic panel -->
  </div>
</form>
</body>
</html>
