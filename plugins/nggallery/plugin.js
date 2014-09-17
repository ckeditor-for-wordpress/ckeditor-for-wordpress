/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.plugins.add( 'nextgen',
{
	requires: [ 'iframedialog' ],
	init : function( editor )
	{
		var me = this;
		CKEDITOR.dialog.add( 'NextgenDialog', function (){
			return {
				title : 'Nextgen Gallery Dialog',
				minWidth : 550,
				minHeight : 450,
				contents :
					[
						{
							id : 'iframe',
							label : 'Nextgen Gallery',
							expand : true,
							elements :
								[
									{
										type : 'html',
										id : 'pageNextgen',
										label : 'NextgenGallery',
										style : 'width : 350px;height: 440px;',
										html : '<iframe src="'+me.path+'window.php" frameborder="0" name="iframeNextgen" id="iframeNextgen" allowtransparency="1" style="width:100%;height:435px;margin:0;padding:0;"></iframe>'
									}
								]
						}
					],
				onOk : function() {
					var editor = this.getParentEditor(),
						code = document.getElementById('iframeNextgen').contentWindow.insertNGGLink();
					if(code.length > 0) {
						editor.insertHtml(code);
					}
				}
			};
		});


		// Register the toolbar buttons.
		editor.ui.addButton( 'Nextgen',
			{
				label : 'Nextgen Gallery',
				icon : this.path + 'nextgen.gif',
				command : 'nextgen',
				toolbar: 'wordpress,100'
			});

		// Register the commands.
		editor.addCommand( 'nextgen', new CKEDITOR.dialogCommand( 'NextgenDialog' ));
	}
});