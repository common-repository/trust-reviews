var HTML_CONTENT = '' +

    '<div class="trp-builder-platforms trp-builder-inside">' +

        '<div class="trp-toggle trp-builder-connect trp-connect-google">Connect Google</div>' +
        '<div class="trp-connect-google-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<input type="text" class="trp-connect-id" value="" placeholder="Place ID" />' +
                '<span class="trp-quest trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help"><a href="' + TRP_VARS.supportUrl + '&trp_tab=google" target="_blank">How to find Place ID</a></div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<select class="trp-connect-lang">' +
                    '<option value="">All languages</option>' +
                    '<option value="ar">Arabic</option>' +
                    '<option value="bg">Bulgarian</option>' +
                    '<option value="bn">Bengali</option>' +
                    '<option value="ca">Catalan</option>' +
                    '<option value="cs">Czech</option>' +
                    '<option value="da">Danish</option>' +
                    '<option value="de">German</option>' +
                    '<option value="el">Greek</option>' +
                    '<option value="en">English</option>' +
                    //'<option value="en-AU">English (Australian)</option>' +
                    //'<option value="en-GB">English (Great Britain)</option>' +
                    '<option value="es">Spanish</option>' +
                    '<option value="eu">Basque</option>' +
                    '<option value="eu">Basque</option>' +
                    '<option value="fa">Farsi</option>' +
                    '<option value="fi">Finnish</option>' +
                    '<option value="fil">Filipino</option>' +
                    '<option value="fr">French</option>' +
                    '<option value="gl">Galician</option>' +
                    '<option value="gu">Gujarati</option>' +
                    '<option value="hi">Hindi</option>' +
                    '<option value="hr">Croatian</option>' +
                    '<option value="hu">Hungarian</option>' +
                    '<option value="id">Indonesian</option>' +
                    '<option value="it">Italian</option>' +
                    '<option value="iw">Hebrew</option>' +
                    '<option value="ja">Japanese</option>' +
                    '<option value="kn">Kannada</option>' +
                    '<option value="ko">Korean</option>' +
                    '<option value="lt">Lithuanian</option>' +
                    '<option value="lv">Latvian</option>' +
                    '<option value="ml">Malayalam</option>' +
                    '<option value="mr">Marathi</option>' +
                    '<option value="nl">Dutch</option>' +
                    '<option value="no">Norwegian</option>' +
                    '<option value="pl">Polish</option>' +
                    '<option value="pt">Portuguese</option>' +
                    '<option value="pt-BR">Portuguese (Brazil)</option>' +
                    '<option value="pt-PT">Portuguese (Portugal)</option>' +
                    '<option value="ro">Romanian</option>' +
                    '<option value="ru">Russian</option>' +
                    '<option value="sk">Slovak</option>' +
                    '<option value="sl">Slovenian</option>' +
                    '<option value="sr">Serbian</option>' +
                    '<option value="sv">Swedish</option>' +
                    '<option value="ta">Tamil</option>' +
                    '<option value="te">Telugu</option>' +
                    '<option value="th">Thai</option>' +
                    '<option value="tl">Tagalog</option>' +
                    '<option value="tr">Turkish</option>' +
                    '<option value="uk">Ukrainian</option>' +
                    '<option value="vi">Vietnamese</option>' +
                    '<option value="zh-CN">Chinese (Simplified)</option>' +
                    '<option value="zh-TW">Chinese (Traditional)</option>' +
                '</select>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<input type="text" class="trp-connect-key" value="' + TRP_VARS.googleAPIKey + '" placeholder="Google Places API Key" />' +
                '<span class="trp-quest trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help"><a href="' + TRP_VARS.supportUrl + '&trp_tab=google" target="_blank">How to create Google Places API key</a></div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<button class="trp-connect-btn">Connect Google</button>' +
                '<small class="trp-connect-error"></small>' +
            '</div>' +
        '</div>' +

        '<div class="trp-builder-connect trp-connect-facebook">Connect Facebook</div>' +

        //'<div class="trp-builder-connect trp-connect-tripadvisor">Connect Tripadvisor</div>' +

        '<div class="trp-toggle trp-builder-connect trp-connect-yelp">Connect Yelp</div>' +
        '<div class="trp-connect-yelp-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<input type="text" class="trp-connect-id" value="" placeholder="Link to business on Yelp: https://www.yelp.com/biz/..." />' +
                '<span class="trp-quest trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">For instance: <b>https://www.yelp.com/biz/benjamin-steakhouse-new-york-2</b></div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<select class="trp-connect-lang">' +
                    '<option value="">All languages</option>' +
                    '<option value="cs_CZ">Czech Republic: Czech</option>' +
                    '<option value="da_DK">Denmark: Danish</option>' +
                    '<option value="de_AT">Austria: German</option>' +
                    '<option value="de_CH">Switzerland: German</option>' +
                    '<option value="de_DE">Germany: German</option>' +
                    '<option value="en_AU">Australia: English</option>' +
                    '<option value="en_BE">Belgium: English</option>' +
                    '<option value="en_CA">Canada: English</option>' +
                    '<option value="en_CH">Switzerland: English</option>' +
                    '<option value="en_GB">United Kingdom: English</option>' +
                    '<option value="en_HK">Hong Kong: English</option>' +
                    '<option value="en_IE">Republic of Ireland: English</option>' +
                    '<option value="en_MY">Malaysia: English</option>' +
                    '<option value="en_NZ">New Zealand: English</option>' +
                    '<option value="en_PH">Philippines: English</option>' +
                    '<option value="en_SG">Singapore: English</option>' +
                    '<option value="en_US">United States: English</option>' +
                    '<option value="es_AR">Argentina: Spanish</option>' +
                    '<option value="es_CL">Chile: Spanish</option>' +
                    '<option value="es_ES">Spain: Spanish</option>' +
                    '<option value="es_MX">Mexico: Spanish</option>' +
                    '<option value="fi_FI">Finland: Finnish</option>' +
                    '<option value="fil_PH">Philippines: Filipino</option>' +
                    '<option value="fr_BE">Belgium: French</option>' +
                    '<option value="fr_CA">Canada: French</option>' +
                    '<option value="fr_CH">Switzerland: French</option>' +
                    '<option value="fr_FR">France: French</option>' +
                    '<option value="it_CH">Switzerland: Italian</option>' +
                    '<option value="it_IT">Italy: Italian</option>' +
                    '<option value="ja_JP">Japan: Japanese</option>' +
                    '<option value="ms_MY">Malaysia: Malay</option>' +
                    '<option value="nb_NO">Norway: Norwegian</option>' +
                    '<option value="nl_BE">Belgium: Dutch</option>' +
                    '<option value="nl_NL">The Netherlands: Dutch</option>' +
                    '<option value="pl_PL">Poland: Polish</option>' +
                    '<option value="pt_BR">Brazil: Portuguese</option>' +
                    '<option value="pt_PT">Portugal: Portuguese</option>' +
                    '<option value="sv_FI">Finland: Swedish</option>' +
                    '<option value="sv_SE">Sweden: Swedish</option>' +
                    '<option value="tr_TR">Turkey: Turkish</option>' +
                    '<option value="zh_HK">Hong Kong: Chinese</option>' +
                    '<option value="zh_TW">Taiwan: Chinese</option>' +
                '</select>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<input type="text" class="trp-connect-key" value="' + TRP_VARS.yelpAPIKey + '" placeholder="Yelp API Key" />' +
                '<span class="trp-quest trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help"><a href="' + TRP_VARS.supportUrl + '&trp_tab=yelp" target="_blank">How to create Yelp API key</a></div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<button class="trp-connect-btn">Connect Yelp</button>' +
                '<small class="trp-connect-error"></small>' +
            '</div>' +
        '</div>' +

        '<div class="trp-connection-checkbox">' +
            '<label><input type="checkbox"/> Select all</label>' +
        '</div>' +

        '<div class="trp-connections"></div>' +

    '</div>' +

    '<div class="trp-connect-options">' +

        '<div class="trp-builder-top trp-toggle">Header Options</div>' +
        '<div class="trp-builder-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input id="summary_rating" type="checkbox" name="summary_rating" value="" class="trp-toggle">Summary rating' +
                    '<div class="trp-well" onclick="if(event.target.type != \'file\')return false">' +
                        '<div class="trp-builder-option">' +
                            '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="trp-connect-photo" onload="var el = this.parentNode.parentNode; if (window.summary_rating.checked) { el.style=\'display: block\'; } else { el.style=\'display: none\'; }">' +
                            '<a href="#" class="trp-connect-photo-change" onclick="var file_frame;trp_upload_photo(this.parentNode, file_frame, function() { trp_serialize_connections(); });return false;">Summary photo</a>' +
                            '<input type="hidden" name="summary_photo" value="" class="trp-connect-photo-hidden" tabindex="2">' +
                            '<input type="file" tabindex="-1" accept="image/*" onchange="trp_upload_image(this.parentNode, this.files)" style="display:none!important">' +
                        '</div>' +
                        '<div class="trp-builder-option">' +
                            '<input type="text" name="summary_name" value="" placeholder="Summary name">' +
                        '</div>' +
                        '<div class="trp-builder-option">' +
                            '<input type="text" name="summary_url" value="" placeholder="Summary link">' +
                        '</div>' +
                    '</div>' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">The option combines all connected businesses to a single (summary) header and show a merged rating, it makes sense only if you have connected more than 1 business.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="header_merge_social" value="">' +
                    'Merge ratings' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">The option groups the same connected businesses to a merged headers. For instance, if you connected three Google places and two Facebook pages, it will merge 3 Google places in the first rating and 2 Facebook in the second and show two ratings instead of five.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="header_hide_social" value="">' +
                    'Hide ratings' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">The option hides all connected (Google, Facebook and Yelp) ratings except merged. Makes sense only if you have a lot of many connected businesses in the collection and you enabled a merged rating to combine these all to one.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="header_hide_count" value="">' +
                    'Hide reviews count' +
                '</label>' +
            '</div>' +
        '</div>' +

        '<div class="trp-builder-top trp-toggle">Reviews Options</div>' +
        '<div class="trp-builder-inside" style="display:none">' +

            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="hide_reviews" value="">' +
                    'Hide reviews' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="disable_user_link" value="">' +
                    'Disable user profile links' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Pagination' +
                '<input type="text" name="pagination" value="">' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Maximum characters before \'read more\' link' +
                '<input type="text" name="text_size" value="">' +
            '</div>' +
        '</div>' +

        '<div class="trp-builder-top trp-toggle">Style Options</div>' +
        '<div class="trp-builder-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="dark_theme">' +
                    'Dark background' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Maximum width' +
                '<input type="text" name="max_width" value="" placeholder="for instance: 300px">' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Maximum height' +
                '<input type="text" name="max_height" value="" placeholder="for instance: 500px">' +
            '</div>' +
        '</div>' +

        '<div class="trp-builder-top trp-toggle">FB API Options</div>' +
        '<div class="trp-builder-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="fb_success_api" checked>' +
                    'Remember last Faceboook API success response' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help" style="display:none;">The plugin uses the Facebook Graph API to show the reviews, but sometime, this API returns some errors, for instance when connected FB account loses the admin right and the plugin shows the ungly red error about it. This option stops show such errors and displaying the reviews from the last success response from the FB API.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="fb_rating_calc">' +
                    'Calculate FB rating based on current reviews' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help" style="display:none;">The plugin gets a FB page rating from the FB Graph API, but sometime, this rating becomes outdated. This option calculates the rating manually based on current reviews/recommendations and keeps it up to date.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Facebook Ratings API limit' +
                '<input type="text" name="fb_api_limit" value="" placeholder="By default: 100">' +
            '</div>' +
        '</div>' +

        '<div class="trp-builder-top trp-toggle">Advance Options</div>' +
        '<div class="trp-builder-inside" style="display:none">' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="open_link" checked>' +
                    'Open links in new Window' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="nofollow_link" checked>' +
                    'Use no follow links' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="lazy_load_img" checked>' +
                    'Lazy load images' +
                '</label>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="google_def_rev_link">' +
                    'Use default Google reviews link' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help" style="display:none;">If the direct link to all reviews <b>https://search.google.com/local/reviews?placeid=&lt;PLACE_ID&gt;</b> does not work with your Google place (leads to 404), please use this option to use the default reviews link to Google map.</div>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Reviewer avatar size' +
                '<select name="reviewer_avatar_size">' +
                    '<option value="56" selected="selected">Small: 56px</option>' +
                    '<option value="128">Medium: 128px</option>' +
                    '<option value="256">Large: 256px</option>' +
                '</select>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Cache data' +
                '<select name="cache">' +
                    '<option value="1">1 Hour</option>' +
                    '<option value="3">3 Hours</option>' +
                    '<option value="6">6 Hours</option>' +
                    '<option value="12" selected="selected">12 Hours</option>' +
                    '<option value="24">1 Day</option>' +
                    '<option value="48">2 Days</option>' +
                    '<option value="168">1 Week</option>' +
                    '<option value="">Disable (NOT recommended)</option>' +
                '</select>' +
            '</div>' +
            '<div class="trp-builder-option">' +
                'Reviews limit' +
                '<input type="text" name="reviews_limit" value="">' +
            '</div>' +
        '</div>' +

    '</div>';

