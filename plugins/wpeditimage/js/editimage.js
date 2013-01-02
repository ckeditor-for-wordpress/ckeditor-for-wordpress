/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license

This file is for support Wordpress default/core image settings edit (style, size , css class, title, caption , link).

*/
var tinymce = null, tinyMCEPopup, tinyMCE, wpImage;
var editorCKE = window.parent.editorCKE;
var ckeditor = window.parent.CKEDITOR;
var sel = editorCKE.getSelection();
var el = sel.getSelectedElement();
tinyMCEPopup = {
	init: function() {
		var t = this, w, li, q, i, it;

		li = ('' + document.location.search).replace(/^\?/, '').split('&');
		q = {};
		for ( i = 0; i < li.length; i++ ) {
			it = li[i].split('=');
			q[unescape(it[0])] = unescape(it[1]);
		}

		if (q.mce_rdomain)
			document.domain = q.mce_rdomain;

		// Find window & API
		w = t.getWin();

		tinymce = w.tinymce;
		tinyMCE = w.tinyMCE;
		t.editor = tinymce.EditorManager.activeEditor;
		t.params = [];
	},

	getWin : function() {
		return window.dialogArguments || opener || parent || top;
	},

	/*getParam : function(n, dv) {
		return this.editor.getParam(n, dv);
	},*/

	close : function() {
		var t = this, win = t.getWin();
		// To avoid domain relaxing issue in Opera
		function close() {
			win.tb_remove();
			tinymce = tinyMCE = t.editor = null; // Cleanup
		}

		if (tinymce.isOpera)
			win.setTimeout(close, 0);
		else
			close();
	}
};
tinyMCEPopup.init();

