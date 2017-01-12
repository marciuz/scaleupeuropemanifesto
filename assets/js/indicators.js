/* 
 * Check the indicators submit
 */

$(document).ready( function(){
    
    $('form').areYouSure();
    
    $('form').on('submit', function(e){
        
        var ta_empty = [];
        
        $('.presence_yes:checked').each( function(i, el){
            $ta = get_textarea(el);
            if($.trim($ta.val()) === ''){
                ta_empty.push($ta);
                $ta.addClass('red-fill');
            }
            else{
                $ta.removeClass('red-fill');
            }
        });
        
        if(ta_empty.length > 0){
            
            alert('You must fill the evidence field when select YES');
            return false;
        }
        else{
            return true;
        }
    });
});


function get_textarea(obj){
    var id = $(obj).data('id');
    $ta = $('#evidence_'+id);
    return $ta;
}