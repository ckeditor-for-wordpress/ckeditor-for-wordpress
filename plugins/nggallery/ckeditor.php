<?php

/**
 * add_ckeditor_button
 *
 * @package NextGEN Gallery
 * @title CKEditor Button Integration (for WP2.5 and higher)
 * @author CKSource
 * @access public
 */
class add_ckeditor_button {

	var $pluginname = 'NextGEN';
	var $path = '';
	var $internalVersion = 100;

	/**
	 * add_nextgen_button::add_nextgen_button()
	 * the constructor
	 *
	 * @return void
	 */
	function add_ckeditor_button()  {
		// Set path to editor_plugin.js
		//$siteurl = trailingslashit(get_option('siteurl'));
		$this->path = CKEDITOR_PLUGIN_URL . 'plugins/nggallery/';

		// init process for button control
		$this->addbuttons();
	}

	/**
	 * add_nextgen_button::addbuttons()
	 *
	 * @return void
	 */
	function addbuttons() {

		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
			return;

		// Check for NextGEN capability
		if ( !current_user_can('NextGEN Use TinyMCE') )
			return;

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {

			// add the button for wp2.5 in a new way
			add_filter( 'ckeditor_external_plugins', array(&$this, 'add_ckeditor_plugin') );
			add_filter( 'ckeditor_buttons', array(&$this, 'add_ckeditor_buttons') );

		}
	}

    function add_ckeditor_plugin($plugins) {
    	if (defined('NGGALLERY_ABSPATH')) {
    		$plugins['nextgen'] = $this->path;
    	}
    	return $plugins;
    }

    function add_ckeditor_buttons($buttons) {
    	if (defined('NGGALLERY_ABSPATH')) {
    		$buttons[]=array('Nextgen');
    	}
    	return $buttons;
    }
}

// Call it now
$ckeditor_button = new add_ckeditor_button ();

?>
