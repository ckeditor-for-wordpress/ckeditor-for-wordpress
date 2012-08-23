/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file Plugin for browsing internal links - post and pages
 */
( function($) {
	CKEDITOR.plugins.add( 'linkbrowser', {
		init: function( editor ) {
			CKEDITOR.on('dialogDefinition', function(ev) {
				var dialogName = ev.data.name,
				dialogDefinition = ev.data.definition,
					tokenValue = $('#_ajax_linking_nonce').val(),
					searchPanel,
					searchField,
					searchResults,
					searchExecute = true,
					searchExecuted,
					searchWaiting,
					searchScrollWaiting,
					resultNoSearch,
					resultNoMatches;

				//load container with elements and translations from WP by AJAX call
				var loaderLinkbrowser = function(url) {
					searchPanel.load(url, {
						action: 'linkbrowser_loader'
					}, function() {
						searchField = $("#search-field", searchPanel).css({
							'float': 'left',
							'margin-top': '5px'
						});
						searchResults = $("#search-results", searchPanel).show();
						searchWaiting = searchField.next().css('float', 'left');
						searchScrollWaiting = $("div.river-waiting", searchPanel);
						resultNoSearch = $("div.no-search", searchPanel);
						resultNoMatches = $("div.no-matches", searchPanel).hide();
						$(">em", $().add(resultNoMatches).add(resultNoSearch)).css('font-style', 'italic');

						$("ul>li", searchResults).live('click', function() {
							var self = this;
							if (dialogDefinition.dialog.getName() == 'link' && typeof(dialogDefinition.dialog.getContentElement('info', 'url')) != 'undefined') {
								dialogDefinition.dialog.setValueOf('info', 'url', $('input.item-permalink', self).val());
								dialogDefinition.dialog.selectPage('info');
							}
							if (dialogDefinition.dialog.getName() == 'image' && typeof(dialogDefinition.dialog.getContentElement('Link', 'txtUrl')) != 'undefined') {
								dialogDefinition.dialog.setValueOf('Link', 'txtUrl', $('input.item-permalink', self).val());
								dialogDefinition.dialog.selectPage('Link');
							}
						});

						searchField.keyup(function(key) {
							var self = this;
							var query = {
								action : 'linkbrowser_search',
								page : 1,
								'_ajax_linking_nonce' : tokenValue
							};
							if ($(self).val().length >= 3) {
								query.search = $(self).val();
								searchExecute = searchExecuted = true;
								resultNoSearch.hide();
								searchWaiting.show();
							}
							else {
								if (searchExecuted) {
									delete query.search;
									searchExecute = true;
									searchExecuted = false;
									resultNoSearch.show();
									resultNoMatches.hide();
								}
							}
							if (searchExecute) {
								loaderData(ajaxurl, query, false);
								searchExecute = false;
							}
						}).trigger('keyup');
					});
				};

				var cleanLinkbrowser = function() {
					searchWaiting.hide();
					searchScrollWaiting.hide();
					$(searchResults).unbind('scroll');
					searchField.val('').trigger('keyup');
				}

				//load data from WP by AJAX call and handle scrolling with lazy data loading
				var loaderData = function(url, query, append) {
					if (typeof append == 'undefined') append = false;
					var self = this;
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: url,
						data: query
					}).done(function(data) {
						if (data == false) {
							searchWaiting.hide();
							searchScrollWaiting.hide();
							$(searchResults).unbind('scroll');
						}
						var list = '';
						$.each(data, function() {
							var classes = 'alternate';
							classes += this['title'] ? '' : ' no-title';
							list += classes ? '<li class="' + classes + '">' : '<li>';
							list += '<input type="hidden" class="item-permalink" value="' + this['permalink'] + '" />';
							list += '<span class="item-title">';
							list += this['title'];
							list += '</span><span class="item-info">' + this['info'] + '</span></li>';
						});
						if (append) {
							$("ul", searchResults).append(list);
							searchScrollWaiting.hide();
						}
						else {
							$("ul", searchResults).html(list);
							searchWaiting.hide();
							$(searchResults).scroll(function(){
								var infoMsgHeight = parseInt($("div.query-notice:visible", this).height());
								var totalHeight = infoMsgHeight;
								$("ul>li", this).each(function() {
									totalHeight += parseInt($(this).outerHeight());
								});
								var bottom = $(this).scrollTop() + $(this).innerHeight();
								if (bottom >= totalHeight) {
									searchScrollWaiting.show();
									query.page += 1;
									loaderData(url, query, true);
								}
							});
						}

						if ($("ul>li", searchResults).length == 0) {
							resultNoMatches.show();
						}
						else {
							resultNoMatches.hide();
						}
					});
					searchExecute = false;
				}

				//resize window
				if (dialogName == "link") {
					dialogDefinition.width = 410;
				}
				else if (dialogName == "image") {
					dialogDefinition.width = 430;
				}
				//init all on first window load
				var onLoad = dialogDefinition.onLoad;
				dialogDefinition.onLoad = function() {
					searchPanel = $('div#search-panel');
					loaderLinkbrowser(ajaxurl);
					onLoad && onLoad.call( this );
				}
				//clear tab on close - click OK button
				var onOk = dialogDefinition.onOk;
				dialogDefinition.onOk = function() {
					cleanLinkbrowser();
					onOk && onOk.call( this );
				}
				//clear tab on close - click CANCEL or CLOSE button
				var onCancel = dialogDefinition.onCancel;
				dialogDefinition.onCancel = function() {
					cleanLinkbrowser();
					onCancel && onCancel.call( this );
				}

				//add new tab
				if ((dialogName == "link" || dialogName == "image") && dialogDefinition.getContents('linkBrowserTab') == null) {
					dialogDefinition.addContents({
						id : 'linkBrowserTab',
						label : 'Link Browser',
						elements : [{
							id : 'linkBrowser',
							type : 'html',
							html: '<div id="wp-link"><div id="search-panel"></div></div>'
						}]
					});

				}
			});
		}
	});

} )(jQuery);