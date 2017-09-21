jQuery(document).ready(function () {
    jQuery('#login_button').click(function () {
        var username = jQuery('#uname').val();
        var password = jQuery('#psw').val();
        jQuery.ajax({
            type: 'POST',
            url: '../wp-json/siwecos/v1/login',
            data: {uname: username, psw: password},
            success: function (responseData) {
                console.log(responseData);
                if (responseData.code == '200') {
                    location.reload();
                } else {
                    alert(responseData.message);
                }
            },
            error: function () {
            }
        });
    });

    jQuery('#logout_button').click(function () {
        jQuery.ajax({
            type: 'POST',
            url: '../wp-json/siwecos/v1/logout',
            success: function (responseData) {
                console.log(responseData);
                if (responseData.code == '200') {
                    location.reload();
                } else {
                    alert(responseData.message);
                }
            },
            error: function () {
            }
        });
    });

    jQuery('.domain--item').click(function(){
        var actItem = jQuery(this).next('.domain--results');
        actItem.toggle('slow');
        jQuery('.domain--results').not(actItem).hide();
    });

    jQuery('.scanner--item').click(function(){
        var actItem = jQuery(this).next('.scanner--result-item');
        actItem.toggle('slow');
        jQuery('.scanner--result-item').not(actItem).hide();
    })
});
