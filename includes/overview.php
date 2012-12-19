<?php
/**
 * ckeditor_admin_overview()
 *
 * Add the admin overview the dashboard style
 * @return mixed content
 */
function ckeditor_admin_overview()  {
	?>
	<div class="wrap ckeditor-wrap">
	<div id="icon-wp-ckeditor" class="icon32"><br /></div>
	<h2><?php _e('CKEditor For WordPress', 'ckeditor_wordpress') ?> <?php /*echo $this->version*/?>&nbsp;</h2>
		<div id="dashboard-widgets-wrap" class="ckeditor-overview">
			<div id="dashboard-widgets" class="metabox-holder">
				<div id="post-body">
					<div id="dashboard-widgets-main-content">
						<div class="postbox-container" style="width:49%;">
							<?php do_meta_boxes('ckeditor_overview', 'left', ''); ?>
						</div>
					<div class="postbox-container" style="width:49%;">
							<?php do_meta_boxes('ckeditor_overview', 'right', ''); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// postboxes setup
			postboxes.add_postbox_toggles('ckeditor-overview');
		});
		//]]>
	</script>
	<?php
}

/**
 * http://www.php.net/manual/en/function.phpinfo.php
 * code at adspeed dot com
 * 09-Dec-2005 11:31
 * This function parses the phpinfo output to get details about a PHP module.
 */
