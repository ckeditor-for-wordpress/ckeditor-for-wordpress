/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.plugins.add( 'vvq',
{
	init : function( editor )
	{
		// Register the toolbar buttons.
		editor.ui.addButton( 'VVQYoutube',
			{
				label : 'Insert Youtube Video',
				icon : this.path + 'images/youtube.png',
				toolbar: 'wordpress,100',
				command : 'vvqyoutube'
			});
		editor.ui.addButton( 'VVQGoogleVideo',
			{
				label : 'Insert Google Video',
				icon : this.path + 'images/googlevideo.png',
				toolbar: 'wordpress,100',
				command : 'vvqgooglevideo'
			});
		editor.ui.addButton( 'VVQDailyMotion',
			{
				label : 'Insert DailyMotion Video',
				icon : this.path + 'images/dailymotion.png',
				toolbar: 'wordpress,100',
				command : 'vvqdailymotion'
			});
		editor.ui.addButton( 'VVQVimeo',
			{
				label : 'Insert Vimeo Video',
				icon : this.path + 'images/vimeo.png',
				toolbar: 'wordpress,100',
				command : 'vvqvimeo'
			});
		editor.ui.addButton( 'VVQVeoh',
			{
				label : 'Insert Veoh Video',
				icon : this.path + 'images/veoh.png',
				toolbar: 'wordpress,100',
				command : 'vvqveoh'
			});
		editor.ui.addButton( 'VVQViddler',
			{
				label : 'Insert Viddler Video',
				icon : this.path + 'images/viddler.png',
				toolbar: 'wordpress,100',
				command : 'vvqviddler'
			});
		editor.ui.addButton( 'VVQMetacafe',
			{
				label : 'Insert Metacafe Video',
				icon : this.path + 'images/metacafe.png',
				toolbar: 'wordpress,100',
				command : 'vvqmetacafe'
			});
		editor.ui.addButton( 'VVQBlipTV',
			{
				label : 'Insert BlipTV Video',
				icon : this.path + 'images/bliptv.png',
				toolbar: 'wordpress,100',
				command : 'vvqbliptv'
			});
		editor.ui.addButton( 'VVQFlickrVideo',
			{
				label : 'Insert FlickrVideo',
				icon : this.path + 'images/flickrvideo.png',
				toolbar: 'wordpress,100',
				command : 'vvqflicrvideo'
			});
		editor.ui.addButton( 'VVQSpike',
			{
				label : 'Insert Spike Video',
				icon : this.path + 'images/spike.png',
				toolbar: 'wordpress,100',
				command : 'vvqspike'
			});
		editor.ui.addButton( 'VVQMySpace',
			{
				label : 'Insert MySpace Video',
				icon : this.path + 'images/myspace.png',
				toolbar: 'wordpress,100',
				command : 'vvqmyspace'
			});
		editor.ui.addButton( 'VVQFLV',
			{
				label : 'Insert FLV',
				icon : this.path + 'images/flv.png',
				toolbar: 'wordpress,100',
				command : 'vvqflv'
			});
		editor.ui.addButton( 'VVQQuicktime',
			{
				label : 'Insert Quicktime Video',
				icon : this.path + 'images/quicktime.png',
				toolbar: 'wordpress,100',
				command : 'vvqquicktime'
			});
		editor.ui.addButton( 'VVQVideoFile',
			{
				label : 'Insert Video File',
				icon : this.path + 'images/videofile.png',
				toolbar: 'wordpress,100',
				command : 'vvqvideofile'
			});

		// Register the commands.
		editor.addCommand( 'vvqyoutube',
		{
			exec : function()
			{
				window.VVQButtonClick('youtube');
			}
		} );
		editor.addCommand( 'vvqgooglevideo',
		{
			exec : function()
			{
				window.VVQButtonClick('googlevideo');
			}
		} );
		editor.addCommand( 'vvqdailymotion',
		{
			exec : function()
			{
				window.VVQButtonClick('dailymotion');
			}
		} );
		editor.addCommand( 'vvqvimeo',
		{
			exec : function()
			{
				window.VVQButtonClick('vimeo');
			}
		} );
		editor.addCommand( 'vvqveoh',
		{
			exec : function()
			{
				window.VVQButtonClick('veoh');
			}
		} );
		editor.addCommand( 'vvqviddler',
		{
			exec : function()
			{
				window.VVQButtonClick('viddler');
			}
		} );
		editor.addCommand( 'vvqmetacafe',
		{
			exec : function()
			{
				window.VVQButtonClick('metacafe');
			}
		} );
		editor.addCommand( 'vvqbliptv',
		{
			exec : function()
			{
				window.VVQButtonClick('bliptv');
			}
		} );
		editor.addCommand( 'vvqflickrvideo',
		{
			exec : function()
			{
				window.VVQButtonClick('flickrvideo');
			}
		} );
		editor.addCommand( 'vvqspike',
		{
			exec : function()
			{
				window.VVQButtonClick('spike');
			}
		} );
		editor.addCommand( 'myspace',
		{
			exec : function()
			{
				window.VVQButtonClick('myspace');
			}
		} );
		editor.addCommand( 'vvqflv',
		{
			exec : function()
			{
				window.VVQButtonClick('flv');
			}
		} );
		editor.addCommand( 'vvqquicktime',
		{
			exec : function()
			{
				window.VVQButtonClick('quicktime');
			}
		} );
		editor.addCommand( 'vvqvideofile',
		{
			exec : function()
			{
				window.VVQButtonClick('videofile');
			}
		} );
	}
});
