<?php

if(isset($_GET['id']) && strlen($_GET['id'])==2){
    
    if(!isset($_SESSION['tablevis'])){
        $DS = new Data_Structure();
        $_SESSION['tablevis'] = $DS->dashboard_default_visibility;
    }
    
    $_SESSION['tablevis'][$_GET['id']]=intval($_GET['v']);
}
