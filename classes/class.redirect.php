<?php

class Redirect {
    
    public static function toLogin($pars='') {
        
        if(is_array($pars)){
            $str="?";
            foreach($pars as $k=>$v){
                $str.=$k."=".urlencode($v);
            }
        }
        else{
            $str='';
        }
        
        header("Location: ".FRONT_DOCROOT."/members/login" . $str );
        exit;
    }
    
    public static function toCountries() {
        header("Location: ".FRONT_DOCROOT."/members/select_country");
        exit;
    }
    
    public static function toHome() {
        header("Location: ".FRONT_DOCROOT."/members/");
        exit;
    }
}