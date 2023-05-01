define(function(require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    
    var lightbox = require('elgg/lightbox');

    var options = {
        photo: true,
    };

    lightbox.bind('a[rel="showcase-gallery"]', options, false); 
});
