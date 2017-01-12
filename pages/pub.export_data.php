<?php

$DE = new Data_Export();

if(isset($_GET['ft'])){
    
    if($_GET['ft'] == 'xml'){
        $DE->export_xml();
    }
    else if($_GET['ft'] == 'json'){
        $DE->export_json();
    }
    // else csv
    else{
        $DE->export_csv();
    }
}
else{
    $DE->export_csv();
}



