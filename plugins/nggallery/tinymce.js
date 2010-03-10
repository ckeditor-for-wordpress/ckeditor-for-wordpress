function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertNGGLink() {

	var tagtext;

	var gallery = document.getElementById('gallery_panel');
	var album = document.getElementById('album_panel');
	var singlepic = document.getElementById('singlepic_panel');

	// who is active ?
	if (gallery.className.indexOf('current') != -1) {
		var galleryid = document.getElementById('gallerytag').value;
		var showtype = getCheckedValue(document.getElementsByName('showtype'));
		if (galleryid != 0 )
			tagtext = "["+ showtype + " id=" + galleryid + "]";
		else {
			if(window.tinyMCE) { tinyMCEPopup.close(); }
			return '';
		}
	}

	if (album.className.indexOf('current') != -1) {
		var albumid = document.getElementById('albumtag').value;
		var showtype = getCheckedValue(document.getElementsByName('albumtype'));
		if (albumid != 0 )
			tagtext = "[album id=" + albumid + " template=" + showtype + "]";
		else {
			if(window.tinyMCE) { tinyMCEPopup.close(); }
			return '';
		}
	}

	if (singlepic.className.indexOf('current') != -1) {
		var singlepicid = document.getElementById('singlepictag').value;
		var imgWidth = document.getElementById('imgWidth').value;
		var imgHeight = document.getElementById('imgHeight').value;
		var imgeffect = document.getElementById('imgeffect').value;
		var imgfloat = document.getElementById('imgfloat').value;

		if (singlepicid != 0 ) {
			if (imgeffect == "none")
				tagtext = "[singlepic id=" + singlepicid + " w=" + imgWidth + " h=" + imgHeight + " float=" + imgfloat + "]";
			else
				tagtext = "[singlepic id=" + singlepicid + " w=" + imgWidth + " h=" + imgHeight + " mode=" + imgeffect + " float=" + imgfloat + "]";
		} else {
			if(window.tinyMCE) { tinyMCEPopup.close(); }
			return '';
		}
	}

	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML.
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches.
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
		return;
	}
	return tagtext;
}
