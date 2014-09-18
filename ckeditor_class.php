<?php
/*
Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or http://ckeditor.com/license
*/

class ckeditor_wordpress {

	private static $instance;
	public $version = '4.4.4';
	public $timestamp = 'E7KC';
	public $default_options = array();
	public $options = array();
	public $ckeditor_path = "";
	public $plugin_path = "";
	public $editable_files = array(); //array with files which can be edited

	public static function getInstance() {
			if (!isset(self::$instance)) {
					$class = __CLASS__;
					self::$instance = new $class();
			}
			return self::$instance;
	}

	public function __construct() {
		$siteurl = trailingslashit(get_option('siteurl'));
		if (DEFINED('WP_PLUGIN_URL')) {
			$this->plugin_path = WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)) . '/';
		} else if (DEFINED('WP_PLUGIN_DIR')) {
			$this->plugin_path = $siteurl . '/' . WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/';
		} else {
			$this->plugin_path = $siteurl . 'wp-content/plugins/' . basename(dirname(__FILE__)) . '/';
		}
		if (is_ssl()) {
			$siteurl = str_replace('http:', 'https:', $siteurl);
			$this->plugin_path = str_replace('http:', 'https:', $this->plugin_path);
		}
		define('CKEDITOR_PLUGIN_URL', $this->plugin_path);
		$this->ckeditor_path = $this->plugin_path . 'ckeditor/';
		$this->editable_files = array(
			'ckeditor.config.js' => dirname(__FILE__) . '/ckeditor.config.js',
			'ckeditor.styles.js' => dirname(__FILE__) . '/ckeditor.styles.js',
			'ckeditor.templates.js' => dirname(__FILE__) . '/ckeditor.templates.js',
		);
		$this->default_options = array(
			'appearance' => array(
				'skin' => 'moono',
				'uicolor' => 'default',
				'uicolor_user' => '',
				/* basic post settings */
				'default_state' => 't',
				'excerpt_state' => 'f',
				'post_toolbar' => 'WordpressFull',
				'post_editor_height' => 300,
				/* basic comment settings */
				'comment_editor' => 't',
				'comment_toolbar' => 'WordpressBasic',
				'comment_editor_height' => 160,
			),
			'upload' => array(
				'browser' => 'disabled',
				'type' => 'native',
				'user_file_path' => 'wp-content/uploads/',
				'files_allowed_ext' => '7z,aiff,asf,avi,bmp,csv,doc,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,zip',
				'images_allowed_ext' => 'bmp,gif,jpeg,jpg,png',
				'flash_allowed_ext' => 'swf,flv',
			),
			'ckfinder' => array(
				'file_max_size' => '8M',
				'images_width' => '1200',
				'images_height' => '1600',
				'images_quality' => '80',
				'thumbnails_width' => '100',
				'thumbnails_height' => '100',
				'thumbnails_quality' => '80',
				'thumbnails_enabled' => 't',
				'thumbnails_direct_access' => 'f',
				'license_name' => '',
				'license_key' => '',
			),
			'css' => array(
				'mode' => 'default',
				'path' => '',
				'styles' => 'default',
				'style_path' => '',
			),
			'advanced' => array(
				'load_method' => 'ckeditor.js',
				'load_timeout' => 0,
				'native_spell_checker' => 't',
				'scayt_autoStartup' => 'f',
				'entities' => 't',
				'p_indent' => 't',
				'p_break_before_open' => 't',
				'p_break_after_open' => 't',
				'p_break_before_close' => 't',
				'p_break_after_close' => 't',
			),
			'plugins' => array(
				'autogrow' => 'f',
				'tableresize' => 'f',
				'wpgallery' => 't',
				'scayt' => 't',
				'wsc' => 't'
			),
		);
		$options = get_option('ckeditor_wordpress');
		if (!$options) {
			add_option('ckeditor_wordpress', $this->default_options);
			$options = $this->default_options;
		}
		$this->options = $options;
		if (!isset($this->options['advanced']['entities'])) {
			$this->options['advanced']['entities'] = 't';
		}
		$path = str_replace(ABSPATH, '', trim($this->options['upload']['user_file_path']));
		$dir = ABSPATH . $path;
		if ($dir == ABSPATH) { //the option was empty
			$dir = ABSPATH . 'wp-content/uploads';
		}
		$dir = rtrim($dir, "/\\") . "/";
		$this->user_files_absolute_path = $dir;
		$this->user_files_url = $siteurl . $path;
		$this->file_browser = $this->options['upload']['browser'];
	}

		private function get_sorted_roles() {
			// This function returns all roles, sorted by user level (lowest to highest)
			global $wp_roles;
			$roles = $wp_roles->role_objects;
			$sorted = array();

			if (class_exists('RoleManager')) {
				foreach ($roles as $role_key => $role_name) {
					$role = get_role($role_key);
					if (empty($role))
						continue;
					$role_user_level = array_reduce(array_keys($role->capabilities), array('WP_User', 'level_reduction'), 0);
					$sorted[$role_user_level] = $role;
				}
				$sorted = array_values($sorted);
			}
			else {
					$role_order = array("subscriber", "contributor", "author", "editor", "administrator");
					foreach ($role_order as $role_key) {
						$sorted[$role_key] = get_role($role_key);
					}
			}
			return $sorted;
		}

	private function get_role($capability) {
		// This function return the lowest roles which has the capabilities
		$check_order = $this->get_sorted_roles();

		$args = array_slice(func_get_args(), 1);
		$args = array_merge(array($capability), $args);

		foreach ($check_order as $check_role) {
			if (empty($check_role))
				return false;

			if (call_user_func_array(array(&$check_role, 'has_cap'), $args))
				return $check_role->name;
		}
	return false;
	}

	private function set_capability($lowest_role, $capability) {
		// This function set or remove the $capability
		$check_order = $this->get_sorted_roles();
		$add_capability = false;

		foreach ($check_order as $the_role) {
			$role = $the_role->name;

			if ($lowest_role == $role)
				$add_capability = true;

			// If you rename the roles, then please use the role manager plugin
			if (empty($the_role))
				continue;

			$add_capability ? $the_role->add_cap($capability) : $the_role->remove_cap($capability);
		}
	}

	public function can_upload() {
		global $userdata;
		$user_level = intval($userdata->user_level);
		if ((function_exists('current_user_can') && current_user_can('upload_files')) || (isset($user_level) && $user_level >= 3)) {
			return true;
		}
		return false;
	}

	private function checkbox($section, $var, $text, $onClick = '') {
		return '<label id="lbl_' . $var . '"><input type="checkbox" id="' . $var . '" name="options[' . $section . '][' . $var . ']"' .
			($onClick != '' ? ' onClick="' . $onClick . '" ' : '') .
			($this->options[$section][$var] == 't' ? "checked" : '') . '>&nbsp;' . __($text, 'ckeditor_wordpress') . "</label>\n";
	}

	public function add_admin_head() {
		?>
		<style type="text/css">
			.form-table td .cke_editor td { padding:0; }
			#icon-wp-ckeditor {background: transparent url(<?php echo $this->plugin_path; ?>images/ckeditor_ico32.png) no-repeat;}
		</style>
		<?php
		//if qTranslate plugin is enabled
		if (is_plugin_active('qtranslate/qtranslate.php'))
		{
			$this->generate_js_options(false);
			echo '<script type="text/javascript" src="'.$this->ckeditor_path .'ckeditor.js?t='.$this->timestamp.'"></script>';
			echo '<script type="text/javascript" src="'.$this->plugin_path . 'includes/ckeditor.utils.js"></script>';
			global $q_config;
			$q_config['js']['qtrans_tinyMCEOverload'] = '';
			$q_config['js']['qtrans_disable_old_editor'] = '';
			$q_config['js']['qtrans_hook_on_tinyMCE'] = 'qtrans_hook_on_tinyMCE = function(id) {};';
		}
	}

	public function user_personalopts_update() {
		global $current_user;
		update_user_option($current_user->id, 'rich_editing', 'false', true);
	}

	public function print_admin_styles() {
		wp_enqueue_style('ckeditor_admin', $this->plugin_path . 'includes/overview.css', false, $this->version, 'screen');
	}

	public function print_admin_upload_styles() {
		wp_enqueue_style('ckeditor_admin', $this->plugin_path . 'includes/upload.css', false, $this->version, 'screen');
	}

	public function add_option_page() {
		add_menu_page(__('CKEditor Settings'), 'CKEditor', 'administrator', 'ckeditor_settings', array(&$this, 'plugin_overview'), $this->plugin_path . 'images/menuicon.gif');
		//line below replace url title from CKEditor to Overview
		$overview_page = add_submenu_page('ckeditor_settings', __('CKEditor Overview'), __('Overview'), 'administrator', 'ckeditor_settings', array(&$this, 'plugin_overview'));
		add_action('admin_print_styles-' . $overview_page, array(&$this, 'print_admin_styles'));

		// TODO: include postbox/dashboard only on overview page
		if (isset($_GET['page']) && $_GET['page'] == 'ckeditor_settings') {
			wp_enqueue_script('postbox');
		}

		$basic_page = add_submenu_page('ckeditor_settings', __('CKEditor Basic Settings'), __('Basic Settings'), 'administrator', 'ckeditor_basic_options', array(&$this, 'option_page'));
		add_action('admin_print_scripts-' . $basic_page, array(&$this, 'basic_settings_js'));

		add_submenu_page('ckeditor_settings', __('CKEditor Advanced Settings'), __('Advanced Settings'), 'administrator', 'ckeditor_advanced_options', array(&$this, 'advanced_options'));
		$upload_page = add_submenu_page('ckeditor_settings', __('CKEditor Upload Settings'), __('Upload Options'), 'administrator', 'ckeditor_upload_options', array(&$this, 'upload_options'));
		add_action('admin_print_styles-' . $upload_page, array(&$this, 'print_admin_upload_styles'));

		if (count($this->get_writable_files()) > 0) {
			$file_editor_page = add_submenu_page('ckeditor_settings', __('CKEditor File Editor'), __('File Editor'), 'administrator', 'ckeditor_file_editor', array(&$this, 'file_editor'));
			add_action('admin_print_scripts-' . $file_editor_page, array(&$this, 'file_editor_js'));
		}
	}

	private function ckeditor_get_version() {
		$jspath = dirname(__FILE__) . '/ckeditor/ckeditor.js';
		$contents = @file_get_contents($jspath);
		if ($contents) {
			$matches = array();
			if (preg_match('#,version:[\'"](.*?)[\'"],#', $contents, $matches)) {
				return $matches[1];
			}
		}
		return __('N/A', 'ckeditor_wordpress');
	}

	private function ckfinder_status() {
		$ckfinder_php = dirname(__FILE__) . '/ckfinder/ckfinder.php';
		$nested_ckfinder_php = dirname(__FILE__) . '/ckfinder/ckfinder/ckfinder.php';
		$config_path = dirname(__FILE__) . '/ckfinder/config.php';

		if (!file_exists($ckfinder_php)) {
			if (file_exists($nested_ckfinder_php)) {
					return '<span class="ckeditor_error">' . __('CKFinder installed in wrong (nested) directory. Move files from ckeditor/ckfinder/ckfinder to ckeditor/ckfinder directory.', 'ckeditor_wordpress') . '</span>';
			} else {
					return __('Not installed', 'ckeditor_wordpress');
			}
		} else {
			$contents = @file_get_contents($config_path);
			if (!$contents) {
				return '<span class="ckeditor_error">' . __('CKFinder is installed, configuration file not readable or empty.', 'ckeditor_wordpress') . '</span>';
			}
			if (strpos($contents, 'wp-config.php') === false) {
				return '<span class="ckeditor_error">' . __('CKFinder is installed, but invalid config.php was detected. Rename ckfinder_config.php to config.php (overwriting the default config.php file distributed with CKFinder).', 'ckeditor_wordpress') . '</span>';
			}
			if ($this->options['upload']['browser'] != 'ckfinder') {
				return '<span class="ckeditor_ok">' . __('CKFinder is installed, not enabled.', 'ckeditor_wordpress') . '</span>';
			}
			return '<span class="ckeditor_ok">' . __('CKFinder is installed', 'ckeditor_wordpress') . '</span>';
		}
	}

	public function plugin_overview() {
		global $ckeditor_version, $ckeditor_plugin_version, $ckfinder_status;
		$ckeditor_version = $this->ckeditor_get_version();
		$ckeditor_plugin_version = $this->version;
		$ckfinder_status = $this->ckfinder_status();
		if (isset($_POST['reset']) && $_POST['reset'] == 1) {
			if (!wp_verify_nonce($_POST['csrf_ckeditor-for-wordpress'], 'ckeditor_create_nonce_overview') || empty($_POST['_wp_http_referer']) || ( isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], $_POST['_wp_http_referer']) ))
				wp_die("You do not have sufficient permissions to access this page.");
			update_option('ckeditor_wordpress', $this->default_options);
			$this->options = $this->default_options;
			echo '<div class="updated"><p>' . __('Configuration updated!') . '</p></div>';
		}
		include('includes/overview.php');
	}

	public function option_page() {
		if (!empty($_POST['submit_update'])) {
			$message = array();
			/* validation */
			if (!wp_verify_nonce($_POST['csrf_ckeditor-for-wordpress'], 'ckeditor_create_nonce_basic') || empty($_POST['_wp_http_referer']) || ( isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], $_POST['_wp_http_referer']) ))
				wp_die("You do not have sufficient permissions to access this page.");
			$new_options = $_POST['options'];
			$new_options['appearance']['comment_editor'] = (isset($_POST['options']['appearance']['comment_editor']) ? 't' : 'f');

			$this->options = $this->update_options($new_options, (empty($message) ? false : true));
		}
		include('includes/basic.php');
	}

	public function upload_options() {
		if (!empty($_POST['submit_update'])) {
				if (!wp_verify_nonce($_POST['csrf_ckeditor-for-wordpress'], 'ckeditor_create_nonce_upload') || empty($_POST['_wp_http_referer']) || ( isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], $_POST['_wp_http_referer']) ))
					wp_die("You do not have sufficient permissions to access this page.");
				$new_options = $_POST['options'];
				foreach (array('access', 'fileView', 'fileDelete', 'fileRename', 'fileUpload', 'folderView', 'folderDelete', 'folderCreate', 'folderRename') as $command) {
					$this->set_capability($new_options['ckfinder']['permissions'][$command], "ckeditor_ckfinder_" . $command);
				}
				$new_options['ckfinder']['thumbnails_direct_access'] = (isset($new_options['ckfinder']['thumbnails_direct_access']) ? 't' : 'f');
				$new_options['ckfinder']['thumbnails_enabled'] = (isset($new_options['ckfinder']['thumbnails_enabled']) ? 't' : 'f');

				/* validation */
				$message = array();

				if ($new_options['upload']['browser'] != 'disabled') {
					$new_options['upload']['files_allowed_ext'] = str_replace(' ', '', $new_options['upload']['files_allowed_ext']);
					$new_options['upload']['images_allowed_ext'] = str_replace(' ', '', $new_options['upload']['images_allowed_ext']);
					$new_options['upload']['flash_allowed_ext'] = str_replace(' ', '', $new_options['upload']['flash_allowed_ext']);

					$inputs = array('files_allowed_ext', 'images_allowed_ext', 'flash_allowed_ext');
					foreach ($inputs as $input) {
						if (empty($new_options['upload'][$input])) {
							$message['upload_' . $input] = __('This field shouldn\'t be empty', 'ckeditor_wordpress');
						} elseif (!preg_match('#^([a-z0-9]+){1}(,[a-z0-9]+)*,?$#Uis', trim($new_options['upload'][$input]))) {
							$message['upload_' . $input] = __('Files extensions has wrong chars.', 'ckeditor_wordpress');
						}
					}

					if ($new_options['upload']['browser'] == 'ckfinder') {
						$checkCKFinder = $this->ckfinder_status();
						if (!strpos($checkCKFinder, "ckeditor_ok")) {
							$message['upload_browser'] = $checkCKFinder;
						}
						if (empty($new_options['ckfinder']['file_max_size'])) {
							$message['ckfinder_file_max_size'] = __('This field is required.', 'ckeditor_wordpress');
						} elseif (!preg_match('/^\d+[MKG]?$/i', trim($new_options['ckfinder']['file_max_size']))) {
								$message['ckfinder_file_max_size'] = __('Enter valid value. Example: 400 or 10M', 'ckeditor_wordpress');
						}
						$inputs = array('images_width', 'images_height', 'thumbnails_width', 'thumbnails_height');
						foreach ($inputs as $input) {
							if (empty($new_options['ckfinder'][$input])) {
								$message['ckfinder_' . $input] = __('This field is required.', 'ckeditor_wordpress');
							} elseif (!preg_match('#^\d+$#', trim($new_options['ckfinder'][$input]))) {
								$message['ckfinder_' . $input] = __('Enter valid value. Example: 400', 'ckeditor_wordpress');
							}
						}
						if (empty($new_options['ckfinder']['thumbnails_quality'])) {
							$message['ckfinder_thumbnails_quality'] = __('This field is required.', 'ckeditor_wordpress');
						} elseif (!(preg_match('#^[0-9]{1,2}$#', trim($new_options['ckfinder']['thumbnails_quality'])) || trim($new_options['ckfinder']['thumbnails_quality']) == '100')) {
							$message['ckfinder_thumbnails_quality'] = __('Value should be betwen 1 and 100.', 'ckeditor_wordpress');
						}
						if (empty($new_options['ckfinder']['images_quality'])) {
							$message['ckfinder_images_quality'] = __('This field is required.', 'ckeditor_wordpress');
						} elseif (!(preg_match('#^[0-9]{1,2}$#', trim($new_options['ckfinder']['images_quality'])) || trim($new_options['ckfinder']['images_quality']) == '100')) {
							$message['ckfinder_images_quality'] = __('Value should be betwen 1 and 100.', 'ckeditor_wordpress');
						}
				}
			}

		unset($new_options['ckfinder']['permissions']);

		$this->options = $this->update_options($new_options, (empty($message) ? false : true));
		}
		include('includes/upload.php');
	}

	public function advanced_options() {
		if (!empty($_POST['submit_update'])) {
				if (!wp_verify_nonce($_POST['csrf_ckeditor-for-wordpress'], 'ckeditor_create_nonce_advanced') || empty($_POST['_wp_http_referer']) || ( isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], $_POST['_wp_http_referer']) ))
					wp_die("You do not have sufficient permissions to access this page.");
				$new_options = $_POST['options'];
				$new_options['advanced']['native_spell_checker'] = (isset($_POST['options']['advanced']['native_spell_checker']) ? 't' : 'f');
				$new_options['advanced']['scayt_autoStartup'] = (isset($_POST['options']['advanced']['scayt_autoStartup']) ? 't' : 'f');
				$new_options['advanced']['p_indent'] = (isset($_POST['options']['advanced']['p_indent']) ? 't' : 'f');
				$new_options['advanced']['p_break_before_open'] = (isset($_POST['options']['advanced']['p_break_before_open']) ? 't' : 'f');
				$new_options['advanced']['p_break_after_open'] = (isset($_POST['options']['advanced']['p_break_after_open']) ? 't' : 'f');
				$new_options['advanced']['p_break_before_close'] = (isset($_POST['options']['advanced']['p_break_before_close']) ? 't' : 'f');
				$new_options['advanced']['p_break_after_close'] = (isset($_POST['options']['advanced']['p_break_after_close']) ? 't' : 'f');
				$new_options['advanced']['entities'] = (isset($_POST['options']['advanced']['entities']) ? 't' : 'f');
				foreach ($this->options['plugins'] as $key => $val) {
					if (isset($_POST['options']['plugins'][$key])) {
						$new_options['plugins'][$key] = 't';
						unset($_POST['options']['plugins'][$key]);
					} else {
						$new_options['plugins'][$key] = 'f';
					}
				}
				foreach ((array) $_POST['options']['plugins'] as $key => $val) {
					$new_options['plugins'][$key] = 't';
				}
				$new_options['plugins']['wpgallery'] = 't';

				/* validation */
				$massage = array();

				/** css mode and path validation * */
				if (!empty($new_options['css']['path'])) {
					if ($new_options['css']['mode'] != 'self') {
						$message['css_path'] = __('CSS path is not empty. Please set the "Editor CSS" option to "define css" mode.', 'ckeditor_wordpress');
					} elseif (FALSE !== strpos($new_options['css']['path'], '"')) {
						$massage['css_path'] = __('Double quotes are not allowed in CSS path.', 'ckeditor_wordpress');
					} elseif (substr($new_options['css']['path'], 0, 1) == "'" && substr($new_options['css']['path'], -1) == "'") {
						$massage['css_path'] = __('Enter valid path, do not surround it with quotes.', 'ckeditor_wordpress');
					}
				}
				/** styles * */
				if (!empty($new_options['css']['style_path'])) {
					if ($new_options['css']['styles'] != 'self') {
						$message['css_style_path'] = __('Path to predefined styles is not empty. Please set the "Predefined styles" option to "define path to ckeditor.styles.js" mode.', 'ckeditor_wordpress');
					} elseif (FALSE !== strpos($new_options['css']['styles_path'], '"')) {
						$message['css_style_path'] = __('Double quotes are not allowed in path.', 'ckeditor_wordpress');
					} elseif (substr($new_options['css']['style_path'], 0, 1) == "'" && substr($new_options['css']['style_path'], -1) == "'") {
						$message['css_style_path'] = __('Enter valid path, do not surround it with quotes.', 'ckeditor_wordpress');
					}
				}
				/** load timeout * */
				if (!preg_match('#^\d+$#', trim($new_options['advanced']['load_timeout']))) {
					$massage['advanced_load_timeout'] = __('Enter valid load timeout in seconds.', 'ckeditor_wordpress');
				}

				/* language settings */
				if (!preg_match('#^\d\d$#', trim($new_options['advanced']['language'])) && !preg_match('#^\d\d-\d\d$#', trim($new_options['advanced']['language']))) {
					$massage['advanced_language'] = __('Enter a valid language.', 'ckeditor_wordpress');
				}

				if (trim($new_options['advanced']['detect_language_auto']) != 't' && trim($new_options['advanced']['detect_language_auto'] != 'f')) {
					$massage['advanced_detect_language_auto'] = __('Enter a valid auto detect language value.', 'ckeditor_wordpress');
				}

				if (trim($new_options['advanced']['acf']) != 't' && trim($new_options['advanced']['acf'] != 'f')) {
					$massage['acf'] = __('Enter a valid ACF value.', 'ckeditor_wordpress');
				}

				if (trim($new_options['advanced']['language_direction']) != 'default' && trim($new_options['advanced']['language_direction']) != 'ltr' && trim($new_options['advanced']['language_direction']) != 'rtl') {
					$massage['advanced_language_direction'] = __('Enter a valid language direction value.', 'ckeditor_wordpress');
				}

				$this->options = $this->update_options($new_options, (empty($message) ? false : true));
		}
		include('includes/advanced.php');
	}

	public function basic_settings_js() {
		wp_enqueue_script('ckeditor', $this->ckeditor_path . 'ckeditor.js');
		wp_enqueue_script('ckeditor_admin', $this->plugin_path . 'includes/basic.js');
	}

	public function file_editor_js() {
		/* codepress */
		//add_action('admin_print_footer_scripts', 'codepress_footer_js');
		//wp_enqueue_script('codepress');
	}

	private function is_plugin_active($plugin_name) {
		$options = get_option('active_plugins');
		foreach ($options AS $option) {
				if (strpos($option, $plugin_name) !== FALSE) {
						return true;
				}
		}

	return false;
	}

	public function remove_tinymce() {
		if (has_action('admin_print_footer_scripts', 'wp_tiny_mce')) {
			remove_action('admin_print_footer_scripts', 'wp_tiny_mce', 25);
		}
	}

	public function add_post_js() {
		if (has_filter('admin_print_footer_scripts', 'wp_tiny_mce') || has_filter('before_wp_tiny_mce', 'wp_print_editor_js') || has_filter('after_wp_tiny_mce', 'wp_preload_dialogs')) {
			remove_filter('admin_print_footer_scripts', 'wp_tiny_mce', 25);
			remove_filter('before_wp_tiny_mce', 'wp_print_editor_js');
			remove_filter('after_wp_tiny_mce', 'wp_preload_dialogs');
			$this->editor_js();
		}
	}

	public function editor_js() {
		if (!user_can_richedit()) {
			wp_enqueue_script('quicktags');
			return;
		}
		wp_enqueue_script('editor');
		wp_enqueue_script('ckeditor', $this->ckeditor_path . "ckeditor.js?t=".$this->timestamp);
		wp_enqueue_script('ckeditor.utils', $this->plugin_path . 'includes/ckeditor.utils.js', array('ckeditor', 'jquery'));

		$this->generate_js_options(false);
	}

	public function add_comment_js() {
		if (!(is_page() || is_single())) {
			return;
		}

		if ($this->options['appearance']['comment_editor'] != 't') {
			return;
		}
		// if W3 Total Cache is enabled, turn off minify for page with CKEditor in comments
		if ( is_plugin_active('w3-total-cache/w3-total-cache.php') ) {
			define('DONOTMINIFY', true);
		}
		wp_enqueue_script('ckeditor', $this->ckeditor_path . "ckeditor.js?t=".$this->timestamp);
		wp_enqueue_script('ckeditor.utils', $this->plugin_path . 'includes/ckeditor.utils.js', array('ckeditor', 'jquery'));
		wp_deregister_script('comment-reply');
		wp_register_script('comment-reply', $this->plugin_path . 'includes/ckeditor.comment-reply.js', array('ckeditor', 'ckeditor.utils'), "20100901");
		$this->generate_js_options(true);
		$this->add_wpcompat_styles();
	}

	public function add_wpcompat_styles() {
		?>
		<style type="text/css">
				#content table.cke_editor { margin:0; }
				#content table.cke_editor tr td { padding:0;border:0; }
		</style>
		<?php
	}

	private function update_options($new_options, $error) {
		$options = $this->options;
		foreach ($new_options as $k => $v) {
			if (isset($this->options[$k])) {
				$options[$k] = array_merge($this->options[$k], $v);
			} else {
				$options[$k] = $v;
			}
		}
		if (!$error) {
			update_option("ckeditor_wordpress", $options);
			echo '<div class="updated"><p>' . __('Configuration updated!') . '</p></div>';
		}
		return $options;
	}

	private function get_writable_files() {
		$out = array();
		foreach ($this->editable_files as $file => $path) {
			if (file_exists($path) && is_writable($path)) {
				$out[$file] = $path;
			}
		}
		return $out;
	}

	public function file_editor() {
		$files = $this->get_writable_files();
		if (isset($_POST['file']) && !isset($files[$_POST['file']])) {
			echo '<div class="error"><p>' . __('Invalid file!') . '</p></div>';
			return;
		}
		if (isset($_POST['file'])) {
			$file = $_POST['file'];
		} else {
			$keys = array_keys($files);
			$file = $keys[0];
			unset($keys);
		}
		if (isset($_POST['newcontent'])) {
			if (!wp_verify_nonce($_POST['csrf_ckeditor-for-wordpress'], 'ckeditor_create_nonce_file_editor') || empty($_POST['_wp_http_referer']) || ( isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], $_POST['_wp_http_referer']) ))
					wp_die("You do not have sufficient permissions to access this page.");
			$fp = fopen($files[$file], 'w');
			$content = stripslashes($_POST['newcontent']);
			fwrite($fp, stripslashes($_POST['newcontent']));
			echo '<div class="updated"><p>' . __('Configuration updated!') . '</p></div>';
		} else {
			$fp = fopen($files[$file], 'r');
			$content = fread($fp, filesize($files[$file]));
		}
		fclose($fp);
		include('includes/file_editor.php');
	}

	private function generate_js_options($is_comment) {
		$options = $this->options;
		$settings = array();
		if ($options['upload']['browser'] == 'builtin') {
			$ck_browser_url = $this->plugin_path . 'filemanager/browser/default/browser.html?Connector=../../connectors/php/connector.php';
			$ck_upload_url = $this->plugin_path . 'filemanager/connectors/php/upload.php';
			$settings['filebrowserBrowseUrl'] = $ck_browser_url;
			$settings['filebrowserImageBrowseUrl'] = $ck_browser_url . '&type=Images';
			$settings['filebrowserFlashBrowseUrl'] = $ck_browser_url . '&type=Flash';
			$settings['filebrowserUploadUrl'] = $ck_upload_url;
			$settings['filebrowserImageUploadUrl'] = $ck_upload_url . '?type=Images';
			$settings['filebrowserFlashUploadUrl'] = $ck_upload_url . '?type=Flash';
		}else if ($options['upload']['browser'] == 'ckfinder') {
			$ck_browser_url = $this->plugin_path . 'ckfinder/ckfinder.html';
			$ck_upload_url = $this->plugin_path . 'ckfinder/core/connector/php/connector.php?command=QuickUpload';
			$settings['filebrowserBrowseUrl'] = $ck_browser_url;
			$settings['filebrowserImageBrowseUrl'] = $ck_browser_url . '?type=Images';
			$settings['filebrowserFlashBrowseUrl'] = $ck_browser_url . '?type=Flash';
			$settings['filebrowserUploadUrl'] = $ck_upload_url . '&type=Files';
			$settings['filebrowserImageUploadUrl'] = $ck_upload_url . '&type=Images';
			$settings['filebrowserFlashUploadUrl'] = $ck_upload_url . '&type=Flash';
		}

		if ($options['appearance']['uicolor'] == 'custom' && !empty($options['appearance']['uicolor_user'])) {
			$settings['uiColor'] = $options['appearance']['uicolor_user'];
		}
		$settings['height'] = ($is_comment ? $options['appearance']['comment_editor_height'] : $options['appearance']['post_editor_height']) . 'px';
		if (in_array($options['appearance']['skin'], array('moono', 'kama'))) {
			$settings['skin'] = $options['appearance']['skin'];
		}
		$settings['scayt_autoStartup'] = $options['advanced']['scayt_autoStartup'] == 't' ? true : false;
		$settings['entities'] = $options['advanced']['entities'] == 't' ? true : false;
		$settings['entities_greek'] = $settings['entities'];
		$settings['entities_latin'] = $settings['entities'];
		$settings['toolbar'] = ($is_comment ? $options['appearance']['comment_toolbar'] : $options['appearance']['post_toolbar']);
		if ($settings['toolbar'] == 'Full') {
			unset($settings['toolbar']);
		}
		$settings['templates_files'][] = $this->plugin_path . 'ckeditor.templates.js';
		$output = array(
			'textarea_id' => ($is_comment ? 'comment' : 'content'),
			'pluginPath' => $this->plugin_path,
			'autostart' => ($options['appearance']['default_state'] == 't' || $is_comment ? true : false),
			'excerpt_state' => ($options['appearance']['excerpt_state'] == 't' ? true : false),
			'qtransEnabled' => ($this->is_plugin_active("qtrans") ? true : false),
			'outputFormat' => array(
				'indent' => ($options['advanced']['p_indent'] == 't' ? true : false),
				'breakBeforeOpen' => ($options['advanced']['p_break_before_open'] == 't' ? true : false),
				'breakAfterOpen' => ($options['advanced']['p_break_after_open'] == 't' ? true : false),
				'breakBeforeClose' => ($options['advanced']['p_break_before_close'] == 't' ? true : false),
				'breakAfterClose' => ($options['advanced']['p_break_after_close'] == 't' ? true : false),
			),
			'configuration' => array(),
		);
		/** css mode * */
		switch ($options['css']['mode']) {
			case 'theme':
				$settings['contentsCss'][] = get_stylesheet_uri();
				//fix for default Wordpress theme
				if (preg_match('/twenty[\S]+/', get_stylesheet_uri())) {
						$settings['extraCss'] = 'body {background:#FFF; padding: 0 0.5em; }';
				}
				break;
			case 'self':
				foreach (explode(',', $options['css']['path']) as $css_path) {
					$css_path = trim(str_replace("%h%t", "%t", $css_path));
					$settings['contentsCss'][] = str_replace(array('%h', '%t'), array($_SERVER['HTTP_HOST'], get_template_directory_uri()), $css_path);
				}
				break;
		}
		/** predefined style $options['css']['styles'] != 'default' ||  * */
		switch ($options['css']['styles']) {
			case 'theme':
				$settings['stylesCombo_stylesSet'] = 'wordpress:' . get_template_directory_uri() . '/ckeditor.styles.js';
				break;
			case 'self':
				$options['css']['style_path'] = trim(str_replace("%h%t", "%t", $options['css']['style_path']));
				$settings['stylesCombo_stylesSet'] = 'wordpress:' . str_replace(array('%h', '%t'), array($_SERVER['HTTP_HOST'], get_template_directory_uri()), $options['css']['style_path']);
				break;
			default:
				$settings['stylesCombo_stylesSet'] = 'wordpress:' . $this->plugin_path . 'ckeditor.styles.js';
				break;
		}

		if (isset($options['advanced']['detect_language_auto']) && $options['advanced']['detect_language_auto'] == 'f') {
			$settings['language'] = $options['advanced']['language'];
		}

		if (!isset($options['advanced']['acf']) || $options['advanced']['acf'] == 'f') {
			$settings['allowedContent'] = true;
		}

		if (isset($options['advanced']['language_direction'])) {
			switch ($options['advanced']['language_direction']) {
				case 'default':
					if (is_rtl()) {
						$settings['contentsLangDirection'] = 'rtl';
					}
					break;
				case 'ltr':
					$settings['contentsLangDirection'] = 'ltr';
					break;
				case 'rtl':
						$settings['contentsLangDirection'] = 'rtl';
						break;
			}
		}


		$output['configuration'] = $settings;
		$output['configuration']['customConfig'] = $this->plugin_path . 'ckeditor.config.js';
		if (!$is_comment) {
			$output['externalPlugins'] = apply_filters('ckeditor_external_plugins', array());
			$output['additionalButtons'] = apply_filters('ckeditor_buttons', array());
			$available_plugins = array_keys($output['externalPlugins']);
			$available_plugins[] = "autogrow";
			$available_plugins[] = "tableresize";
			$available_plugins[] = "scayt";
			$available_plugins[] = "wsc";

			foreach ((array) $options['plugins'] as $name => $val) {
				if ($val == 't' && !isset($output['externalPlugins'][$name])) {
					// skip adding plugin when  NextGEN Gallery plugin is installed and user has not permissions to use it
					if ($name == 'nextgen' && (!current_user_can('NextGEN Use TinyMCE') ||  !get_user_option('rich_editing') == 'true') ) 
						continue;
					if (in_array($name, $available_plugins))
						$output['externalPlugins'][$name] = $this->plugin_path . 'ckeditor/plugins/' . $name . '/';
				}
				else if ($val == 'f' && isset($output['externalPlugins'][$name])) {
					unset($output['externalPlugins'][$name]);
				}
			}
		} else {
			$output['externalPlugins'] = array();
			$output['additionalButtons'] = array();
		}
		echo "<script type='text/javascript'>\n/* <![CDATA[ */\nwindow.CKEDITOR_BASEPATH = \"" . $this->ckeditor_path . "\";\nvar ckeditorSettings = " . $this->jsEncode($output) . "\n/* ]]> */\n</script>";
	}

	/**
	 * This little function provides a basic JSON support.
	 * http://php.net/manual/en/function.json-encode.php
	 * \private
	 *
	 * @param mixed $val
	 * @return string
	 */
	private function jsEncode($val) {
		if (is_null($val)) {
			return 'null';
		}
		if ($val === false) {
			return 'false';
		}
		if ($val === true) {
			return 'true';
		}
		if (is_scalar($val)) {
			if (is_float($val)) {
				// Always use "." for floats.
				$val = str_replace(",", ".", strval($val));
			}

			// Use @@ to not use quotes when outputting string value
			if (strpos($val, '@@') === 0) {
				return substr($val, 2);
			} else {
				// All scalars are converted to strings to avoid indeterminism.
				// PHP's "1" and 1 are equal for all PHP operators, but
				// JS's "1" and 1 are not. So if we pass "1" or 1 from the PHP backend,
				// we should get the same result in the JS frontend (string).
				// Character replacements for JSON.
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
				array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));

				$val = str_replace($jsonReplaces[0], $jsonReplaces[1], $val);

				return '"' . $val . '"';
			}
		}
		$isList = true;
		for ($i = 0, reset($val); $i < count($val); $i++, next($val)) {
			if (key($val) !== $i) {
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList) {
			foreach ($val as $v)
				$result[] = $this->jsEncode($v);
			return '[ ' . join(', ', $result) . ' ]';
		} else {
			foreach ($val as $k => $v)
				$result[] = $this->jsEncode($k) . ': ' . $this->jsEncode($v);
			return '{ ' . join(', ', $result) . ' }';
		}
	}

	public function ckeditor_wpmore_plugin($plugins) {
		$plugins['wpmore'] = $this->plugin_path . 'plugins/wpmore/';
		return $plugins;
	}

	public function ckeditor_wpmore_button($buttons) {
		$buttons[] = array('WPMore');
		return $buttons;
	}

	public function ckeditor_wpgallery_plugin($plugins) {
		$plugins['wpgallery'] = $this->plugin_path . 'plugins/wpgallery/';
		return $plugins;
	}

	public function ckeditor_linkbrowser_plugin($plugins) {
		wp_nonce_field( 'internal-linking', '_ajax_linking_nonce', false );
		$plugins['linkbrowser'] = $this->plugin_path . 'plugins/linkbrowser/';
		return $plugins;
	}

	public function ckeditor_linkbrowser_loader() {
		$show_internal = '1' == get_user_setting( 'wplink', '0' );
		?>
		<div id="search-panel"<?php if ( ! $show_internal ) echo ' style="display:none"'; ?>>
			<div class="link-search-wrapper">
				<label>
					<span><?php _e( 'Search' ); ?></span>
					<input type="search" id="search-field" class="link-search-field" tabindex="60" autocomplete="off" />
					<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				</label>
			</div>
			<div id="search-results" class="query-results">
				<div class="query-notice unselectable no-search"><em><?php _e( 'No search term specified. Showing recent items.' ); ?></em></div>
				<div class="query-notice unselectable no-matches"><em><?php _e( 'No matches found.' ); ?></em></div>
				<ul></ul>
				<div class="river-waiting">
					<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
				</div>
			</div>
		</div>
		<?php
		die();
	}

	public function ckeditor_linkbrowser_search() {
		check_ajax_referer( 'internal-linking', '_ajax_linking_nonce' );

		$args = array();

		if ( isset( $_POST['search'] ) )
			$args['s'] = stripslashes( $_POST['search'] );
		$args['pagenum'] = ! empty( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

		$results = _WP_Editors::wp_link_query( $args );

		if ( ! isset( $results ) )
			wp_die( 0 );

		echo json_encode( $results );
		echo "\n";

		wp_die();
	}

	//filter to change data for wpeditimage plugin before insert/update in database
	public function ckeditor_insert_post_data_filter($data, $postarr = null) {
		$content = $data['post_content'];
		//change amp; to  empty character . This is to create & character before entities like gt; and lt;
		//$content = str_replace('amp;' , '', $content);
		$content = stripslashes($content);
		//change " character in caption string for &quot;
		//change amp; to  empty character . This is to create & character before entities like gt; and lt; in caption string
		$pattern = '/caption="(.+)"\]/';
		preg_match_all($pattern, $content, $matches);
		if (isset($matches[1])) {

			$content = str_replace($matches[1], str_replace('amp;', '', $matches[1]), $content);
			$content = str_replace($matches[1], str_replace('"', '&quot;', $matches[1]), $content);
		}
		//save data
		$content = addslashes($content);
		$data['post_content'] = $content;
		return $data;
	}

	public function ckeditor_externalvvq_plugin($plugins) {
		if (class_exists('VipersVideoQuicktags')) {
				$plugins['vvq'] = $this->plugin_path . 'plugins/vvq/';
		}
		return $plugins;
	}

	public function ckeditor_vvqbuttons($buttons) {
		if (class_exists('VipersVideoQuicktags')) {
			$vvqsettings = (array) get_option('vvq_options');
			$vvqbuttons = array(
				'youtube' => 'VVQYoutube',
				'googlevideo' => 'VVQGoogleVideo',
				'dailymotion' => 'VVQDailyMotion',
				'vimeo' => 'VVQVimeo',
				'veoh' => 'VVQVeoh',
				'viddler' => 'VVQViddler',
				'metacafe' => 'VVQMetacafe',
				'bliptv' => 'VVQBlipTV',
				'flickrvideo' => 'VVQFlickrVideo',
				'spike' => 'VVQSpike',
				'myspace' => 'VVQMySpace',
				'flv' => 'VVQFLV',
				'quicktime' => 'VVQQuicktime',
				'videofile' => 'VVQVideoFile'
			);
			$vvqtoolbar = array();
			foreach ($vvqsettings as $name => $val) {
				if (isset($val["button"]) && $val["button"] == 1 && isset($vvqbuttons[$name])) {
					$vvqtoolbar[] = $vvqbuttons[$name];
				}
			}
			$buttons[] = $vvqtoolbar;
		}
		return $buttons;
	}

	public function wppoll_external($plugins) {
		if (function_exists('poll_menu')) {
			$plugins['wppolls'] = $this->plugin_path . 'plugins/wppolls/';
		}
		return $plugins;
	}

	public function wppoll_buttons($buttons) {
		if (function_exists('poll_menu')) {
			$buttons[] = array('WPPolls');
		}
		return $buttons;
	}

	public function starrating_external_plugin($plugins) {
		if (defined('STARRATING_PATH')) {
			$plugins['starrating'] = $this->plugin_path . 'plugins/gd-star-rating/';
		}
		return $plugins;
	}

	public function starrating_buttons($buttons) {
		if (defined('STARRATING_PATH')) {
			$buttons[] = array('StarRating');
		}
		return $buttons;
	}

	/**
	 * List of installed CKEditor languages
	 *
	 * @return array
	 */
	public function ckeditor_load_lang_options() {
		$arr = array();

		if (DEFINED('WP_PLUGIN_DIR')) {
			$lang_file = WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/ckeditor/lang/_languages.js';
		} else {
			$lang_file = '../wp-content/plugins/ckeditor-for-wordpress/ckeditor/lang/_languages.js';
		}
		if (file_exists($lang_file)) {
			$f = fopen($lang_file, 'r');
			$file = fread($f, filesize($lang_file));
			$tmp = explode('{', $file);
			if (isset($tmp[2])) {
				$tmp = explode('}', $tmp[2]);
			}
			$langs = explode(',', $tmp[0]);
			foreach ($langs AS $key => $lang) {
				preg_match("/(\w+-?\w+):'(\w+)'/i", $lang, $matches);
				if (isset($matches[1]) && isset($matches[2]))
					$arr[$matches[1]] = $matches[2];
			}
		}

		//oops, we have no information about languages, let's use those available in CKEditor 2.4.3
		if (empty($arr)) {
				$arr = array(
					'af' => 'Afrikaans',
					'ar' => 'Arabic',
					'bg' => 'Bulgarian',
					'bn' => 'Bengali/Bangla',
					'bs' => 'Bosnian',
					'ca' => 'Catalan',
					'cs' => 'Czech',
					'da' => 'Danish',
					'de' => 'German',
					'el' => 'Greek',
					'en' => 'English',
					'en-au' => 'English (Australia)',
					'en-ca' => 'English (Canadian)',
					'en-uk' => 'English (United Kingdom)',
					'eo' => 'Esperanto',
					'es' => 'Spanish',
					'et' => 'Estonian',
					'eu' => 'Basque',
					'fa' => 'Persian',
					'fi' => 'Finnish',
					'fo' => 'Faroese',
					'fr' => 'French',
					'gl' => 'Galician',
					'he' => 'Hebrew',
					'hi' => 'Hindi',
					'hr' => 'Croatian',
					'hu' => 'Hungarian',
					'it' => 'Italian',
					'ja' => 'Japanese',
					'km' => 'Khmer',
					'ko' => 'Korean',
					'lt' => 'Lithuanian',
					'lv' => 'Latvian',
					'mn' => 'Mongolian',
					'ms' => 'Malay',
					'nb' => 'Norwegian Bokmal',
					'nl' => 'Dutch',
					'no' => 'Norwegian',
					'pl' => 'Polish',
					'pt' => 'Portuguese (Portugal)',
					'pt-br' => 'Portuguese (Brazil)',
					'ro' => 'Romanian',
					'ru' => 'Russian',
					'sk' => 'Slovak',
					'sl' => 'Slovenian',
					'sr' => 'Serbian (Cyrillic)',
					'sr-latn' => 'Serbian (Latin)',
					'sv' => 'Swedish',
					'th' => 'Thai',
					'tr' => 'Turkish',
					'uk' => 'Ukrainian',
					'vi' => 'Vietnamese',
					'zh' => 'Chinese Traditional',
					'zh-cn' => 'Chinese Simplified',
			);
		}
		asort($arr);
		return $arr;
		}

  /**
   * Remove editor-expand script as it only for default WYSIWYG editor
   */
  public function deregister_editor_expand(){
    wp_deregister_script('editor-expand');
  }
}

