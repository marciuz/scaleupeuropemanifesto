<?php

// Require conf.php
$conf_file = str_replace("/inc","/conf",realpath(__DIR__)) . "/conf.php";

if(file_exists($conf_file)){
    require_once($conf_file);
}
else{
    die('ERR 001');
}

require_once(FRONT_ROOT."/inc/vmsql.mysqli.php");

/* AUTOLOADER */
spl_autoload_register(function ($class) {
    $file_class=FRONT_ROOT.'/classes/class.' . strtolower($class) . '.php';
    if(file_exists($file_class)){
        include_once $file_class;
    }
});

/* AUTOLOADER COMPOSER */
require_once(FRONT_ROOT."/vendor/autoload.php");

$vmsql = mysqli_vmsql::init();
$vmsql->connect($db1,'UTF8');

/**

 * Session Start
 */
session_name(SESSION_NAME);
session_start();

// DEBUG:
//$_SESSION['user']=array('id_user'=>1, 'country'=>'Austria', 'id_country'=>1, "first_name"=>'xxxxxxxxx', 'last_name'=>'yyyyyy');

function user_id(){
    if(isset($_SESSION['user']['id_user'])){
        return $_SESSION['user']['id_user'];
    }
    else{
        return 0;
    }
}

function id_country(){
    if(isset($_SESSION['id_country'])){
        return $_SESSION['id_country'];
    }
    else{
        return 0;
    }
}

function country_name(){
    return Common::country2id_country($_SESSION['id_country']);
}
