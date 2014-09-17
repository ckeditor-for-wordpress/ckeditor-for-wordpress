/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
 */

jQuery(document).ready(function() {
	CKEDITOR.on( 'dialogDefinition', function( ev )
			{
				var dialogName = ev.data.name;
				var dialogDefinition = ev.data.definition;

				if ( dialogName == 'uicolor' )
				{
					// Get a reference to the configBox and hide it (cannot be removed).
					var configBox = dialogDefinition.getContents( 'tab1' ).get( 'configBox' );
					configBox.style = 'display:none';
				}
			});

	function ckeditorUiColorOnChange() {
		var color = CKEDITOR.instances["edit-uicolor-textarea"].getUiColor();
		if (jQuery("#edit-uicolor").val() == "custom" && typeof(color) != "undefined") {
			jQuery('#edit-uicolor-user').val(color);
		}
	}

	function ckeditor_uicolor_show() {
		jQuery('#edit-uicolor-textarea').show();
		CKEDITOR.replace("edit-uicolor-textarea",
				{
					extraPlugins : 'uicolor',
					height: 60,
					uiColor: jQuery('#edit-uicolor-user').val() || '#D3D3D3',
					width: 400,
					resize_minWidth : 300,
					resize_minHeight : 140,
					toolbar : [[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList'],[ 'UIColor' ]],
					on:
					{
						focus : ckeditorUiColorOnChange,
						blur : ckeditorUiColorOnChange,
						instanceReady : ckeditorUiColorOnChange
					}
				});
	}

	function ckeditor_uicolor_hide() {
		CKEDITOR.instances["edit-uicolor-textarea"].destroy();
		jQuery('#edit-uicolor-textarea').hide();
	}

	if (jQuery("#edit-uicolor").val() == "custom") {
		ckeditor_uicolor_show();
	}

	jQuery("#edit-uicolor").bind("change", function() {
		if (jQuery(this).val() == "custom") {
			ckeditor_uicolor_show();
		}
		else {
			ckeditor_uicolor_hide();
			jQuery('#edit-uicolor-user').val("");
		}
	});
});
