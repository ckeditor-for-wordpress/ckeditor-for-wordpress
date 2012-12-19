/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license

This file is for support WordPress default/core gallery settings and image edit
Here are defined settings for context menu, css classes , html and text dataProcessor.
*/

// TODO:
// 2) Unable to type below an image in IE8 (CKEditor bug: http://dev.ckeditor.com/ticket/3899)


//indexOf function prototype for Array if not defined
if (!Array.prototype.indexOf)
{
	Array.prototype.indexOf = function(elt)
	{
		var len = this.length;

		var from = Number(arguments[1]) || 0;
		from = (from < 0)
			? Math.ceil(from)
			: Math.floor(from);
		if (from < 0)
			from += len;

		for (; from < len; from++)
		{
			if (from in this &&
				this[from] === elt)
				return from;
		}
		return -1;
	};
}

var image_attributes = {};
(function()
{
	var pluginPath;
	CKEDITOR.plugins.add( 'wpgallery',
	{
		requires : [ 'htmlwriter', 'entities'  ],
		onLoad : function()
		{
			pluginPath = this.path;
			CKEDITOR.addCss(
				'img.cke_wpgallery' +
					'{' +
					'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/gallery.png' ) + ');' +
					'background-position: center center;' +
					'background-color: #F2F8FF;' +
					'background-repeat: no-repeat;' +
					'border: 1px dashed #888888;' +
					// Commented out due to context menu issues in Webkit
					//'clear: both;' +
					//'display: block;' +
					'float: none;' +
					'width:50% !important; _width:49.9% !important;' +
					'height: 250px !important;' +
					'page-break-after: always;' +
					'}' +
					'.aligncenter, dl.aligncenter' +
					'{' +
					'display: block;' +
					'margin-left: auto;' +
					'margin-right: auto;'+
					'}' +
					'.alignleft'+
					'{' +
					'float: left;' +
					'}' +
					'.alignright' +
					'{' +
					'float: right;' +
					'}' +
					'.wp-caption' +
					'{' +
					'background: url(' + CKEDITOR.getUrl( this.path + 'images/caption.png') + ') no-repeat scroll center bottom #F1F1F1;' +
					'border: none;' +
					'padding: 8px 8px 30px 8px !important;' +
					'max-width: 632px !important; /* prevent too-wide images from breaking layout */' +
					'}'
			);
		},
		init: function( editor )
		{
			editor.addCommand( 'wpgallery_edit',
			{
				exec : function(editor)
				{
					var sel = editor.getSelection(),
					element = sel.getSelectedElement();

					// Here we get the current value
					if (CKEDITOR && element && element.data && element.data('gallery')) {
						CKEDITOR.plugins.wpgallery.createGallery( editor, element, element.data('gallery'), 0 );
					}
					var post_id = jQuery("#post_ID").attr('value');
					if (!post_id)
					{
						post_id = jQuery("[name='quickpress_post_ID']").attr('value');
					}
					//prevent type in editor when iframe is turn on
					jQuery("#add_image").click(function()
					{
						//check if iframe/popup is open if yes return false
						//do not open secon iframe if one is open
						if ( jQuery("#TB_overlay").length  == 0) return true;
						return false;
					});
					jQuery("#add_image").focus();
					tb_show('',CKEDITOR.getUrl( window.CKEDITOR_BASEPATH + '../../../../wp-admin/media-upload.php?post_id='+post_id+'&tab=gallery&TB_iframe=1'));
					//turn on opening iframe when iframe is closing
					jQuery("#TB_closeWindowButton").click(function(){
						window.parent.updateCkeGallery();
					});
					jQuery("#TB_overlay").click(function(){
						window.parent.updateCkeGallery();
					});
				}
			});
			editor.addCommand( 'wpgallery_delete',
			{
				exec : function( editor )
				{
					var sel = editor.getSelection(),
					element = sel.getSelectedElement();
					element.remove();
				}
			});
			//edit image with caption
			editor.addCommand( 'captionimage_edit',
			{
				exec : function(editor)
				{
					var sel = editor.getSelection(),
					element = sel.getSelectedElement();
					if (element.getName() == 'a')
					{
						element = element.getFirst();
						sel.selectElement(element);
					}
					if(CKEDITOR && element && element.getName() == 'img' /* && element.getAttribute('data-cke-caption')*/)
					{
						tb_show('',CKEDITOR.getUrl( window.CKEDITOR_BASEPATH + '../plugins/wpeditimage/editimage.html?ver=321&TB_iframe=true'));
					}
				}
			});
			//remove image with capiton
			editor.addCommand( 'captionimage_delete',
			{
				exec : function( editor )
				{
					var sel = editor.getSelection(),
					element = sel.getSelectedElement();
					var parent = element.getParent();
					//if parente element is a remove it
					if (parent.getName() == 'a')
					{
						parent.remove();
					}
					element.remove();
				}
			});

			editor.on( 'doubleclick', function( evt )
			{
				var element = evt.data.element;
				//for image that belongs to gallery open gallery edit
				if ( element.is( 'img' ) && element.hasClass( 'cke_wpgallery' ) )
				{
					editor.execCommand('wpgallery_edit');
					evt.cancel();
				}

				//for image inserted via WP open edit by WP, remove CKEditors image dialog
				var pattern = /wp-image-[0-9]+/;
				if ( element && element.getName() == 'img' && pattern.test(element.$.className) )
				{
					evt.data.dialog = '';
					editor.execCommand('captionimage_edit');
					evt.cancel();
				}

			});
			if ( editor.addMenuItems )
			{
				editor.addMenuItems(
				{
					wpgallery_edit :
					{
						label : 'Edit',
						command : 'wpgallery_edit',
						group : 'image',
						icon : CKEDITOR.getUrl( this.path + 'images/edit.gif' )
					},
					wpgallery_delete :
					{
						label : 'Delete',
						command : 'wpgallery_delete',
						group : 'image',
						icon : CKEDITOR.getUrl( this.path + 'images/delete.gif' )
					},
					captionimage_edit :
					{
						label : 'Edit',
						command : 'captionimage_edit',
						group : 'image',
						icon : CKEDITOR.getUrl( this.path + 'images/edit.gif' )
					},
					captionimage_delete :
					{
						label : 'Delete',
						command : 'captionimage_delete',
						group : 'image',
						icon : CKEDITOR.getUrl( this.path + 'images/delete.gif' )
					}
				});
			}
			// If the "contextmenu" plugin is loaded, register the listeners.
			if ( editor.contextMenu )
			{
				editor.contextMenu.addListener( function( element, selection )
					{
						var pattern = /wp-image-[0-9]+/;
						//if eleement is image and belongs to gallery add special buttons to gallery
						if ( element && element.getName() == 'img' && element.hasClass( 'cke_wpgallery' ) )
						{
							return { wpgallery_edit : CKEDITOR.TRISTATE_OFF, wpgallery_delete : CKEDITOR.TRISTATE_OFF };
						}//if element is image and is inserted via WP remove CKEditor's image button
						else if ( element && element.getName() == 'img' && pattern.test(element.$.className) )
						{
							editor.contextMenu.removeAll();
							return { captionimage_edit : CKEDITOR.TRISTATE_OFF, captionimage_delete : CKEDITOR.TRISTATE_OFF, cut: CKEDITOR.TRISTATE_OFF, copy: CKEDITOR.TRISTATE_OFF, paste: CKEDITOR.TRISTATE_OFF};
						}
					});
			}
		},
		afterInit : function( editor )
		{
			var dataProcessor = editor.dataProcessor,
				dataFilter = dataProcessor && dataProcessor.dataFilter,
				htmlFilter = dataProcessor && dataProcessor.htmlFilter;

			var proto = CKEDITOR.htmlDataProcessor.prototype;
			proto.toHtml = CKEDITOR.tools.override( proto.toHtml, function( org )
			{
				return function( data )
				{
					data = data.replace( /\[caption(.*?)\]([^>]+?>)(.*?)\[\/caption\]/mig, function(match, captionAttr, imgTag, captionText)
					{
						var pattern = /wp-image-([0-9]+)/i;
						var match = pattern.exec(imgTag);
						if (match[1]) {
							image_attributes['wp-image-' + match[1]] = {
								'data-cke-caption' : captionAttr.replace(/^ /, ''),
								'data-cke-caption-text' : captionText
							};
							return imgTag;
						}
						return match;
					});

					// changes here
					return org.apply( this, arguments );
				};
			});

			if ( dataFilter )
			{
				dataFilter.addRules(
				{
					text : function( text )
					{
						//change &39; character to ' character in strings inside [] - for shortcodes
						text = text.replace( /\[(.+)\]/g, function( match, cont )
						{
							cont = cont.replace(/&#39;/g,"'");
							return '[' + cont.replace( /&quot;/g, '"' ) + ']';
						});
						//change [gallery] tag to img gallery tag
						text =  text.replace( /\[gallery.*?\]/g, function( match )
						{
							return CKEDITOR.plugins.wpgallery.createGallery( editor, null, match, 1 );
						});
						return text;
					},
					elements :
					{
						'img' : function(element)
						{
							//for image with caption add special attribute
							// <img class="size-medium wp-image-19" alt="alttext" src="/IMG_7668-300x225.jpg" width="300" height="225" />
							var pattern = /wp-image-([0-9]+)/i;
							if (element.attributes && pattern.test(element.attributes['class']))
							{
								var match = pattern.exec(element.attributes['class']);
								var obj = image_attributes['wp-image-' + match[1]];
								if (obj) {
									var caption = obj['data-cke-caption'];
									var caption_text = obj['data-cke-caption-text'];
									pattern = new RegExp('wp-caption',"i");
									if (!pattern.exec(element.attributes['class']))
									{
										element.attributes['class'] = element.attributes['class'] + ' wp-caption';
									}
									pattern = /align="(aligncenter|alignnone|alignleft|alignright)"/i;
									match = pattern.exec(caption);

									if ( match && match[1])
									{
										pattern = new RegExp(match[1],"i");
										if (!pattern.exec(element.attributes['class']))
										{
											element.attributes['class'] = element.attributes['class'] + ' '+match[1];
										}
									}
									element.attributes['data-cke-caption'] =  caption;
									element.attributes['data-cke-caption-text']  = caption_text;
								}
							}
						}
					}
				});
			}
			if ( htmlFilter )
			{
				htmlFilter.addRules(
				{
					elements :
					{
						'img' : function( element )
						{
							var text;
							//convert gallery img tag
							if (element.attributes && element.attributes['data-cke-wpgallery'])
							{
								text = element.attributes['data-gallery'];
								delete element.name;
								return new CKEDITOR.htmlParser.text(text);
							}
							//convert img with caption
							if (element.attributes && element.attributes['data-cke-caption'])
							{
								//array of allowed attributes
								var allowed_attributes = ['src', 'alt', 'title', 'width', 'height', 'class', 'style'];
								text = '[caption '+ CKEDITOR.tools.htmlEncode(element.attributes['data-cke-caption']) +']';

								text += '<img ';
								for (var attribute in element.attributes)
								{
									//add only allowed attributes
									if (allowed_attributes.indexOf(attribute) != -1)
										text += attribute + '="' + CKEDITOR.tools.htmlEncode(element.attributes[attribute]) + '" ';
								}
								text += '/>' + CKEDITOR.tools.htmlEncode(element.attributes['data-cke-caption-text']).replace(/(\r\n|\n\r|\r|\n)/g, '<br />') + '[/caption]';
								delete element.name;

								return new CKEDITOR.htmlParser.text(text);
							}
						}
					},
					text : function( text )
					{
						//replace htmlentities for string in [] for shortcodes
						text= text.replace( /\[(.+)\]/g, function( match, cont )
						{
							cont = cont.replace(/&#39;/g,"'");
							//change html entities to < and >
							cont = cont.replace(/&lt;/g, '<');
							cont = cont.replace(/&gt;/g, '>');
							return '[' + cont.replace( /&amp;quot;|&quot;/g, '"' ) + ']';
						});
						return text;
					}
				});
			}
			//change elements path
			var filters;
			if ( editor._.elementsPath  )
			{
				if ( ( filters = editor._.elementsPath.filters ) )
					filters.push( function( element )
						{
							var name =  element.getName();
							if ( name == 'img' )
							{
								var data = element.data('gallery');
								if ( data)
									name = 'gallery';
							}
							return name;
						});
			}
		}
	});
	CKEDITOR.plugins.wpgallery =
	{
		createGallery : function( editor, oldElement, text, isGet )
		{
			var element = new CKEDITOR.dom.element( 'img', editor.document );
			var title = text.replace(/&amp;quot;/g,'"');
			title = title.replace(/[\]\[]/g,'');
			element.setAttributes(
			{
				'data-cke-wpgallery'	: 1,
				'contentEditable' : false,
				'class' : 'wpGallery cke_wpgallery',
				'title' : title,
				'alt' : 'gallery',
				'src' : CKEDITOR.getUrl( pluginPath + 'images/spacer.gif' )
			});

			element.data( 'gallery', text );
			if ( isGet )
				{
					return element.getOuterHtml();
				}

			if ( oldElement ) {

				if ( CKEDITOR.env.ie )
				{
					element.insertAfter( oldElement );
					// Some time is required for IE before the element is removed.
					setTimeout(function(){
						oldElement.remove();
						element.focus();
					}, 10);
				}
				else{

					element.replace( oldElement );
				}
			}
			else {
				editor.insertElement( element );
			}
			return null;
		}
	};
})();