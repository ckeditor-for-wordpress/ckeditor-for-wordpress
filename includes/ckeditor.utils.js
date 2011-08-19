/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
var	editorCKE = CKEDITOR.instances[ckeditorSettings.textarea_id];
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
	};
	CKEDITOR.on( 'instanceReady', function( ev )
	{
		var dtd = CKEDITOR.dtd;
		for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) )
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

		editorCKE = CKEDITOR.instances[ckeditorSettings.textarea_id];
	});

	if(ckeditorSettings.textarea_id != 'comment'){
		edInsertContentOld = function () { return ; };
		if(typeof(window.edInsertContent) != 'undefined'){
			edInsertContentOld = window.edInsertContent;
		}
		window.edInsertContent = function (myField, myValue) {
			if(typeof(CKEDITOR) != 'undefined' && typeof(editorCKE) != 'undefined'){
				editorCKE.insertHtml(myValue);
			} else {
				edInsertContentOld(myField, myValue);
			}
		};
		var autosaveOld = function () { return ; };
		if(typeof(window.autosave) != 'undefined'){
			autosaveOld = window.autosave;
		}
		window.autosave = function () {
			if(typeof(CKEDITOR) != 'undefined' && typeof(editorCKE) != 'undefined'){
				editorCKE.updateElement();
			}
			autosaveOld();
		};
		if(typeof(window.switchEditors) != 'undefined') {
			window.switchEditors.go = function(id, mode) {
				if ('tinymce' == mode) {
					ckeditorOn();
				} else {
					ckeditorOff();
					jQuery('.js .theEditor').attr('style', 'color: black;');
				}
			};
		}
	}
	if ( ckeditorSettings.qtransEnabled ){

		jQuery('#edButtonHTML').addClass('active');
		jQuery('#edButtonPreview').removeClass('active');
		if(ckeditorSettings.textarea_id != 'comment'){

			ckeditorSettings.textarea_id = 'qtrans_textarea_content';
			ckeditorSettings.configuration['on'].getData = function (evt) {
				evt.data.dataValue = evt.data.dataValue.replace(/(^<\/p>)|(<p>$)/g, '');
				evt.data.dataValue = evt.data.dataValue.replace(/^<p>(\s|\n|\r)*<p>/g, '<p>');
				evt.data.dataValue = evt.data.dataValue.replace(/<\/p>(\s|\n|\r)*<\/p>(\s|\n|\r)*$/g, '<\/p>');
				qtrans_save(evt.data.dataValue);
			};
			if ( jQuery('#'+ckeditorSettings.textarea_id).length && typeof CKEDITOR.instances[ckeditorSettings.textarea_id] == 'undefined' ) {
				CKEDITOR.replace(ckeditorSettings.textarea_id, ckeditorSettings.configuration);
				editorCKE = CKEDITOR.instances[ckeditorSettings.textarea_id];
			}

			window.tinyMCE = getTinyMCEObject();
		}
	}
	else {
		if(ckeditorSettings.autostart && (typeof getUserSetting == 'undefined' || getUserSetting('editor') === '' || getUserSetting('editor') == 'tinymce')){
			ckeditorOn();
		}
	}

	jQuery("#update-gallery").click(function(){
		window.parent.editorCKE.setReadOnly(false);
		window.parent.editorCKE.focus();
	});
	jQuery("#insert-gallery").click(function(){
		window.parent.editorCKE.setReadOnly(false);
		window.parent.editorCKE.focus();
	});
});
function ckeditorOn() {
	if ( jQuery('#'+ckeditorSettings.textarea_id).length && (typeof(CKEDITOR.instances) == 'undefined' || typeof(CKEDITOR.instances[ckeditorSettings.textarea_id]) == 'undefined' ) && jQuery("#"+ckeditorSettings.textarea_id).parent().parent().attr('id') != 'quick-press') {
		CKEDITOR.replace(ckeditorSettings.textarea_id, ckeditorSettings.configuration);
		if(ckeditorSettings.textarea_id == 'content') {
			setUserSetting( 'editor', 'tinymce' );
			jQuery('#quicktags').hide();
			jQuery('#edButtonPreview').addClass('active');
			jQuery('#edButtonHTML').removeClass('active');
		}
		else if(ckeditorSettings.textarea_id == 'comment') {
			var labelObj = jQuery('#'+ckeditorSettings.textarea_id).prev('label');
			if (labelObj){
				labelObj.hide();
			}
		}
	}
}

function ckeditorOff() {
	if(typeof(editorCKE) != 'undefined'){
		editorCKE.destroy();
		if(ckeditorSettings.textarea_id == 'content') {
			setUserSetting( 'editor', 'html' );
			jQuery('#quicktags').show();
			jQuery('#edButtonHTML').addClass('active');
			jQuery('#edButtonPreview').removeClass('active');
		}
	}
}