function trp_builder_init($, data) {

    var el = document.querySelector(data.el);
    if (!el) return;

    el.innerHTML = HTML_CONTENT;

    if (data.conns) {
        trp_deserialize_connections($, el, data.conns, data.opts);
    }

    // Google Connect
    var platform_google_el = el.querySelector('.trp-connect-google-inside');
    trp_connection($, platform_google_el, 'google');

    // Facebook Connect
    var platform_facebook_el = el.querySelector('.trp-connect-facebook');

    // Yelp Connect
    var platform_yelp_el = el.querySelector('.trp-connect-yelp-inside');
    trp_connection($, platform_yelp_el, 'yelp');

    $('.trp-connect-facebook', el).click(function() {
        var button = this;

        button.disabled = true;
        button.innerText = 'Connection.';
        var spinner = setInterval(function() {
            var text = button.innerText,
                dot = text.indexOf('.');
            if (dot > -1 && text.substr(dot, text.length).length < 4) {
                button.innerText += '.';
            } else {
                button.innerText = 'Connection.';
            }
        }, 500);

        var temp_code = trp_randstr(16);
        trp_popup('https://app.trust.reviews/auth/fb?scope=pages_read_engagement,pages_read_user_content,pages_show_list&state=' + temp_code, 670, 520, function() {

            $.ajax({
                url: 'https://app.trust.reviews/auth/fb/accesstoken?temp_code=' + temp_code,
                dataType: "jsonp",
                success: function (res) {

                $.ajax({
                    url: 'https://graph.facebook.com/me/accounts?access_token=' + res.accessToken + '&limit=' + 250,
                    dataType: "jsonp",
                    success: function (res) {

                    var is_show_checkbox = res.data.length > 1;
                    if (is_show_checkbox) {
                        $(el).addClass('trp-platform-multiple');
                    }

                    $.each(res.data, function(i, page) {
                        trp_connection_add($, platform_facebook_el, {
                            id       : page.id,
                            name     : page.name,
                            photo    : 'https://graph.facebook.com/' + page.id +  '/picture',
                            platform : 'facebook',
                            props    : {
                                access_token  : page.access_token,
                                default_photo : 'https://graph.facebook.com/' + page.id +  '/picture',
                            }
                        });
                        trp_serialize_connections();
                    });

                    clearInterval(spinner);
                    button.innerText = 'Connect Facebook';
                    button.disabled = false;

                }});
            }});
        });
        return false;
    });

    $('.trp-connection-checkbox input', el).change(function() {
        var target = this,
            platform = $(this).parents('.trp-builder-platforms'),
            checkboxs = $('.trp-connect-select', platform);
        $.each(checkboxs, function(i, checkbox) {
            checkbox.checked = target.checked;
        });
        trp_serialize_connections();
    });

    $('.trp-connect-options input[type="text"],.trp-connect-options textarea').keyup(function() {
        trp_serialize_connections();
    });
    $('.trp-connect-options input[type="checkbox"],.trp-connect-options select').change(function() {
        trp_serialize_connections();
    });

    $('.trp-toggle', el).unbind('click').click(function () {
        $(this).toggleClass('toggled');
        $(this).next().slideToggle();
    });

    if ($('.trp-connections').sortable) {
        $('.trp-connections').sortable({
            stop: function(event, ui) {
                trp_serialize_connections();
            }
        });
        $('.trp-connections').disableSelection();
    }
}

