jQuery(document).ready(function ($) {
    var info_timer;
    /**
     * Tab Show and hide
     */
    $('.av-wrap .nav-tab').click(function () {
        var settings_ref = $(this).data('settings-ref');
        $('.av-wrap .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.av-settings-section').hide();
        $('.av-settings-section[data-settings-ref="' + settings_ref + '"]').show();
        if (settings_ref == 'info') {
            $('.av-settings-action').hide();
        } else {
            $('.av-settings-action').show();
        }

    });


    /**
     * Save Settings
     */
    $('.av-settings-form').submit(function (e) {
        e.preventDefault();

        var settings_data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: av_admin_js_object.admin_ajax_url,
            data: {
                action: 'av_settings_save_action',
                settings_data: settings_data,
                _wpnonce: av_admin_js_object.admin_ajax_nonce
            },
            beforeSend: function (xhr) {
                clearTimeout(info_timer);
                $('.av-info-wrap').slideDown(500);
                $('.av-info').html(av_admin_js_object.messages.wait)
                $('.av-loader').show();
            },
            success: function (res) {
                $('.av-loader').hide();
                $('.av-info').html(res);
                info_timer = setTimeout(function () {
                    $('.av-info-wrap').slideUp(500);
                }, 5000);

            }
        });
    });

    /**
     * Close
     * 
     */
    $('.av-close-info').click(function () {
        $(this).parent().slideUp(500);
    });

    /**
     * Default settings restore
     */
    $('.av-settings-restore-trigger').click(function () {
        if (confirm(av_admin_js_object.messages.restore_confirm)) {
            $.ajax({
                type: 'post',
                url: av_admin_js_object.admin_ajax_url,
                data: {
                    action: 'av_settings_restore_action',
                    _wpnonce: av_admin_js_object.admin_ajax_nonce
                },
                beforeSend: function (xhr) {
                    clearTimeout(info_timer);
                    $('.av-info-wrap').slideDown(500);
                    $('.av-info').html(av_admin_js_object.messages.wait)
                    $('.av-loader').show();
                },
                success: function (res) {
                    $('.av-loader').hide();
                    $('.av-info').html(res);
                    location.reload();


                }
            });
        }
    });

    /**
     * Class show hide on select dropdown toggle
     */
    $('body').on('change', '.av-toggle-trigger', function () {
        var toggle_class = $(this).data('toggle-class');
        var toggle_value = $(this).val();
        $('.' + toggle_class).hide();
        $('.' + toggle_class + '[data-toggle-value="' + toggle_value + '"]').show();
    });
});