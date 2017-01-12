/* 
 * Country Detail page
 */
$(document).ready( function() {
    
    $('.ddetail').hide();
    $('.open_id').show();
    
    var tks = window.location.pathname.split('/')
    var ptokens = tks[tks.length -1].split('-');
    if(ptokens.length===2){
        $("html, body").delay(400).animate({scrollTop: $('#act-' + ptokens[1]).offset().top - 75 }, 1000);
    }
    
    $('.fakelink-over').hover(function(){
        $(this).addClass('fakelink');
    }, function(){
        $(this).removeClass('fakelink');
    });
    
    $('.fakelink-over').on('click', function (){
        var $el = $(this);
        var $table = $el.next().next('.ddetail');
        
        $table.removeClass('open_id');
        if( $table.is(':visible')){
            collapse($el);
        }
        else{
            expand($el);
        }
    });
    
    $('.expand-all').on('click', expand_all);
    $('.collapse-all').on('click', collapse_all);
    
});

function expand($el){
    $el.next().next('.ddetail').show();
    $el.children('i').removeClass('fa-plus-square').addClass('fa-minus-square');
}

function collapse($el){
    $el.next().next('.ddetail').hide();
    $el.children('i').removeClass('fa-minus-square').addClass('fa-plus-square');
}

function expand_all(){
    $('.fakelink-over').each( function (i, el) { expand($(el)); });
}

function collapse_all(){
    $('.fakelink-over').each( function (i, el) { collapse($(el)); });
}