function trp_connection($, el, platform) {
    var connect_btn = el.querySelector('.trp-connect-btn');
    $(connect_btn).click(function() {

        var connect_id_el = el.querySelector('.trp-connect-id'),
            connect_key_el = el.querySelector('.trp-connect-key');

        if (!connect_id_el.value) {
            connect_id_el.focus();
            return false;
        } else if (!connect_key_el.value) {
            connect_key_el.focus();
            return false;
        }

        var id = (platform == 'yelp' ? /.+\/biz\/(.*?)(\?|\/|$)/.exec(connect_id_el.value)[1] : connect_id_el.value),
            lang = el.querySelector('.trp-connect-lang').value,
            key = connect_key_el.value;

        connect_btn.innerHTML = 'Please wait...';
        connect_btn.disabled = true;

        var url = TRP_VARS.handlerUrl + '&cf_action=trp_connect_' + platform + '&v=' + new Date().getTime();
        jQuery.post(url, {
            id: decodeURIComponent(id),
            lang: lang,
            key: key,
            trp_wpnonce: jQuery('#trp_nonce').val()
        }, function(res) {

            console.log('trp_connect_debug:', res);

            connect_btn.innerHTML = 'Connect ' + (platform.charAt(0).toUpperCase() + platform.slice(1));
            connect_btn.disabled = false;

            var error_el = el.querySelector('.trp-connect-error');

            if (res.status == 'success') {

                error_el.innerHTML = '';

                var connection_params = {
                    id       : res.result.id,
                    lang     : lang,
                    name     : res.result.name,
                    photo    : res.result.photo,
                    refresh  : true,
                    platform : platform,
                    props    : {
                        default_photo : res.result.photo
                    }
                };

                /*if (platform == 'google') {
                    connection_params.review_count = '';
                }*/

                trp_connection_add($, el, connection_params);
                trp_serialize_connections();

            } else {

                error_el.innerHTML = '<b>Error</b>: ' + res.result.error_message;
                if (res.result.status == 'OVER_QUERY_LIMIT') {
                    error_el.innerHTML += '<br><br>More recently, Google has limited the API to 1 request per day for new users, try to create new <a href="https://developers.google.com/places/web-service/get-api-key#get_an_api_key" target="_blank">Google API key</a>, save in the setting and Connect Google again.';
                }

            }

        }, 'json');
        return false;
    });
}