wpImage = {
	preInit : function() {
		// import colors stylesheet from parent
		var win = tinyMCEPopup.getWin(), styles = win.document.styleSheets, url, i;

		for ( i = 0; i < styles.length; i++ ) {
			url = styles.item(i).href;
			if ( url && url.indexOf('colors') != -1 )
				document.write( '<link rel="stylesheet" href="'+url+'" type="text/css" media="all" />' );
		}
	},

	I : function(e) {
		return document.getElementById(e);
	},

	current : '',
	link : '',
	link_rel : '',
	target_value : '',
	current_size_sel : 's100',
	width : '',
	height : '',
	align : '',
	img_alt : '',

	setTabs : function(tab) {
		var t = this;

		if ( 'current' == tab.className ) return false;
		t.I('div_advanced').style.display = ( 'tab_advanced' == tab.id ) ? 'block' : 'none';
		t.I('div_basic').style.display = ( 'tab_basic' == tab.id ) ? 'block' : 'none';
		t.I('tab_basic').className = t.I('tab_advanced').className = '';
		tab.className = 'current';
		return false;
	},

	img_seturl : function(u) {
		var t = this, rel = t.I('link_rel').value;
		if ( 'current' == u ) {
			t.I('link_href').value = t.current;
			t.I('link_rel').value = t.link_rel;
		} else {
			t.I('link_href').value = t.link;
			if ( rel ) {
				rel = rel.replace( /attachment|wp-att-[0-9]+/gi, '' );
				t.I('link_rel').value = tinymce.trim(rel);
			}
		}
	},

	imgAlignCls : function(v) {

		var t = this, cls = t.I('img_classes').value;

		t.I('img_demo').className = t.align = v;

		cls = cls.replace( /align[^ "']+/gi, '' );
		cls += (' ' + v);
		cls = cls.replace( /\s+/g, ' ' ).replace( /^\s/, '' );

		if ( 'aligncenter' == v ) {
			t.I('hspace').value = '';
			t.updateStyle('hspace');
		}
		t.I('img_classes').value = cls;
	},

	showSize : function(el) {
		var t = this, demo = t.I('img_demo'), w = t.width, h = t.height, id = el.id || 's100', size;

		size = parseInt(id.substring(1), 10) / 200;
		demo.width = Math.round(w * size);
		demo.height = Math.round(h * size);

		t.showSizeClear();
		el.style.borderColor = '#A3A3A3';
		el.style.backgroundColor = '#E5E5E5';
	},

	showSizeSet : function() {
		var t = this, s130, s120, s110;

		if ( (t.width * 1.3) > parseInt(t.preloadImg.width, 10) ) {
			s130 = t.I('s130'), s120 = t.I('s120'), s110 = t.I('s110');

			s130.onclick = s120.onclick = s110.onclick = null;
			s130.onmouseover = s120.onmouseover = s110.onmouseover = null;
			s130.style.color = s120.style.color = s110.style.color = '#aaa';
		}
	},

	showSizeRem : function() {
		var t = this, demo = t.I('img_demo'), f = document.forms[0];

		demo.width = Math.round(f.width.value * 0.5);
		demo.height = Math.round(f.height.value * 0.5);
		t.showSizeClear();
		t.I(t.current_size_sel).style.borderColor = '#A3A3A3';
		t.I(t.current_size_sel).style.backgroundColor = '#E5E5E5';

		return false;
	},

	showSizeClear : function() {
		var divs = this.I('img_size').getElementsByTagName('div'), i;

		for ( i = 0; i < divs.length; i++ ) {
			divs[i].style.borderColor = '#f1f1f1';
			divs[i].style.backgroundColor = '#f1f1f1';
		}
	},

	imgEditSize : function(el) {
		var t = this, f = document.forms[0], W, H, w, h, id, size;

		if ( ! t.preloadImg || ! t.preloadImg.width || ! t.preloadImg.height )
			return;

		W = parseInt(t.preloadImg.width, 10), H = parseInt(t.preloadImg.height, 10), w = t.width || W, h = t.height || H, id = el.id || 's100';

		size = parseInt(id.substring(1), 10) / 100;

		w = Math.round(w * size);
		h = Math.round(h * size);

		f.width.value = Math.min(W, w);
		f.height.value = Math.min(H, h);

		t.current_size_sel = id;
		t.demoSetSize();
	},

	demoSetSize : function(img) {
		var demo = this.I('img_demo'), f = document.forms[0];

		demo.width = f.width.value ? Math.round(f.width.value * 0.5) : '';
		demo.height = f.height.value ? Math.round(f.height.value * 0.5) : '';
	},

	demoSetStyle : function() {
		var f = document.forms[0], demo = this.I('img_demo'), dom = tinyMCEPopup.editor.dom;
		if (demo) {
			demo.setAttribute('style', f.img_style.value);
		}
	},

	origSize : function() {
		var t = this, f = document.forms[0], el = t.I('s100');

		f.width.value = t.width = t.preloadImg.width;
		f.height.value = t.height = t.preloadImg.height;
		t.showSizeSet();
		t.demoSetSize();
		t.showSize(el);
	},

	init : function() {
		var ed = tinyMCEPopup.editor, h;

		h = document.body.innerHTML;
		document.body.innerHTML = h;
		window.setTimeout( function(){wpImage.setup();}, 500 );
	},

	setup : function() {
		var t = this, c, link, fname, f = document.forms[0], ed = tinyMCEPopup.editor,
			d = t.I('img_demo'), dom = tinyMCEPopup.dom, DL, caption = '', dlc, pa, tmp, url, pattern, match;
		if (el.getName() != 'img')
			return;
		if(el.getAttribute('src').indexOf('../wp-content') != -1 )
		{
			tmp = window.parent.document.location.pathname.split('/');
			url = window.parent.document.location.protocol + '//' + window.parent.document.location.host + '/' +  tmp[1] + '/' + el.getAttribute('src').replace(/\.\.\//, '');
			url = url.replace('/wp-admin', '');
			el.setAttribute('src', url);
		}
		f.img_src.value = d.src = link = el.getAttribute('src');
		el.setStyle('float','');
		t.getImageData();
		c = el.getAttribute('class');

/*		pattern = /caption=("|'|&quot;)(.*)("|'|&quot;)/i;
		match = pattern.exec(el.getAttribute('data-cke-caption'));*/

		if (/*match  && match[2]*/ el.getAttribute('data-cke-caption-text'))
		{
			/*tmp = match[2].replace(/&amp;/g,'&');
			tmp = tmp.replace(/&lt;/g,'<');
			tmp = tmp.replace(/&gt;/g,'>');
			f.img_cap.value = tmp;*/
			f.img_cap.value = el.getAttribute('data-cke-caption-text');
		}else
		{
			f.img_cap.value = '';
		}
		f.img_title.value = (el.getAttribute('title')) ? el.getAttribute('title') : '';
		f.img_alt.value = (el.getAttribute('alt')) ? el.getAttribute('alt') : '';
		if (ckeditor.env.ie === false)
		{
			f.border.value = (el.getAttribute('border')) ? el.getAttribute('border') : '';
		}else
		{
			f.border.value = (el.getAttribute('border')) ? el.getAttribute('border') : 0;
		}
		f.vspace.value = (el.getAttribute('vspace')) ? el.getAttribute('vspace') : '';
		f.hspace.value = (el.getAttribute('hspace')) ? el.getAttribute('hspace') : '';
		f.align.value = (el.getAttribute('align')) ? el.getAttribute('align') : '';
		f.width.value = t.width = el.getAttribute('width');
		f.height.value = t.height = el.getAttribute('height');
		f.img_classes.value = c;
		f.img_style.value = (el.getAttribute('style')) ? el.getAttribute('style') : '';
		// Move attribs to styles
		if ( el.getAttribute('hspace') )
			t.updateStyle('hspace');
		if ( el.getAttribute('border') )
			t.updateStyle('border');
		if ( el.getAttribute('vspace') )
			t.updateStyle('vspace');
		pa = el.getParent() ;
		if ( pa.getName()== 'a'  ) {
			if(pa.getAttribute('href').indexOf('../wp-content') != -1 )
			{
				tmp = window.parent.document.location.pathname.split('/');
				url = window.parent.document.location.protocol + '//' + window.parent.document.location.host + '/' +  tmp[1] + '/' + pa.getAttribute('href').replace(/\.\.\//, '');
				url = url.replace('/wp-admin', '');
				pa.setAttribute('href', url);
			}
			f.link_href.value = t.current = pa.getAttribute('href');
			f.link_title.value = (pa.getAttribute('title')) ? pa.getAttribute('title') : '';
			f.link_rel.value = t.link_rel = (pa.getAttribute('rel')) ? pa.getAttribute('rel') : '';
			f.link_style.value = (pa.getAttribute('style')) ? pa.getAttribute('style') : '';
			t.target_value = (pa.getAttribute('target')) ? pa.getAttribute('target') : '';
			f.link_classes.value = (pa.getAttribute('class')) ? pa.getAttribute('class') : '';
		}

		f.link_target.checked = ( t.target_value && t.target_value == '_blank' ) ? 'checked' : '';

		fname = link.substring( link.lastIndexOf('/') );
		fname = fname.replace(/-[0-9]{2,4}x[0-9]{2,4}/, '' );
		t.link = link.substring( 0, link.lastIndexOf('/') ) + fname;
		if ( c.indexOf('alignleft') != -1 ) {
			t.I('alignleft').checked = "checked";
			d.className = t.align = "alignleft";
		} else if ( c.indexOf('aligncenter') != -1 ) {
			t.I('aligncenter').checked = "checked";
			d.className = t.align = "aligncenter";
		} else if ( c.indexOf('alignright') != -1 ) {
			t.I('alignright').checked = "checked";
			d.className = t.align = "alignright";
		} else if ( c.indexOf('alignnone') != -1 ) {
			t.I('alignnone').checked = "checked";
			d.className = t.align = "alignnone";
		}else {
			t.I('alignnone').checked = "checked";
			d.className = t.align = "alignnone";
		}
		if ( t.width && t.preloadImg.width ) t.showSizeSet();
		document.body.style.display = '';
		//set focus on image title
		if (document.getElementById('tab_basic').getAttribute('class') == 'current' )
		{
			f.img_title.focus();
		}
	},

	remove : function() {
		var ed = tinyMCEPopup.editor, p, el;

		if (el.nodeName != 'IMG') return;

		if ( (p = ed.dom.getParent(el, 'div')) && ed.dom.hasClass(p, 'mceTemp') )
			ed.dom.remove(p);
		else if ( (p = ed.dom.getParent(el, 'A')) && p.childNodes.length == 1 )
			ed.dom.remove(p);
		else ed.dom.remove(el);

		ed.execCommand('mceRepaint');
		tinyMCEPopup.close();
		return;
	},

	update : function() {
		var t = this, f = document.forms[0], ed = tinyMCEPopup.editor, b, fixSafari = null,
			DL, P, A, DIV, do_caption = null, img_class = f.img_classes.value, html,
			id, cap_id = '', cap, DT, DD, cap_width, div_cls, lnk = '', pa, aa, url, newLink;

		if (el.getName() != 'img') return;
		if (f.img_src.value === '') {
			t.remove();
			return;
		}
		if ( f.img_cap.value !== '' && f.width.value !== '' ) {
			do_caption = 1;
			img_class = img_class.replace( /align[^ "']+\s?/gi, '' );
		}else
		{
			//img_class = img_class.replace( /wp-caption/gi, '' );
			el.removeClass('wp-caption');
			el.removeAttribute('data-cke-caption');
			el.removeAttribute('data-cke-caption-text');
			window.parent.caption = '';
		}
		img_class = img_class.replace( /wp-caption/gi, '' );
		pa = el.getParent();
		A = (pa.getName() == 'a')?pa:null;
		P = (pa.getName() == 'p')?pa:null;
		DL = (pa.getName() == 'dl')?pa:null;
		DIV = (pa.getName() == 'div')?pa:null;
		img_class =img_class.replace(/(\s+)/ig,' ');
		el.setAttributes( {
			src : f.img_src.value,
			title : f.img_title.value,
			alt : f.img_alt.value,
			width : f.width.value,
			height : f.height.value,
			style : f.img_style.value,
			'class' : img_class
		});

		if ( f.link_href.value ) {
			// Create new anchor elements
			if ( A === null ) {
				// if new url doesn't start with http(s) or www. built link from document location elements
				if ( ! f.link_href.value.match(/https?:\/\//i)  && !f.link_href.value.match(/www\./i))
				{
					url = window.parent.document.location.pathname.split('/');
					url.pop();
					url = url.join('/');
					url = window.parent.document.location.protocol + '//' + window.parent.document.location.host+ '/'  + url + '/' + f.link_href.value;
					url = url.replace('/wp-admin', '');
					f.link_href.value = url;
				}
				//fix for webkit
				if ( ckeditor.env.webkit && el.hasClass('aligncenter') ) {
					el.removeClass('aligncenter');
					fixSafari = 1;
				}
				//create new link element end add it to image with caption parent element
				newLink = new ckeditor.dom.element( 'a' );
				newLink.setAttributes( {
					href : f.link_href.value,
					title : f.link_title.value,
					rel : f.link_rel.value,
					target : (f.link_target.checked === true) ? '_blank' : '',
					'class' : f.link_classes.value,
					style : f.link_style.value
				});
				var parent = el.getParent();
				el.appendTo(newLink, true);
				newLink.appendTo(parent, true);

				if ( fixSafari ) el.addClass('aligncenter');
			} else {
				A.setAttributes( {
					href : f.link_href.value,
					title : f.link_title.value,
					rel : f.link_rel.value,
					target : (f.link_target.checked === true) ? '_blank' : '',
					'class' : f.link_classes.value,
					style : f.link_style.value,
					'data-cke-saved-href' : f.link_href.value
				});
			}
		}

		if ( do_caption ) {

			div_cls = (t.align == 'aligncenter') ? 'mceTemp mceIEcenter' : 'mceTemp';
			parent = el.getParent();
			if ( (id = f.img_classes.value.match( /wp-image-([0-9]{1,6})/ )) && id[1] )
				cap_id = 'attachment_'+id[1];
			//prevent insert HTML markup in image caption
			pattern = /(<[\w'"=\s]+>([\S\s]+)<\/\S+>)/ig;
			captionText = f.img_cap.value.replace(pattern, function(match, cont)
			{
					cont =  cont.replace(/<[\w'"=\s]+>([\S\s]+)<\/\S+>/ig, function(match, cont){
					return cont;
				});
				return cont;
			});
			captionText = captionText.replace(/<br\/>|<br>|<br \>|<br \/ >|<br\/ >/i,'');
			captionText = captionText.replace(/"/i,'&quot;');
			el.setAttribute('data-cke-caption',' id="'+cap_id+'" align="'+t.align+'" width="'+f.width.value+'"');
			el.setAttribute('data-cke-caption-text',window.parent.CKEDITOR.tools.htmlEncode(captionText));
			el.addClass('wp-caption');
			el.addClass(t.align);
		} else {
			cap_id = '';
			f.img_cap.value = '';
			f.width.value = '';
			el.removeAttribute('data-cke-caption');
			el.removeAttribute('data-cke-caption-text');
			el.removeClass('wp-caption');

			if ( DIV) {
				if ( f.link_href.value && (aa = el.getParent()) && aa.getName() == 'a' ) html = aa.getOuterHtml();
				else html = el.getOuterHtml();

				P = new ckeditor.dom.element( 'p' );
				P.appendHtml(html);
				DIV.parentNode.insertBefore(P, DIV);
				DIV.remove();
			}
		}

		//if search parent P element for image with caption
		if (P === null || typeof P == 'undefined')
		{
			var parents = el.getParents(true);
			for (var i in parents)
			{

				if (parents[i].hasOwnProperty('getName')&& parents[i].getName() == 'p')
				{
					P = parents[i];
				}
			}
		}

		if ( f.img_classes.value.indexOf('aligncenter') != -1 ) {
			if ( P && ( ! P.style || P.style.textAlign != 'center' ) )
				P.setStyle('textAlign', 'center');
		} else {
			if ( P && P.style && P.style.textAlign == 'center' )
				P.setStyle('textAlign', '');
		}
		sel.selectElement(el);
		if ( ! f.link_href.value && A ) {
			A.remove(true);
		}
		tinyMCEPopup.close();
	},

	updateStyle : function(ty) {
		var  v, f = document.forms[0], img;

			// Handle align
			if (ty == 'align') {
				el.setStyle('float', '');
				el.setStyle('vertical-align', '');

				v = f.align.value;
				if (v) {

					if (v == 'left' || v == 'right')
					{
//						dom.setStyle(img, 'float', v);
						el.setStyle('float', v);
					}
					else{
						img.style.verticalAlign = v;
					}
				}
			}

			// Handle border

			if (ty == 'border') {
				el.setStyle('border', '');
				v = f.border.value;
				if (v || v == '0') {
					if (v == '0')
						el.setStyle('border', 0);
					else
						el.setStyle('border', v + 'px solid black');
				}
			}
			// Handle hspace
			if (ty == 'hspace') {
				el.setStyle('marginLeft', '');
				el.setStyle('marginRight', '');

				v = f.hspace.value;

				if (v) {
					el.setStyle('marginLeft', v + 'px');
					el.setStyle('marginRight', v + 'px');
				}
			}

			// Handle vspace
			if (ty == 'vspace') {
				el.setStyle('marginTop', '');
				el.setStyle('marginBottom', '');

				v = f.vspace.value;
				if (v) {
					el.setStyle('marginTop', v + 'px');
					el.setStyle('marginBottom', v + 'px');
				}
			}
			f.img_style.value = el.getAttribute('style');
			this.demoSetStyle();
	},

	checkVal : function(f) {
		if ( f.value === '' ) {
			if ( f.id == 'img_src' ) f.value = this.I('img_demo').src || this.preloadImg.src;
		}
	},

	resetImageData : function() {
		var f = document.forms[0];

		f.width.value = f.height.value = '';
	},

	updateImageData : function() {
		var f = document.forms[0], t = wpImage, w = f.width.value, h = f.height.value;

		if ( !w && h )
			w = f.width.value = t.width = Math.round( t.preloadImg.width / (t.preloadImg.height / h) );
		else if ( w && !h )
			h = f.height.value = t.height = Math.round( t.preloadImg.height / (t.preloadImg.width / w) );

		if ( !w )
			f.width.value = t.width = t.preloadImg.width;

		if ( !h )
			f.height.value = t.height = t.preloadImg.height;

		t.showSizeSet();
		t.demoSetSize();
		if ( f.img_style.value )
			t.demoSetStyle();
	},

	getImageData : function() {
		var t = wpImage, f = document.forms[0];
		t.preloadImg = new Image();
		t.preloadImg.onload = t.updateImageData;
		t.preloadImg.onerror = t.resetImageData;
		t.preloadImg.src = f.img_src.value;
	}
};

window.onload = function(){wpImage.init();};
wpImage.preInit();