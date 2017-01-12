/* 
 * General Javascript
 */

$(document).ready( function (){
    
   $('.expire').each( function(i, el){
       var ms = isNaN($(el).data('ms')) ? 3000 : $(el).data('ms');
       setTimeout(function(){ $(el).fadeOut('slow'); }, ms);
   }); 
   
   $('#more-trigger').on('click', function (){
       $('#more').slideToggle();
   });
   
   $('*[data-poload]').on('click', function() {
        var e=$(this);
        $.get(e.data('poload'),function(d) {
            e.popover({title: 'Action '+ d.action_n + ' - ' +d.action, content: d.desc}).popover('show');
        });
    });
    
    $('[data-toggle="tooltip"]').tooltip();
});

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};