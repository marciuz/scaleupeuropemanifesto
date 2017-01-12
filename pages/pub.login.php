<?php

if(isset($_POST['email'])){
    
    $Auth = new Auth();
    
    $res_auth = $Auth->login($_POST['email'], $_POST['passwd']);
    
    if($res_auth === true){
        
        if($Auth->is_admin()){
            
            Redirect::toCountries();
        }
        else{
            Redirect::toHome();
        }
    }
    else{
        Redirect::toLogin(array('feed'=>$res_auth));
    }
}

$V = new View();

print $V->render('login');