if ( !ckeditorSettings.qtransEnabled ){
	var tinymce = window.tinyMCE = getTinyMCEObject();
}
function getTinyMCEObject()
{
	var tinymce = window.tinyMCE = (function () {
		var tinyMCE = {
			get : function (id) {
				var instant = {
					isHidden : function (){return false;},
					isDirty : function (){return false;},
					execCommand : function (command, integer, val) {
						if(command == 'mceSetContent') {
							editorCKE.setData(val);
						}
					},
					onSaveContent : {
							add : function (func) {
								window.tinymceosc = func;
							}
					},
					getContentAreaContainer : function () {
						return {
							offsetHeight : editorCKE.config.height
						};
					},
					hide : function () {
						ckeditorOff();
					},
					show : function () {
						ckeditorOn();
					},
					save : function(){return;},
					focus : function(){return;}
				};
				return instant;
			},
			execCommand : function (command, integer, val) {
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
				editorCKE.updateElement();
			},
			activeEditor : {
				isHidden : function (){return false;},
				isDirty : function (){return false;},
				focus : function (){return;},
				plugins : {},
				execCommand : function(command, state, text)
				{
					if (command == "mceInsertContent")
					{
							//setTimeout is required in IE8 when inserting Image gallery from an external modal dialog
							setTimeout(function(){editorCKE.insertHtml(text);}, 0);
					}
				},
				selection : {
					getBookmark : function(name) {return '';}
				},
				windowManager : {
					bookmark: {}
				}
			},
			EditorManager :{
				activeEditor: {
					selection : {
						getNode : function(){
							var obj = jQuery(editorCKE.document.getBody().getHtml());
							var index = 0;
							jQuery.each(obj,function(i, val){
								var images = jQuery("img",jQuery(val));
								jQuery.each(images, function(key, value){
									if (jQuery(value).hasClass('wpGallery, cke_wpgallery'))
									{
										index = i;
										return;
									}
								});
							});
							if (obj.length === 0)
							{
								obj = document.createElement("p");
								//obj : nodeName = function(){ return 'p';};
								return obj;
							}
							return obj[index];
						},
						getBookmark : function(name) {return ;}
					},
					dom :{
						select : function(selector) {
							//if (navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer")
							if (CKEDITOR.env.ie || CKEDITOR.env.opera)
							{
								var images = jQuery('img', editorCKE.document.getBody().getHtml());

								if (images.length === 0 || images[0].nodeName != "IMG")
								{
									images = jQuery(editorCKE.document.getBody().getHtml() + ' img');
								}

							}else
							{
								images = jQuery('img', editorCKE.document.getBody().getHtml());
							}
							var index = 0;
							var found = false;
							jQuery.each(images, function(key, value){
								if (jQuery(value).hasClass('wpGallery, cke_wpgallery'))
								{
									index = key;
									found = true;
									return;
								}
							});
							var results =[];
							results[0] = images[index];
							if (found)
							{
								return results;
							}else
							{
								return [];
							}
						},
						getAttrib : function(el, selector)
						{
							return jQuery(el).attr(selector);
						},
						//function to set new gallery attributes
						setAttrib : function(el, selector, value)
						{
							//get CKEditor content
							var obj = editorCKE.document.getBody().getHtml();
							//patern to get gallery image tag from editor content
							var pattern = /<img .* title=['|"](gallery.*("'|&quot;")).*>/i;
							//replace " character to &quot; for display proper title hint in browser
							value = value.replace(/"/g,'&quot;');
							var match = pattern.exec(obj);
							var re;
							//if gallery tag is founded
							if(match && match[1])
							{
								//remove unnecessary character from end of string (regex pattern gets one character to much)
								match[1] = match[1].substring(0,match[1].length - 1);
								re = new RegExp(match[1],"g");
								obj = obj.replace(re,value);
							}else
							{
								//special case if image gallery title is equal "gallery"
								pattern = /<img .* title=['|"](gallery)['|"].*>/i;
								match = pattern.exec(obj);
								//if gallery tag is founded
								if(match && match[1])
								{
									//replace title for image gallery tak
									re = /title=['|"]gallery['|"]/g;
									obj = obj.replace(re,'title="'+value+'"');
									//replace cke-data attribute
									value = "["+value+"]";
									re = /(\[gallery\])/g;
									obj = obj.replace(re,value);
								}
							}
							editorCKE.document.getBody().setHtml(obj);
						},
						decode : function(text) {return text;},
						hasClass : function(element, name)
						{
							var hasClass = jQuery(element).attr('class');
							var pattern = /wpGallery/;
							return pattern.test(hasClass);
						}
					}
				}
			}
		};
		return tinyMCE;
	})();
	return tinymce;
}