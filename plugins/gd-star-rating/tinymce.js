function gdsrChangeShortcode(calledfrom, wpversion) {
    var tabber = "#gdsr_tabs";
    if (wpversion < 28) tabber = tabber + " > ul";

    var shortcode = document.getElementById("srShortcode").selectedIndex;
    var adminIndex = 0;
    document.getElementById("general_tab").style.display = "none";
    document.getElementById("filter_tab").style.display = "none";
    document.getElementById("styles_tab").style.display = "none";
    document.getElementById("multis_tab").style.display = "none";
    document.getElementById("multisreview_tab").style.display = "none";
    document.getElementById("articlesreview_tab").style.display = "none";
    document.getElementById("articlesrater_tab").style.display = "none";
    document.getElementById("commentsaggr_tab").style.display = "none";
    document.getElementById("blograting_tab").style.display = "none";
    switch (shortcode) {
        case 0:
            document.getElementById("general_tab").style.display = "block";
            document.getElementById("filter_tab").style.display = "block";
            document.getElementById("styles_tab").style.display = "block";
            break;
        case 3:
            document.getElementById("multis_tab").style.display = "block";
            adminIndex = 3;
            break;
        case 4:
            document.getElementById("multisreview_tab").style.display = "block";
            adminIndex = 4;
            break;
        case 6:
            document.getElementById("articlesreview_tab").style.display = "block";
            adminIndex = 5;
            break;
        case 7:
            document.getElementById("articlesrater_tab").style.display = "block";
            adminIndex = 6;
            break;
        case 8:
            document.getElementById("thumbsrating_tab").style.display = "block";
            adminIndex = 9;
            break;
        case 10:
            document.getElementById("commentsaggr_tab").style.display = "block";
            adminIndex = 7;
            break;
        case 1:
            document.getElementById("blograting_tab").style.display = "block";
            adminIndex = 8;
            break;
    }
    if (calledfrom == 'admin') {
        jQuery(tabber).tabs("select", adminIndex);
    }
}

function gdsrAdminGetShortcode() {
    var shortcode = insertStarRatingCode();
    jQuery("#gdsr-builder-shortcode").val(shortcode[0]);
    jQuery("#gdsr-builder-function").val(shortcode[1]);
}

function gdsrChangeTrend(trend, el, index) {
    document.getElementById("gdsr-"+trend+"-txt["+index+"]").style.display = el == "txt" ? "block" : "none";
    document.getElementById("gdsr-"+trend+"-img["+index+"]").style.display = el == "img" ? "block" : "none";
}

function gdsrChangeSource(el, index) {
    document.getElementById("gdsr-src-multi["+index+"]").style.display = el == "multis" ? "block" : "none";
}

function gdsrChangeTaxonomy(el, index) {
    document.getElementById("gdsr-src-tax["+index+"]").style.display = el == "taxonomy" ? "block" : "none";
}

function gdsrChangeDate(el, index) {
    document.getElementById("gdsr-pd-lastd["+index+"]").style.display = el == "lastd" ? "block" : "none";
    document.getElementById("gdsr-pd-month["+index+"]").style.display = el == "month" ? "block" : "none";
    document.getElementById("gdsr-pd-range["+index+"]").style.display = el == "range" ? "block" : "none";
}

function gdsrChangeImage(el, index) {
    document.getElementById("gdsr-pi-none["+index+"]").style.display = el == "none" ? "block" : "none";
    document.getElementById("gdsr-pi-custom["+index+"]").style.display = el == "custom" ? "block" : "none";
    document.getElementById("gdsr-pi-content["+index+"]").style.display = el == "content" ? "block" : "none";
}

