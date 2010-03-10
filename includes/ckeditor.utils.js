/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

jQuery(document).ready(function () {
	ckeditorSettings.configuration['on'] = {
		configLoaded : function ( evt ) {
			if (typeof(ckeditorSettings.externalPlugins) != 'undefined') {
				var externals=new Array();
				for(var x in ckeditorSettings.externalPlugins) {
					CKEDITOR.plugins.addExternal(x, ckeditorSettings.externalPlugins[x]);
					externals.push(x);
				}
			}
			evt.editor.config.extraPlugins += (evt.editor.config.extraPlugins ? ','+externals.join(',') : externals.join(','));
			if (typeof(ckeditorSettings.additionalButtons) != 'undefined') {
				for (var x in ckeditorSettings.additionalButtons) {
					evt.editor.config['toolbar_' + evt.editor.config.toolbar].push(ckeditorSettings.additionalButtons[x]);
				}
			}
		}
	}
	CKEDITOR.on( 'instanceReady', function( ev )
	{
		var dtd = CKEDITOR.dtd;
		for ( var e in CKEDITOR.tools.extend( {}, dtd.$block, dtd.$listItem, dtd.$tableContent ) )
		{
			ev.editor.dataProcessor.writer.setRules( e, ckeditorSettings.outputFormat);
		}
		ev.editor.dataProcessor.writer.setRules( 'br',
			{
				breakAfterOpen : true
			});
		ev.editor.dataProcessor.writer.setRules( 'pre',
			{
				indent: false
			});
	});

	if(ckeditorSettings.autostart){
		ckeditorOn();
	} else {
		jQuery('#edButtonHTML').addClass('active');
		jQuery('#edButtonPreview').removeClass('active');
	}

	if(ckeditorSettings.textarea_id != 'comment'){
		edInsertContentOld = function () { return ; };
		if(typeof(window.edInsertContent) != 'undefined'){
			edInsertContentOld = window.edInsertContent;
		}
		window.edInsertContent = function (myField, myValue) {
			if(typeof(CKEDITOR) != 'undefined' && typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) != 'undefined'){
				CKEDITOR.instances[ckeditorSettings.textarea_id].insertHtml(myValue);
			} else {
				edInsertContentOld(myField, myValue);
			}
		}
		var autosaveOld = function () { return ; };
		if(typeof(window.autosave) != 'undefined'){
			autosaveOld = window.autosave;
		}
		window.autosave = function () {
			if(typeof(CKEDITOR) != 'undefined' && typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) != 'undefined'){
				CKEDITOR.instances[ckeditorSettings.textarea_id].updateElement();
			}
			autosaveOld();
		}
		if(typeof(window.switchEditors) != 'undefined'){
			window.switchEditors.go = function(id, mode) {
				if ('tinymce' == mode) {
					ckeditorOn();
				} else {
					ckeditorOff();
				}
			}
		}
	}
});

function ckeditorOn() {
	if ( jQuery('#'+ckeditorSettings.textarea_id).length && (typeof(CKEDITOR.instances) == 'undefined' || typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) == 'undefined' )) {
		CKEDITOR.replace(ckeditorSettings.textarea_id, ckeditorSettings.configuration);
		if(ckeditorSettings.textarea_id == 'content') {
			setUserSetting( 'editor', 'tinymce' );
			jQuery('#quicktags').hide();
			jQuery('#edButtonPreview').addClass('active');
			jQuery('#edButtonHTML').removeClass('active');
		}
	}
}

function ckeditorOff() {
	if(typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) != 'undefined'){
		CKEDITOR.instances[ckeditorSettings.textarea_id].destroy();
		if(ckeditorSettings.textarea_id == 'content') {
			setUserSetting( 'editor', 'html' );
			jQuery('#quicktags').show();
			jQuery('#edButtonHTML').addClass('active');
			jQuery('#edButtonPreview').removeClass('active');
		}
	}
}
