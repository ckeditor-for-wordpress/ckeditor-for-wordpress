/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
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
				command : 'vvqyoutube'
			});
		editor.ui.addButton( 'VVQGoogleVideo',
			{
				label : 'Insert Google Video',
				icon : this.path + 'images/googlevideo.png',
				command : 'vvqgooglevideo'
			});
		editor.ui.addButton( 'VVQDailyMotion',
			{
				label : 'Insert DailyMotion Video',
				icon : this.path + 'images/dailymotion.png',
				command : 'vvqdailymotion'
			});
		editor.ui.addButton( 'VVQVimeo',
			{
				label : 'Insert Vimeo Video',
				icon : this.path + 'images/vimeo.png',
				command : 'vvqvimeo'
			});
		editor.ui.addButton( 'VVQVeoh',
			{
				label : 'Insert Veoh Video',
				icon : this.path + 'images/veoh.png',
				command : 'vvqveoh'
			});
		editor.ui.addButton( 'VVQViddler',
			{
				label : 'Insert Viddler Video',
				icon : this.path + 'images/viddler.png',
				command : 'vvqviddler'
			});
		editor.ui.addButton( 'VVQMetacafe',
			{
				label : 'Insert Metacafe Video',
				icon : this.path + 'images/metacafe.png',
				command : 'vvqmetacafe'
			});
		editor.ui.addButton( 'VVQBlipTV',
			{
				label : 'Insert BlipTV Video',
				icon : this.path + 'images/bliptv.png',
				command : 'vvqbliptv'
			});
		editor.ui.addButton( 'VVQFlickrVideo',
			{
				label : 'Insert FlickrVideo',
				icon : this.path + 'images/flickrvideo.png',
				command : 'vvqflicrvideo'
			});
		editor.ui.addButton( 'VVQSpike',
			{
				label : 'Insert Spike Video',
				icon : this.path + 'images/spike.png',
				command : 'vvqspike'
			});
		editor.ui.addButton( 'VVQMySpace',
			{
				label : 'Insert MySpace Video',
				icon : this.path + 'images/myspace.png',
				command : 'vvqmyspace'
			});
		editor.ui.addButton( 'VVQFLV',
			{
				label : 'Insert FLV',
				icon : this.path + 'images/flv.png',
				command : 'vvqflv'
			});
		editor.ui.addButton( 'VVQQuicktime',
			{
				label : 'Insert Quicktime Video',
				icon : this.path + 'images/quicktime.png',
				command : 'vvqquicktime'
			});
		editor.ui.addButton( 'VVQVideoFile',
			{
				label : 'Insert Video File',
				icon : this.path + 'images/videofile.png',
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
