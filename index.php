<?php

require_once './inc/bootstrap.php';

$page_home = 'pub.home.php';


// Is set the "page" parameter
if(isset($_GET['page'])){
    
    switch($_GET['page']){
        
        case 'countries': $pag = 'pub.countries.php';
        break;
        
        case 'country_detail': $pag = 'pub.country_detail.php';
        break;
        
        case 'dashboard': $pag = 'pub.dashboard.php';
        break;
        
        case 'experts': $pag = 'pub.experts.php';
        break;
    
        case 'export': $pag = 'pub.export_data.php';
        break;
        
        case 'dashboard_detail': $pag = 'pub.dashboard_detail.php';
        break;
    
        case 'info': $pag = 'rpc.action_info.php';
        break;
    
        case 'tablevis': $pag = 'rpc.tablevis.php';
        break;
    
        case 'home': 
        default: 
            $pag = $page_home;
        break;
    }
    
    if(file_exists(FRONT_ROOT."/pages/$pag")){
        require_once FRONT_ROOT."/pages/$pag";
    }
    else{
        
        // Error 404? 
        die('112');
        
    }
}

// No page parameter
else{
    require_once FRONT_ROOT."/pages/$page_home";
}