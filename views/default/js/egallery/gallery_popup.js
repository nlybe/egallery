define(function(require) {
//    var elgg = require('elgg');
//    var $ = require('jquery');
//    require('jquery-ui');
//    
    var lightbox = require('elgg/lightbox');
    
    var options = {
       innerWidth: '500px',
       innerHeight: '500px',
       width: '500px',
       height: '500px'
    };
    
    lightbox.bind('a.elgg-lightbox-iframe', options, false); 

//    lightbox.resize({
//       width: '500px',
//       height: '500px'
//    });
});