final class _WP_Editors {

	public static function editor_settings($editor_id, $set) {

	}

	public static function parse_settings($editor_id, $settings) {
		$set = wp_parse_args($settings, array(
			'wpautop' => true, // use wpautop?
			'media_buttons' => true, // show insert/upload button(s)
			'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
			'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
			'tabindex' => '',
			'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
			'editor_class' => '', // add extra class(es) to the editor textarea
			'teeny' => false, // output the minimal editor config used in Press This
			'dfw' => false, // replace the default fullscreen with DFW (needs specific DOM elements and css)
			'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
			'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
		));

		$set['tinymce'] = ( $set['tinymce'] && user_can_richedit() );
		$set['quicktags'] = (bool) $set['quicktags'];

		return $set;
	}

	public static function editor($content, $editor_id, $settings = array()) {
		$set = self::parse_settings($editor_id, $settings);
		$editor_class = ' class="' . trim($set['editor_class'] . ' wp-editor-area theEditor') . '"';
		$tabindex = $set['tabindex'] ? ' tabindex="' . (int) $set['tabindex'] . '"' : '';
		$rows = ' rows="' . (int) $set['textarea_rows'] . '"';
		$switch_class = 'html-active';
		$toolbar = $buttons = '';

		if (!current_user_can('upload_files'))
			$set['media_buttons'] = false;

		if ($set['quicktags'] && $set['tinymce']) {
			$switch_class = 'html-active';

			if ('html' == wp_default_editor()) {
				add_filter('the_editor_content', 'wp_htmledit_pre');
			} else {
				add_filter('the_editor_content', 'wp_richedit_pre');
				$switch_class = 'tmce-active';
			}

			$buttons .= '<a id="' . $editor_id . '-html" class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">' . __('HTML') . "</a>\n";
			$buttons .= '<a id="' . $editor_id . '-tmce" class="hide-if-no-js wp-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">' . __('Visual') . "</a>\n";
		}

		echo '<div id="wp-' . $editor_id . '-wrap" class="wp-editor-wrap ' . $switch_class . '">';

		wp_print_styles('editor-buttons');

		if (!empty($set['editor_css']))
			echo $set['editor_css'] . "\n";

		if (!empty($buttons) || $set['media_buttons']) {
			echo '<div id="wp-' . $editor_id . '-editor-tools" class="wp-editor-tools">';
			echo $buttons;

			if ($set['media_buttons']) {
				//self::$has_medialib = true;

				if (!function_exists('media_buttons'))
					include(ABSPATH . 'wp-admin/includes/media.php');

				echo '<div id="wp-' . $editor_id . '-media-buttons" class="hide-if-no-js wp-media-buttons">';
				do_action('media_buttons', $editor_id);
				echo "</div>\n";
			}
				echo "</div>\n";
		}

		$the_editor = apply_filters('the_editor', '<div id="wp-' . $editor_id . '-editor-container" class="wp-editor-container"><textarea' . $editor_class . $rows . $tabindex . ' cols="40" name="' . $set['textarea_name'] . '" id="' . $editor_id . '">%s</textarea></div>');
		$content = apply_filters('the_editor_content', $content);

		printf($the_editor, $content);
		echo "\n</div>\n\n";

		ckeditor_wordpress::getInstance()->editor_js();
	}

