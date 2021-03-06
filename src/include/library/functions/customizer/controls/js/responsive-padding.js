jQuery(document).ready(function ($) {

    $('.responsive-padding-wrap .customize-control-responsive-padding-value').on('keyup change', function () {

        var parent = $(this).parents('.responsive-padding-wrap'),
            dbstore_cache = $('.responsive-padding-db', parent),
            dbstore = dbstore_cache.val(),
            device_type = $(this).data('area-device-type');

        dbstore = dbstore === '' ? {} : JSON.parse(dbstore);

        dbstore[device_type] = this.value;

        dbstore_cache.val(JSON.stringify(dbstore)).change();
    })

});
