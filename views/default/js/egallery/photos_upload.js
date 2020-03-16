define(function(require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    
    $( ".dropzone_upload_trigger" ).change(function() {
        elgg.action('egallery/get_latest_item', {
            data: {
                container_guid: $('#container_guid').val(),
                file_guid: $(this).val()
            },
            success: function (result) {
                if (result.error) {
                    elgg.register_error(result.msg);
                } else {  
                    if (result.content) {
                        $('#egallery_default_cat').prepend(result.content)
                    }                                
                }
            }
        });
    });   

});
