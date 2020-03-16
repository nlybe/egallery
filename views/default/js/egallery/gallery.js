define(function(require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    // require('jquery-ui');
    
    var lightbox = require('elgg/lightbox');

    var options = {
        photo: true,
    };

    lightbox.bind('a[rel="showcase-gallery"]', options, false); 
    
    // $( function() {
    //     $( "#p_gallery_accordion" ).accordion({
    //         heightStyle: "content"
    //     });
    // });
});