	public static function wp_link_query( $args = array() ) {
		$pts = get_post_types( array( 'public' => true ), 'objects' );
		$pt_names = array_keys( $pts );

		$query = array(
			'post_type' => $pt_names,
			'suppress_filters' => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'post_status' => 'publish',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'posts_per_page' => 20,
		);

		$args['pagenum'] = isset( $args['pagenum'] ) ? absint( $args['pagenum'] ) : 1;

		if ( isset( $args['s'] ) )
			$query['s'] = $args['s'];

		$query['offset'] = $args['pagenum'] > 1 ? $query['posts_per_page'] * ( $args['pagenum'] - 1 ) : 0;

		// Do main query.
		$get_posts = new WP_Query;
		$posts = $get_posts->query( $query );
		// Check if any posts were found.
		if ( ! $get_posts->post_count )
			return false;

		// Build results.
		$results = array();
		foreach ( $posts as $post ) {
			if ( 'post' == $post->post_type )
				$info = mysql2date( __( 'Y/m/d' ), $post->post_date );
			else
				$info = $pts[ $post->post_type ]->labels->singular_name;

			$results[] = array(
				'ID' => $post->ID,
				'title' => trim( esc_html( strip_tags( get_the_title( $post ) ) ) ),
				'permalink' => get_permalink( $post->ID ),
				'info' => $info,
			);
		}

		return $results;
	}

}

$ckeditor_wordpress = ckeditor_wordpress::getInstance();
?>