function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertStarRatingCode() {
    var tagtext = "";
    var funtext = "";
    var shortcode = document.getElementById('srShortcode').value;

    if (shortcode == 'blograting') {
        tagtext = "[blograting";
        tagtext = tagtext + " template_id=" + document.getElementById('srTemplateWBR').value;
        funa = new Array();
        funtext = "wp_gdsr_render_blog_rating_widget(array(";
        funa.push("'template_id' => " + document.getElementById('srTemplateWBR').value);
        if (document.getElementById('srSelectBR').value != 'postpage') {
            tagtext = tagtext + " select='" + document.getElementById('srSelectBR').value + "'";
            funa.push("'select' => '" + document.getElementById('srSelectBR').value + "'");
        }
        if (document.getElementById('srShowBR').value != 'total') {
            tagtext = tagtext + " show='" + document.getElementById('srShowBR').value + "'";
            funa.push("'show' => '" + document.getElementById('srShowBR').value + "'");
        }
        tagtext = tagtext + "]";
        funtext = funtext + funa.join(", ") + "));"
    } else if (shortcode == 'starreview') {
        var rvw_style_added = false;
        tagtext = "[starreview";
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateRSB').value;
        if (document.getElementById('srRVWPostID').value > 0) tagtext = tagtext + " post=" + document.getElementById('srRVWPostID').value;
        funtext = "wp_gdsr_render_review(" + document.getElementById('srRVWPostID').value + ", ";
        funtext = funtext + document.getElementById('srTemplateRSB').value;
        if (document.getElementById('srRVWStarsStyle').value != 'oxygen') {
            tagtext = tagtext + " style='" + document.getElementById('srRVWStarsStyle').value + "'";
            funtext = funtext + ", '" + document.getElementById('srRVWStarsStyle').value + "'";
            rvw_style_added = true;
        }
        if (document.getElementById('srRVWStarsSize').value != '20') {
            tagtext = tagtext + " size='" + document.getElementById('srRVWStarsSize').value + "'";
            if (!rvw_style_added) {
                funtext = funtext + ", '" + document.getElementById('srRVWStarsStyle').value + "'";
            }
            funtext = funtext + ", " + document.getElementById('srRVWStarsSize').value;
        }
        tagtext = tagtext + "]";
        funtext = funtext + ");";
    } else if (shortcode == 'starcomments') {
        tagtext = "[starcomments";
        funtext = "wp_gdsr_render_comment_aggregation(0, " + document.getElementById('srTemplateCAR').value;
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateCAR').value;
        if (document.getElementById('srCagShow').value != 'total') {
            tagtext = tagtext + " show='" + document.getElementById('srCagShow').value + "'";
            funtext = funtext + ", '" + document.getElementById('srCagShow').value + "'";
        }
        tagtext = tagtext + "]";
        funtext = funtext + ");"
    } else if (shortcode == 'starrater') {
        var rtg_style_added = false;
        tagtext = "[starrater tpl=";
        funtext = "wp_gdsr_render_article(" + document.getElementById('srRatingBlockTemplate').value + ", ";
        tagtext = tagtext + document.getElementById('srRatingBlockTemplate').value;
        if (document.getElementById('srArticleRead').checked) {
           tagtext = tagtext + " read_only=1";
        }
        funtext = funtext + (document.getElementById('srArticleRead').checked ? "true" : "false");
        if (document.getElementById('srRTGStarsStyle').value != 'oxygen') {
            tagtext = tagtext + " style='" + document.getElementById('srRTGStarsStyle').value + "'";
            funtext = funtext + ", '" + document.getElementById('srRTGStarsStyle').value + "'";
            rtg_style_added = true;
        }
        if (document.getElementById('srRTGStarsSize').value != '20') {
            tagtext = tagtext + " size='" + document.getElementById('srRTGStarsSize').value + "'";
            if (!rtg_style_added) {
                funtext = funtext + ", '" + document.getElementById('srRTGStarsStyle').value + "'";
            }
            funtext = funtext + ", " + document.getElementById('srRTGStarsSize').value;
        }
        tagtext = tagtext + "]";
        funtext = funtext + ");"
    } else if (shortcode == 'starthumbsblock') {
        tagtext = "[starthumbsblock tpl=";
        funtext = "wp_gdsr_render_article_thumbs(" + document.getElementById('srThumbsTemplate').value;
        tagtext = tagtext + document.getElementById('srThumbsTemplate').value;
        if (document.getElementById('srThumbsRead').checked) {
           tagtext = tagtext + " read_only=1";
           funtext = funtext + ", true";
        }
        tagtext = tagtext + "]";
        funtext = funtext + ");"
    } else if (shortcode == 'starreviewmulti') {
        tagtext = "[starreviewmulti id=";
        funtext = "wp_gdsr_show_multi_review(" + document.getElementById('srMultiReviewSet').value;
        funtext = funtext + ", " + document.getElementById('srTemplateRMB').value;
        funtext = funtext + ", " + document.getElementById('srMultiReviewPostID').value;
        tagtext = tagtext + document.getElementById('srMultiReviewSet').value;
        if (document.getElementById('srMultiReviewPostID').value > 0) tagtext = tagtext + " post=" + document.getElementById('srMultiReviewPostID').value;
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateRMB').value;
        if (document.getElementById('srStarsStyleMRREl').value != 'oxygen') {
            tagtext = tagtext + " style='" + document.getElementById('srStarsStyleMRREl').value + "'";
        }
        if (document.getElementById('srStarsSizeMRREl').value != '20') {
            tagtext = tagtext + " size='" + document.getElementById('srStarsSizeMRREl').value + "'";
        }
        if (document.getElementById('srStarsStyleMRRAv').value != 'oxygen') {
            tagtext = tagtext + " average_stars='" + document.getElementById('srStarsStyleMRRAv').value + "'";
        }
        if (document.getElementById('srStarsSizeMRRAv').value != '20') {
            tagtext = tagtext + " average_size='" + document.getElementById('srStarsSizeMRRAv').value + "'";
        }
        funtext = funtext + ", '" + document.getElementById('srStarsStyleMRREl').value;
        funtext = funtext + "', " + document.getElementById('srStarsSizeMRREl').value;
        funtext = funtext + ", 'oxygen_gif'";
        funtext = funtext + ", '" + document.getElementById('srStarsStyleMRRAv').value;
        funtext = funtext + "', " + document.getElementById('srStarsSizeMRRAv').value;
        funtext = funtext + ", 'oxygen_gif'";
        tagtext = tagtext + "]";
        funtext = funtext + ");"
    } else if (shortcode == 'starratingmulti') {
        tagtext = '[starratingmulti id=';
        funtext = "wp_gdsr_render_multi(" + document.getElementById('srMultiRatingSet').value;
        funtext = funtext + ", " + document.getElementById('srTemplateMRB').value;
        tagtext = tagtext + document.getElementById('srMultiRatingSet').value;
        tagtext = tagtext + " tpl=" + document.getElementById('srTemplateMRB').value;
        if (document.getElementById('srMultiRead').checked) {
            tagtext = tagtext + " read_only=1";
            funtext = funtext + ", true";
        } else funtext = funtext + ", false";
        funtext = funtext + ", 0, '" + document.getElementById('srStarsStyleMUREl').value;
        funtext = funtext + "', " + document.getElementById('srStarsSizeMUREl').value;
        funtext = funtext + ", 'oxygen_gif'";
        funtext = funtext + ", '" + document.getElementById('srStarsStyleMURAv').value;
        funtext = funtext + "', " + document.getElementById('srStarsSizeMURAv').value;
        funtext = funtext + ", 'oxygen_gif'";
        if (document.getElementById('srStarsStyleMUREl').value != 'oxygen') {
            tagtext = tagtext + " style='" + document.getElementById('srStarsStyleMUREl').value + "'";
        }
        if (document.getElementById('srStarsSizeMUREl').value != '20') {
            tagtext = tagtext + " size='" + document.getElementById('srStarsSizeMUREl').value + "'";
        }
        if (document.getElementById('srStarsStyleMURAv').value != 'oxygen') {
            tagtext = tagtext + " average_stars='" + document.getElementById('srStarsStyleMURAv').value + "'";
        }
        if (document.getElementById('srStarsSizeMURAv').value != '20') {
            tagtext = tagtext + " average_size='" + document.getElementById('srStarsSizeMURAv').value + "'";
        }
        tagtext = tagtext + "]";
        funtext = funtext + ");"
    } else {
        tagtext = "[starrating";
        funtext = "wp_gdsr_render_rating_results(array(";
        funa = new Array();
        tagtext = tagtext + " template_id=" + document.getElementById('srTemplateSRR').value;
        funa.push("'template_id' => " + document.getElementById('srTemplateSRR').value);
        if (document.getElementById('srRows').value != 10) {
            tagtext = tagtext + " rows=" + document.getElementById('srRows').value;
            funa.push("'rows' => " + document.getElementById('srRows').value);
        }
        if (document.getElementById('srSelect').value != 'postpage') {
            tagtext = tagtext + " select='" + document.getElementById('srSelect').value + "'";
            funa.push("'select' => '" + document.getElementById('srSelect').value + "'");
        }
        if (document.getElementById('srColumn').value != 'rating') {
            tagtext = tagtext + " column='" + document.getElementById('srColumn').value + "'";
            funa.push("'column' => '" + document.getElementById('srColumn').value + "'");
        }
        if (document.getElementById('srOrder').value != 'desc') {
            tagtext = tagtext + " order='" + document.getElementById('srOrder').value + "'";
            funa.push("'order' => '" + document.getElementById('srOrder').value + "'");
        }
        if (document.getElementById('srLastDate').value != 0) {
            tagtext = tagtext + " last_voted_days=" + document.getElementById('srLastDate').value;
            funa.push("'last_voted_days' => " + document.getElementById('srLastDate').value);
        }
        if (document.getElementById('srCategory').value != '0') {
            tagtext = tagtext + " category=" + document.getElementById('srCategory').value;
            funa.push("'category' => " + document.getElementById('srCategory').value);
        }
        if (document.getElementById('srGrouping').value != 'post') {
            tagtext = tagtext + " grouping='" + document.getElementById('srGrouping').value + "'";
            funa.push("'grouping' => '" + document.getElementById('srGrouping').value + "'");
            if (document.getElementById('srGrouping').value == 'taxonomy') {
                tagtext = tagtext + " taxonomy='" + document.getElementById('srTaxonomy').value + "'";
                funa.push("'taxonomy' => '" + document.getElementById('srTaxonomy').value + "'");
            }
        }
        if (document.getElementById('srShow').value != 'total') {
            tagtext = tagtext + " show='" + document.getElementById('srShow').value + "'";
            funa.push("'show' => '" + document.getElementById('srShow').value + "'");
        }
        if (document.getElementById('trendRating').value != 'txt') {
            tagtext = tagtext + " trends_rating='" + document.getElementById('trendRating').value + "'";
            funa.push("'trends_rating' => '" + document.getElementById('trendRating').value + "'");
            if (document.getElementById('trendRatingSet').value != '+') {
                tagtext = tagtext + " trends_rating_set='" + document.getElementById('trendRatingSet').value + "'";
                funa.push("'trends_rating_set' => '" + document.getElementById('trendRatingSet').value + "'");
            }
        }
        else {
            if (document.getElementById('trendRatingRise').value != '+') {
                tagtext = tagtext + " trends_rating_rise='" + document.getElementById('trendRatingRise').value + "'";
                funa.push("'trends_rating_rise' => '" + document.getElementById('trendRatingRise').value + "'");
            }
            if (document.getElementById('trendRatingSame').value != '=') {
                tagtext = tagtext + " trends_rating_same='" + document.getElementById('trendRatingSame').value + "'";
                funa.push("'trends_rating_same' => '" + document.getElementById('trendRatingSame').value + "'");
            }
            if (document.getElementById('trendRatingFall').value != '-') {
                tagtext = tagtext + " trends_rating_fall='" + document.getElementById('trendRatingFall').value + "'";
                funa.push("'trends_rating_fall' => '" + document.getElementById('trendRatingFall').value + "'");
            }
        }

        if (document.getElementById('trendVoting').value != 'txt') {
            tagtext = tagtext + " trends_voting='" + document.getElementById('trendVoting').value + "'";
            funa.push("'trends_voting' => '" + document.getElementById('trendVoting').value + "'");
            if (document.getElementById('trendVotingSet').value != '+') {
                tagtext = tagtext + " trends_voting_set='" + document.getElementById('trendVotingSet').value + "'";
                funa.push("'trends_voting_set' => '" + document.getElementById('trendVotingSet').value + "'");
            }
        } else {
            if (document.getElementById('trendVotingRise').value != '+') {
                tagtext = tagtext + " trends_voting_rise='" + document.getElementById('trendVotingRise').value + "'";
                funa.push("'trends_voting_rise' => '" + document.getElementById('trendVotingRise').value + "'");
            }
            if (document.getElementById('trendVotingSame').value != '=') {
                tagtext = tagtext + " trends_voting_same='" + document.getElementById('trendVotingSame').value + "'";
                funa.push("'trends_voting_same' => '" + document.getElementById('trendVotingSame').value + "'");
            }
            if (document.getElementById('trendVotingFall').value != '-') {
                tagtext = tagtext + " trends_voting_fall='" + document.getElementById('trendVotingFall').value + "'";
                funa.push("'trends_voting_fall' => '" + document.getElementById('trendVotingFall').value + "'");
            }
        }

        if (!document.getElementById('srHidempty').checked) {
            tagtext = tagtext + " hide_empty=0";
            funa.push("'hide_empty' => false");
        }
        if (document.getElementById('srHidemptyReview').checked) {
            tagtext = tagtext + " hide_noreview=1";
            funa.push("'hide_noreview' => true");
        }
        if (document.getElementById('srHidemptyBayes').checked) {
            tagtext = tagtext + " bayesian_calculation=1";
            funa.push("'bayesian_calculation' => true");
        }
        if (document.getElementById('srMinVotes').value != 3) {
            tagtext = tagtext + " min_votes=" + document.getElementById('srMinVotes').value;
            funa.push("'min_votes' => " + document.getElementById('srMinVotes').value);
        }
        if (document.getElementById('srMinCount').value != 2) {
            tagtext = tagtext + " min_count=" + document.getElementById('srMinCount').value;
            funa.push("'min_count' => " + document.getElementById('srMinCount').value);
        }
        if (document.getElementById('srMinExcerpt').value != 10) {
            tagtext = tagtext + " excerpt_words=" + document.getElementById('srMinExcerpt').value;
            funa.push("'excerpt_words' => " + document.getElementById('srMinExcerpt').value);
        }
        if (document.getElementById('srDataSource').value != 'standard') {
            tagtext = tagtext + " source='" + document.getElementById('srDataSource').value + "'";
            funa.push("'source' => '" + document.getElementById('srDataSource').value + "'");
            if (document.getElementById('srDataSource').value == 'multis') {
                tagtext = tagtext + " source_set=" + document.getElementById('srMultiSet').value;
                funa.push("'source_set' => " + document.getElementById('srMultiSet').value);
            }
        }

        if (document.getElementById('srImageFrom').value != 'none') {
            tagtext = tagtext + " image_from='" + document.getElementById('srImageFrom').value + "'";
            funa.push("'image_from' => '" + document.getElementById('srImageFrom').value + "'");
            if (document.getElementById('srImageFrom').value == 'custom') {
                tagtext = tagtext + " image_custom='" + document.getElementById('srImageCustom').value + "'";
                funa.push("'image_custom' => '" + document.getElementById('srImageCustom').value + "'");
            }
            if (document.getElementById('srResizeX').value > 0 && document.getElementById('srResizeY').value > 0) {
                tagtext = tagtext + " image_resize_x=" + document.getElementById('srResizeX').value;
                funa.push("'image_resize_x' => " + document.getElementById('srResizeX').value);
                tagtext = tagtext + " image_resize_y=" + document.getElementById('srResizeY').value;
                funa.push("'image_resize_y' => " + document.getElementById('srResizeY').value);
            }
        }

        if (document.getElementById('publishDate').value == 'lastd') {
            if (document.getElementById('publishDays').value > 0) {
                tagtext = tagtext + " publish_days=" + document.getElementById('publishDays').value;
                funa.push("'publish_days' => " + document.getElementById('publishDays').value);
            }
        } else if (document.getElementById('publishDate').value == 'month') {
            tagtext = tagtext + " publish_date='month'";
            tagtext = tagtext + " publish_month='" + document.getElementById('publishMonth').value + "'";
            funa.push("'publish_date' => 'month'");
            funa.push("'publish_month' => '" + document.getElementById('publishMonth').value + "'");
        } else {
            tagtext = tagtext + " publish_date='range'";
            tagtext = tagtext + " publish_range_from='" + document.getElementById('publishRangeFrom').value + "'";
            tagtext = tagtext + " publish_range_to='" + document.getElementById('publishRangeTo').value + "'";
            funa.push("'publish_date' => 'range'");
            funa.push("'publish_range_from' => '" + document.getElementById('publishRangeFrom').value + "'");
            funa.push("'publish_range_to' => '" + document.getElementById('publishRangeTo').value + "'");
        }

        if (document.getElementById('srStarsStyle').value != 'oxygen') {
            tagtext = tagtext + " rating_stars='" + document.getElementById('srStarsStyle').value + "'";
            funa.push("'rating_stars' => '" + document.getElementById('srStarsStyle').value + "'");
        }
        if (document.getElementById('srStarsSize').value != '20') {
            tagtext = tagtext + " rating_size='" + document.getElementById('srStarsSize').value + "'";
            funa.push("'rating_size' => '" + document.getElementById('srStarsSize').value + "'");
        }
        if (document.getElementById('srReviewStarsStyle').value != 'oxygen') {
            tagtext = tagtext + " review_stars='" + document.getElementById('srReviewStarsStyle').value + "'";
            funa.push("'review_stars' => '" + document.getElementById('srReviewStarsStyle').value + "'");
        }
        if (document.getElementById('srReviewStarsSize').value != '20') {
            tagtext = tagtext + " review_size='" + document.getElementById('srReviewStarsSize').value + "'";
            funa.push("'review_size' => '" + document.getElementById('srReviewStarsSize').value + "'");
        }
        if (document.getElementById('srThumbsStyle').value != 'starrating') {
            tagtext = tagtext + " rating_thumb='" + document.getElementById('srThumbsStyle').value + "'";
            funa.push("'rating_thumb' => '" + document.getElementById('srThumbsStyle').value + "'");
        }
        if (document.getElementById('srThumbsSize').value != '20') {
            tagtext = tagtext + " rating_thumb_size='" + document.getElementById('srThumbsSize').value + "'";
            funa.push("'rating_thumb_size' => '" + document.getElementById('srThumbsSize').value + "'");
        }

        tagtext = tagtext + "]";
        funtext = funtext + funa.join(", ") + "));"
    }

    if (window.tinyMCE) {
        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
        tinyMCEPopup.editor.execCommand('mceRepaint');
        tinyMCEPopup.close();
    return;
    } else return new Array(tagtext, funtext);
}
