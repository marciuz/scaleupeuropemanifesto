/**
 * Dashboard Actions
 * 
 * @package EDfx2 - Scale Up Europe Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015-2016 Open Evidence
 */

$(document).ready( function(){
    
    var rows = $('table.dsh tr');
    
    // Highlight column
    rows.children('th.thc, td').hover( function() {
        
        rows.children().removeClass('highlight');  
        var index = $(this).prevAll().length;  
        if(index > 1){
            rows.find(':nth-child(' + (index + 1) + ')').addClass('highlight');
        }
    });
    
    // Action on click on cell
    rows.children('td.tdd').click(function() {
        var c = $(this).data('c');
        var id = $(this).data('a');
        //var url = window.location.pathname + "/" + c + "-" + id;
        var url = window.location.pathname.replace('dashboard', 'country') + "/" + c + "-" + id;
        window.location = url;
    });
    
    $('.r').hide();
    if(tablevis.length == 0){
        show_table('s0');
        show_table('s1');
    }
    else{
        for(i in tablevis){
            if(tablevis[i]==1){
                show_table(i);
            }
        }
    }
    
    $('.th-priority').on('click', function(){
        $el_id = $(this).parents('.t-sect').attr('id');
        $.get('tablevis?id='+$el_id+'&v='+$('#'+$el_id+' .r:first:hidden').length);
        show_table($el_id);
        
    });
    
    $('.thc').on('click', function (){
        var abbr = $(this).find('div').data('abbr');
        var url = window.location.pathname.replace('dashboard', 'country') + "/" + abbr;
        window.location = url;
    });
    
});

function show_table(id){
    $('#'+id+' .r').toggle('fast');
    
}