function trp_connection_add($, el, conn, checked) {

    var connected_id = 'trp-' + conn.platform + '-' + conn.id.replace(/\//g, '');
    if (conn.lang != null) {
        connected_id += conn.lang;
    }

    var connected_el = $('#' + connected_id);

    if (!connected_el.length) {
        connected_el = $('<div class="trp-connection"></div>')[0];
        connected_el.id = connected_id;
        if (conn.lang != undefined) {
            connected_el.setAttribute('data-lang', conn.lang);
        }
        connected_el.setAttribute('data-platform', conn.platform);
        connected_el.innerHTML = trp_connection_render(conn, checked);

        var connections_el = $('.trp-connections')[0];
        connections_el.appendChild(connected_el);

        jQuery('.trp-toggle', connected_el).unbind('click').click(function () {
            jQuery(this).toggleClass('toggled');
            jQuery(this).next().slideToggle();
        });

        var file_frame;
        jQuery('.trp-connect-photo-change', connected_el).on('click', function(e) {
            e.preventDefault();
            trp_upload_photo(connected_el, file_frame, function() {
                trp_serialize_connections();
            });
            return false;
        });

        jQuery('.trp-connect-photo-default', connected_el).on('click', function(e) {
            trp_change_photo(connected_el, conn.props.default_photo);
            trp_serialize_connections();
            return false;
        });

        $('input[type="text"]', connected_el).keyup(function() {
            trp_serialize_connections();
        });

        $('input[type="checkbox"]', connected_el).click(function() {
            trp_serialize_connections();
        });

        $('.trp-connect-delete', connected_el).click(function() {
            if (confirm('Are you sure to delete this business?')) {
                if (!TRP_VARS.wordpress) {
                    var id = connected_el.querySelector('input[name="id"]').value,
                        deleted = window.connections_delete.value;
                    window.connections_delete.value += (deleted ? ',' + id : id);
                }
                $(connected_el).remove();
                trp_serialize_connections();
            }
            return false;
        });
    }
}

function trp_connection_render(conn, checked) {
    var name = conn.name;
    if (conn.lang) {
        name += ' (' + conn.lang + ')';
    }

    conn.photo = conn.photo || 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

    var option = document.createElement('option');
    if (conn.platform == 'google' && conn.props && conn.props.place_id) {
        option.value = conn.props.place_id;
    } else {
        option.value = conn.id;
    }
    option.text = trp_capitalize(conn.platform) + ': ' + conn.name;

    return '' +
        '<div class="trp-toggle trp-builder-connect trp-connect-business">' +
            '<input type="checkbox" class="trp-connect-select" onclick="event.stopPropagation();" ' + (checked?'checked':'') + ' /> ' +
            name + (conn.address ? ' (' + conn.address + ')' : '') +
        '</div>' +
        '<div style="display:none">' +
            (function(props) {
                var result = '';
                for (prop in props) {
                    if (prop != 'platform' && Object.prototype.hasOwnProperty.call(props, prop)) {
                        result += '<input type="hidden" name="' + prop + '" value="' + props[prop] + '" class="trp-connect-prop" readonly />';
                    }
                }
                return result;
            })(conn.props) +
            '<input type="hidden" name="id" value="' + conn.id + '" readonly />' +
            (conn.address ? '<input type="hidden" name="address" value="' + conn.address + '" readonly />' : '') +
            (conn.access_token ? '<input type="hidden" name="access_token" value="' + conn.access_token + '" readonly />' : '') +
            '<div class="trp-builder-option">' +
                '<img src="' + conn.photo + '" alt="' + conn.name + '" class="trp-connect-photo">' +
                '<a href="#" class="trp-connect-photo-change">Change</a>' +
                '<a href="#" class="trp-connect-photo-default">Default</a>' +
                '<input type="hidden" name="photo" class="trp-connect-photo-hidden" value="' + conn.photo + '" tabindex="2"/>' +
                '<input type="file" tabindex="-1" accept="image/*" onchange="trp_upload_image(this.parentNode, this.files)" style="display:none!important">' +
            '</div>' +
            '<div class="trp-builder-option">' +
                '<input type="text" name="name" value="' + conn.name + '" />' +
            '</div>' +
            (conn.website != undefined ?
            '<div class="trp-builder-option">' +
                '<input type="text" name="website" value="' + conn.website + '" />' +
            '</div>'
            : '' ) +
            (conn.lang != undefined ?
            '<div class="trp-builder-option">' +
                '<input type="text" name="lang" value="' + conn.lang + '" placeholder="Any language" readonly />' +
            '</div>'
            : '' ) +
            (conn.review_count != undefined ?
            '<div class="trp-builder-option">' +
                '<input type="text" name="review_count" value="' + conn.review_count + '" placeholder="Total number of reviews" />' +
                '<span class="trp-quest trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">Google return only 5 most helpful reviews and does not return information about total number of reviews and you can type here it manually.</div>' +
            '</div>'
            : '' ) +
            (conn.refresh != undefined ?
            '<div class="trp-builder-option">' +
                '<label>' +
                    '<input type="checkbox" name="refresh" ' + (conn.refresh ? 'checked' : '') + '> Refresh reviews' +
                '</label>' +
                '<span class="trp-quest trp-quest-top trp-toggle" title="Click to help">?</span>' +
                '<div class="trp-quest-help">' +
                    (conn.platform == 'google' ? 'The plugin uses the Google Places API to get your reviews. <b>The API only returns the 5 most helpful reviews without sorting possibility and without information about the total number of reviews.</b> When Google changes the 5 most helpful the plugin will automatically add the new one to your database. Thus slowly building up a database of reviews.' : '') +
                    (conn.platform == 'yelp' ? 'The plugin uses the Yelp API to get your reviews. <b>The API only returns the 3 most helpful reviews without sorting possibility.</b> When Yelp changes the 3 most helpful the plugin will automatically add the new one to your database. Thus slowly building up a database of reviews.' : '') +
                '</div>' +
            '</div>'
            : '' ) +
            '<div class="trp-builder-option">' +
                '<button class="trp-connect-delete">Delete business</button>' +
            '</div>' +
        '</div>';
}

function trp_serialize_connections() {

    var connections = [],
        connections_el = document.querySelectorAll('.trp-connection');

    for (var i in connections_el) {
        if (Object.prototype.hasOwnProperty.call(connections_el, i)) {

            var select_el = connections_el[i].querySelector('.trp-connect-select');
            if (select_el && !trp_is_hidden(select_el) && !select_el.checked) {
                continue;
            }

            var connection = {},
                lang       = connections_el[i].getAttribute('data-lang'),
                platform   = connections_el[i].getAttribute('data-platform'),
                inputs     = connections_el[i].querySelectorAll('input');

            //connections[platform] = connections[platform] || [];

            if (lang != undefined) {
                connection.lang = lang;
            }

            for (var j in inputs) {
                if (Object.prototype.hasOwnProperty.call(inputs, j)) {
                    var input = inputs[j],
                        name = input.getAttribute('name');

                    if (!name) continue;

                    if (input.className == 'trp-connect-prop') {
                        connection.props = connection.props || {};
                        connection.props[name] = input.value;
                    } else {
                        connection[name] = (input.type == 'checkbox' ? input.checked : input.value);
                    }
                }
            }
            connection.platform = platform;
            connections.push(connection);
        }
    }

    var options = {},
        options_el = document.querySelector('.trp-connect-options').querySelectorAll('input[name],select,textarea');

    for (var o in options_el) {
        if (Object.prototype.hasOwnProperty.call(options_el, o)) {
            var input = options_el[o],
                name  = input.getAttribute('name');

            if (input.type == 'checkbox') {
                options[name] = input.checked;
            } else if (input.value != undefined) {
                options[name] = (input.type == 'textarea' || name == 'word_filter' || name == 'word_exclude' ? encodeURIComponent(input.value) : input.value);
            }
        }
    }

    if (TRP_VARS.wordpress) {
        document.getElementById('trp-builder-connection').value = JSON.stringify({connections: connections, options: options});
    } else {
        document.getElementById('trp-builder-connections').value = JSON.stringify(connections);
        document.getElementById('trp-builder-options').value = JSON.stringify(options);
    }
}

function trp_deserialize_connections($, el, connections, options) {
    if (TRP_VARS.wordpress) {
        options = connections.options;
        if (Array.isArray(connections.connections)) {
            connections = connections.connections;
        } else {
            var temp_conns = [];
            if (Array.isArray(connections.google)) {
                for (var c = 0; c < connections.google.length; c++) {
                    connections.google[c].platform = 'google';
                }
                temp_conns = temp_conns.concat(connections.google);
            }
            if (Array.isArray(connections.facebook)) {
                for (var c = 0; c < connections.facebook.length; c++) {
                    connections.facebook[c].platform = 'facebook';
                }
                temp_conns = temp_conns.concat(connections.facebook);
            }
            if (Array.isArray(connections.yelp)) {
                for (var c = 0; c < connections.yelp.length; c++) {
                    connections.yelp[c].platform = 'yelp';
                }
                temp_conns = temp_conns.concat(connections.yelp);
            }
            connections = temp_conns;
        }
    } else {
        connections = JSON.parse(connections);
        options = JSON.parse(options);
    }

    for (var i = 0; i < connections.length; i++) {
        trp_connection_add($, el.querySelector('.trp-builder-platforms'), connections[i], true);
    }

    for (var opt in options) {
        if (Object.prototype.hasOwnProperty.call(options, opt)) {
            var control = el.querySelector('input[name="' + opt + '"],select[name="' + opt + '"],textarea[name="' + opt + '"]');
            if (control) {
                var name = control.getAttribute('name');
                if (typeof(options[opt]) === 'boolean') {
                    control.checked = options[opt];
                } else {
                    control.value = (control.type == 'textarea' || name == 'word_filter' || name == 'word_exclude' ? decodeURIComponent(options[opt]) : options[opt]);
                    if (opt.indexOf('_photo') > -1 && control.value) {
                        control.parentNode.querySelector('img').src = control.value;
                    }
                }
            }
        }
    }
}

function trp_upload_photo(el, file_frame, cb) {
    if (TRP_VARS.wordpress) {
        if (file_frame) {
            file_frame.open();
            return;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {text: jQuery(this).data('uploader_button_text')},
            multiple: false
        });

        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            trp_change_photo(el, attachment.url);
            cb && cb(attachment.url);
        });
        file_frame.open();
    } else {
        el.querySelector('input[type="file"]').click();
        return false;
    }
}