function ckeditor_parse_php_info() {
	ob_start();
	phpinfo(INFO_MODULES);
	$s = ob_get_contents();
	ob_end_clean();
	$s = strip_tags($s,'<h2><th><td>');
	$s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
	$s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
	$vTmp = preg_split('/(<h2>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
	$vModules = array();
	for ($i=1;$i<count($vTmp);$i++) {
		if (preg_match('/<h2>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
			$vName = trim($vMat[1]);
			$vTmp2 = explode("\n",$vTmp[$i+1]);
			foreach ($vTmp2 AS $vOne) {
				$vPat = '<info>([^<]+)<\/info>';
				$vPat3 = "/$vPat\s*$vPat\s*$vPat/";
				$vPat2 = "/$vPat\s*$vPat/";
				if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
					$vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
				}
				elseif (preg_match($vPat2,$vOne,$vMat)) { // 2cols
					$vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
				}
			}
		}
	}
	return $vModules;
}

/**
 * Show the server settings in a dashboard widget
 *
 * @return void
 */
function ckeditor_overview_server() {
	if (ini_get('safe_mode'))
		$safe_mode = __('On', 'ckeditor_wordpress');
	else
		$safe_mode = __('Off', 'ckeditor_wordpress');

	if (!($upload_max = ini_get('upload_max_filesize')))
		$upload_max = __('N/A', 'ckeditor_wordpress');

	if (!($post_max = ini_get('post_max_size')))
		$post_max = __('N/A', 'ckeditor_wordpress');

	if (!($memory_limit = ini_get('memory_limit')))
		$memory_limit = __('N/A', 'ckeditor_wordpress');

	$php_info = ckeditor_parse_php_info();
?>
<div id="dashboard_server_settings" class="dashboard-widget-holder wp_dashboard_empty">
	<div class="ngg-dashboard-widget">
		<div class="dashboard-widget-content">
				<span class="description" style="">
				<?php
				_e('* CKEditor is a JavaScript application and as such does not require any specific PHP configuration.', 'ckeditor_wordpress').' ';
				_e('This information might be useful if you decide to enable a file browser.', 'ckeditor_wordpress');
				?>
				</span>
				<table class="form-table">
				<tr>
					<td><?php _e('PHP Version', 'ckeditor_wordpress'); ?></td><td><?php echo phpversion(); ?></td>
				</tr>
				<tr>
					<td><?php _e('PHP Safe Mode', 'ckeditor_wordpress'); ?></td><td><?php echo ckeditor_colorify_value($safe_mode, 'Off'); ?></td>
				</tr>
				<tr>
					<td><?php _e('PHP Max Upload Size', 'ckeditor_wordpress'); ?></td><td><?php echo $upload_max; ?></td>
				</tr>
				<tr>
					<td><?php _e('PHP Max Post Size', 'ckeditor_wordpress'); ?></td><td><?php echo $post_max; ?></td>
				</tr>
				<tr>
					<td><?php _e('PHP Memory Limit', 'ckeditor_wordpress'); ?></td><td><?php echo $memory_limit; ?></td>
				</tr>
				<?php
					if (isset($php_info['gd']) && is_array($php_info['gd']))
					{
						foreach ($php_info['gd'] as $key => $val) {
							if (!preg_match('/(WBMP|XBM|Freetype|T1Lib)/i', $key) && $key != 'Directive' && $key != 'gd.jpeg_ignore_warning') {
								echo '<tr>';
								echo '<td>'.$key.'</td>';
								if (stripos($key, 'support') === false) {
									echo '<td>'.$val.'</td>';
								}
								else {
									echo '<td>'.ckeditor_colorify_value($val, 'enabled').'</td>';
								}
								echo '</tr>';
							}
						}
					}
				?>
				</table>
		</div>
	</div>
</div>
<?php
}

function ckeditor_colorify_value($value, $expected) {
	if (strcasecmp($value, $expected) == 0) {
		return '<span class="ckeditor_ok">'.$value.'</span>';
	}
	else {
		return '<span class="ckeditor_error">'.$value.'</span>';
	}
}

/**
 * Show compatibility logos
 *
 * @return void
 */
function ckeditor_overview_compatibility() {
?>
	<div>
	<table class="form-table compat_logos">
		<tr valign="top">
			<td class="logos ie"> </td><td>Internet Explorer 7.0+</td>
			<td class="logos firefox"> </td><td>Firefox 3.0+</td>
		</tr>
		<tr valign="top">
			<td class="logos safari"> </td><td>Safari 3.0+</td>
			<td class="logos opera"> </td><td>Opera 9.50+</td>
		</tr>
		<tr valign="top">
			<td class="logos chrome"> </td><td>Google Chrome</td>
			<td class="logos camino"> </td><td>Camino 1.0+</td>
		</tr>
	</table>
	</div>
<?php
}

/**
 * Show CKEditor information
 *
 * @return void
 */
function ckeditor_overview_configuration() {
?>
	<div>
	<table class="form-table">
		<tr valign="top">
			<td>Plugin Version</td><td><?php echo $GLOBALS['ckeditor_plugin_version']; ?></td>
		</tr>
		<tr valign="top">
			<td>Editor Version</td><td><?php echo $GLOBALS['ckeditor_version']; ?></td>
		</tr>
		<tr valign="top">
			<td>CKFinder</td><td><?php echo $GLOBALS['ckfinder_status']; ?></td>
		</tr>
	</table>
	</div>
<?php
}
function ckeditor_reset_settings() {
	?>
	<div>
	<span class="description">
	<?php _e('Press the button below to reset CKEditor settings to default values.', 'ckeditor_wordpress'); ?>
	</span>
	<form method="post" style="margin-top:15px">
		<?php wp_nonce_field('ckeditor_create_nonce_overview','csrf_ckeditor-for-wordpress'); ?>
		<input type="hidden" name="reset" value="1" />
		<p class="submit">
			<input type="submit" value="Reset settings to defaults" name="submit_reset" class="button-secondary" id="default-reset" />
		</p>
	</form>
	</div>
	<?php
}

/**
 * Show useful links
 *
 * @return void
 */
function ckeditor_overview_help() {
	?>
	<div>
	<table class="form-table ckeditor_links">
		<tr valign="top">
			<td class="cke"><a href="http://ckeditor.com"><?php _e('CKEditor Site', 'ckeditor_wordpress');?></a></td>
			<td class="help"><a href="http://docs.cksource.com/CKEditor_3.x/Users_Guide"><?php _e('User Guide', 'ckeditor_wordpress');?></a></td>
			<td class="plug"><a href="http://wordpress.org/extend/plugins/ckeditor-for-wordpress/"><?php _e('Plugin Site', 'ckeditor_wordpress');?></a></td>
		</tr>
		<tr valign="top">
			<td class="excl"><a href="http://wordpress.ckeditor.com/troubleshooting"><?php _e('Troubleshooting', 'ckeditor_wordpress');?></a></td>
			<td class="docs"><a href="http://docs.cksource.com/CKEditor_3.x/Developers_Guide"><?php _e('CKEditor Documentation', 'ckeditor_wordpress');?></a></td>
			<td class="conf"><a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html"><?php _e('Configuration Options', 'ckeditor_wordpress');?></a></td>
		</tr>
	</table>
	</div>
	<?php
}

add_meta_box('dashboard_overview_configuration', __('CKEditor Information', 'ckeditor_wordpress'), 'ckeditor_overview_configuration', 'ckeditor_overview', 'left', 'core');
add_meta_box('dashboard_overview_help', __('Useful Links', 'ckeditor_wordpress'), 'ckeditor_overview_help', 'ckeditor_overview', 'left', 'core');
add_meta_box('dashboard_overview_compatibility', __('CKEditor Compatibility', 'ckeditor_wordpress'), 'ckeditor_overview_compatibility', 'ckeditor_overview', 'right', 'core');
add_meta_box('dashboard_overview_server', __('Server Information', 'ckeditor_wordpress'), 'ckeditor_overview_server', 'ckeditor_overview', 'right', 'core');
add_meta_box('dashboard_reset_settings', __('Reset Plugin Settings', 'ckeditor_wordpress'), 'ckeditor_reset_settings', 'ckeditor_overview', 'left', 'core');

ckeditor_admin_overview();
?>
