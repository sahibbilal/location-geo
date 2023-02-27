(()=>{var i;i={init:function(){i.colorPicker()},colorPicker:function(){jQuery(".color-picker").wpColorPicker()}},function(r){"use strict";i.init()}(jQuery)})();
jQuery(document).ready( function () {
    //show add plugin zip modal and also get data for update
    jQuery(document).on('click', '.max_verify_license', function (e) {
        var ajaxurl = jQuery(this).data('ajaxurl');
        var appurl = jQuery(this).data('appurl');
        var key     = jQuery('#max_sb_location_geo_license_key').val();
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        jQuery.ajax({
            url: ajaxurl,
            data: { action: "max_plugin_license_verify", appurl: appurl, key: key},
            type: "post",
            dataType: "json",
            success: function (res) {
                jQuery('.max_license_response').empty().text(res['msg']);
                if((res['code'] != 200)){
                    jQuery('.max_license_response').css('color', 'red');
                    jQuery(this).closest('form').submit();
                }
                else{
                    jQuery('.max_license_response').css('color', 'inherit');
                    jQuery(this).closest('form').submit();
                    // console.log('checking');
                }
            }
        });
    });
});