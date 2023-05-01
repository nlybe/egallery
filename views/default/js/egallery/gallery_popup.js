define(function(require) {    
    var lightbox = require('elgg/lightbox');
    
    var options = {
       innerWidth: '500px',
       innerHeight: '500px',
       width: '500px',
       height: '500px'
    };
    
    lightbox.bind('a.elgg-lightbox-iframe', options, false); 

});
