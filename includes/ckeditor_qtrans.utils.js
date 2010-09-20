/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

jQuery(document).ready(function () {
	
	jQuery('#edButtonHTML').addClass('active');
	jQuery('#edButtonPreview').removeClass('active');

	if(ckeditorSettings.textarea_id != 'comment'){

		ckeditorSettings.textarea_id = 'qtrans_textarea_content';
		ckeditorSettings.configuration['on'].getData = function (evt) {
			qtrans_save(evt.data.dataValue);
		}
		window.tinyMCE = (function () { 
			var tinyMCE = {
				get : function (id) {
					var instant = {
						isHidden : function () {
							if(typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) != 'undefined'){
								return false;
							} else {
								return true;
							}
						},
						execCommand : function (command, int, val) {
							if(command == 'mceSetContent') {
								CKEDITOR.instances[ckeditorSettings.textarea_id].setData(val);
							}
						},
						onSaveContent : {
								add : function (func) {
									window.tinymceosc = func;
								} 
						},
						getContentAreaContainer : function () {
							return {
								offsetHeight : CKEDITOR.instances[ckeditorSettings.textarea_id].config.height
							}
						},
						hide : function () {
							ckeditorOff();
						},
						show : function () {
							ckeditorOn();
						}
					}
					return instant; 
				},
				execCommand : function (command, int, val) {
					if(command == 'mceAddControl'){
						ckeditorSettings.textarea_id = val;
						if(ckeditorSettings.autostart) {
							ckeditorOn();
						} else {
							document.getElementById('qtrans_textarea_content').removeAttribute('style');
						}
					}
				},
				triggerSave : function(param) {
					CKEDITOR.instances[ckeditorSettings.textarea_id].updateElement();
				}
				
			}
			
			return tinyMCE;
		})(); 
	}
});