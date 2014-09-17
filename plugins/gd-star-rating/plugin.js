/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
 */
(function() {
CKEDITOR.plugins.add( 'starrating',
{
	requires: [ 'iframedialog' ],
	init : function( editor )
	{
		var me = this;
        CKEDITOR.dialog.add( 'StarRatingDialog', function (){
			return {
				title : 'Star Rating Dialog',
				minWidth : 550,
				minHeight : 450,
				contents :
					[
						{
							id : 'iframe',
							label : 'Star Rating',
							expand : true,
							elements :
								[
									{
										type : 'html',
										id : 'pageStarRating',
										label : 'Star Rating',
										style : 'width : 350px;height: 440px;',
										html : '<iframe src="'+me.path+'window.php" frameborder="0" name="iframeStarRating" id="iframeStarRating" allowtransparency="1" style="width:100%;height:435px;margin:0;padding:0;"></iframe>'
									}
								]
						}
					],
				onOk : function() {
					var editor = this.getParentEditor(),
						ratingcode = document.getElementById('iframeStarRating').contentWindow.insertStarRatingCode();
					editor.insertHtml(ratingcode[0]);
				}
			};
		});


		// Register the toolbar buttons.
		editor.ui.addButton( 'StarRating',
			{
				label : 'Star Rating',
				icon : this.path + 'starr.gif',
				command : 'starr',
				toolbar: 'wordpress,100'
			});

		// Register the commands.
		editor.addCommand( 'starr', new CKEDITOR.dialogCommand( 'StarRatingDialog' ));
	}
});
})();
