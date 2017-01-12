<?php

require_once './inc/bootstrap.php';

// Anonymous
if(user_id() == 0){
    
    $pag = 'pub.login.php';
    require_once FRONT_ROOT."/pages/$pag";
}

else if(id_country() == 0){
    
    $Auth = new Auth();
    $Auth->logout();
    Redirect::toLogin();
}

// Is set the "page" parameter
else if(isset($_GET['page'])){
    
    switch($_GET['page']){
        
        case 'login': $pag = 'pub.login.php';
        break;
        
        case 'logout': $pag = 'priv.logout.php';
        break;
    
        case 'select_country': $pag = 'priv.sel_country.php';
        break;
    
        case 'help': $pag = 'priv.help.php';
        break;
    
        case 'indicators': $pag = 'priv.indicators.php';
        break;
    
        case 'priorities': 
        case 'priority':
        default:     $pag = 'priv.priority.php';
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
    die('111');
    // Error 404 o altro...
}