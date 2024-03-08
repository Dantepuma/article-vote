function av_setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function av_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

jQuery(document).ready(function ($) {
    var ajax_flag = 0;
    $('body').on('click', '.av-like-dislike-trigger', function () {
        if (ajax_flag == 0) {
            var restriction = $(this).data('restriction');
            var post_id = $(this).data('post-id');
            var trigger_type = $(this).data('trigger-type');
            var selector = $(this);
            var already_liked = selector.data('already-liked');

            if (already_liked == 0) {
                $.ajax({
                    type: 'post',
                    url: av_js_object.admin_ajax_url,
                    data: {
                        post_id: post_id,
                        action: 'av_post_ajax_action',
                        type: trigger_type,
                        _wpnonce: av_js_object.admin_ajax_nonce
                    },
                    beforeSend: function (xhr) {
                        ajax_flag = 1;

                    },
                    success: function (res) {
                        res = $.parseJSON(res);
                        if (res.success) {
                            var like_count = res.like_count;
                            var dislike_count = res.dislike_count;
                            var total_count = res.total_count;

                            var percentageLike = (like_count / total_count) * 100;
                            var roundedPercentage = percentageLike.toFixed(0)+'%'; 

                            var percentageDislike = (dislike_count / total_count) * 100;
                            var roundedPercentageDislike = percentageDislike.toFixed(0)+'%'; 

                            $('#like_percentage').html(roundedPercentage)
                            $('#dislike_percentage').html(roundedPercentageDislike)
                            if (restriction != 'no') {
                                selector.closest('.av-like-dislike-wrap').find('a').data('already-liked', 1);
                                selector.parent().addClass('av-voted-trigger');
                                selector.closest('.av-like-dislike-wrap').find('.av-like-dislike-trigger').addClass('av-prevent');
                            }
                        }
                    }

                });
            }
        }
    });

});