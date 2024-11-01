function trp_load_imgs(el) {
    var imgs = el.querySelectorAll('img.trp-blazy[data-src]');
    for (var i = 0; i < imgs.length; i++) {
        imgs[i].setAttribute('src', imgs[i].getAttribute('data-src'));
        imgs[i].removeAttribute('data-src');
    }
}

function trp_next_reviews(pagin) {
    var parent = this.parentNode,
        selector = '.trp .trp-hide';
        reviews = parent.querySelectorAll(selector);
    for (var i = 0; i < pagin && i < reviews.length; i++) {
        if (reviews[i]) {
            reviews[i].className = reviews[i].className.replace('trp-hide', '');
        }
    }
    reviews = parent.querySelectorAll(selector);
    if (reviews.length < 1) {
        parent.removeChild(this);
    }
    window.trp_blazy && window.trp_blazy.revalidate();
    return false;
}

function _trp_lang() {
    var n = navigator;
    return (n.language || n.systemLanguage || n.userLanguage ||  'en').substr(0, 2).toLowerCase();
}

function _trp_init_timeago(el) {
    var els = el.querySelectorAll('.trp-review-time');
    for (var i = 0; i < els.length; i++) {
        var clss = els[i].className, time;
        time = parseInt(els[i].getAttribute('data-time')) * 1000;
        els[i].innerHTML = WPacTime.getTime(time, _trp_lang(), 'ago');
    }
}

function _trp_init_blazy(attempts) {
    if (!window.Blazy) {
        if (attempts > 0) {
            setTimeout(function() { _trp_init_blazy(attempts - 1); }, 200);
        }
        return;
    }
    window.trp_blazy = new Blazy({selector: 'img.trp-blazy'});
}

function _trp_read_more(el) {
    var read_more = el.querySelectorAll('.trp-more-toggle');
    for (var i = 0; i < read_more.length; i++) {
        (function(rm) {
        rm.onclick = function() {
            rm.parentNode.removeChild(rm.previousSibling.previousSibling);
            rm.previousSibling.className = '';
            rm.textContent = '';
        };
        })(read_more[i]);
    }
}

function _trp_get_parent(el, cl) {
    cl = cl || 'trp';
    if (el.className.split(' ').indexOf(cl) < 0) {
        // the last semicolon (;) without braces ({}) in empty loop makes error in WP Faster Cache
        //while ((el = el.parentElement) && el.className.split(' ').indexOf(cl) < 0);
        while ((el = el.parentElement) && el.className.split(' ').indexOf(cl) < 0){}
    }
    return el;
}

function trp_init_list_theme(el) {
    el = _trp_get_parent(el);
    _trp_init_timeago(el);
    _trp_read_more(el);
    _trp_init_blazy(10);
}

document.addEventListener('DOMContentLoaded', function() {
    var jsexec = function(js) {
            eval(js);
        },
        trpimgs = document.querySelectorAll('.trp > img[data-exec="false"]');
    for (var i = 0; i < trpimgs.length; i++) {
        (function(trpimg) {
            if (trpimg.getAttribute('data-exec') == 'false') {
                var js = trpimg.getAttribute('onload');
                jsexec.call(trpimg, js);
            }
        })(trpimgs[i]);
    }
});