function trp_upload_image(el, files) {
    var formData = new FormData();
    for (var i = 0, file; file = files[i]; ++i) {
        formData.append('file', file);
    }

    var handler = this;

    if (!this.xhr) {
        this.xhr = new XMLHttpRequest();
    }
    this.xhr.open('POST', 'https://media.cackle.me/upload2', true);
    this.xhr.onload = function(e) {
        if (4 === handler.xhr.readyState) {
            if (200 === handler.xhr.status && handler.xhr.responseText.length > 0) {
                var img = 'https://media.cackle.me/' + handler.xhr.responseText;
                trp_change_photo(el, img);
            }
        }
    };
    this.xhr.send(formData);
}

function trp_change_photo(el, photo_url) {
    var place_photo_hidden = jQuery('.trp-connect-photo-hidden', el),
        place_photo_img = jQuery('.trp-connect-photo', el);

    place_photo_hidden.val(photo_url);
    place_photo_img.attr('src', photo_url);
    place_photo_img.show();

    trp_serialize_connections();
}

function trp_popup(url, width, height, cb) {
    var top = top || (screen.height/2)-(height/2),
        left = left || (screen.width/2)-(width/2),
        win = window.open(url, '', 'location=1,status=1,resizable=yes,width='+width+',height='+height+',top='+top+',left='+left);
    function check() {
        if (!win || win.closed != false) {
            cb();
        } else {
            setTimeout(check, 100);
        }
    }
    setTimeout(check, 100);
}

function trp_randstr(len) {
   var result = '',
       chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
       charsLen = chars.length;
   for ( var i = 0; i < len; i++ ) {
      result += chars.charAt(Math.floor(Math.random() * charsLen));
   }
   return result;
}

function trp_is_hidden(el) {
    return el.offsetParent === null;
}

function trp_capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}