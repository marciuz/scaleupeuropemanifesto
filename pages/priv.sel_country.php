<?php

if(isset($_GET['id_country'])){
    $_SESSION['id_country'] = intval($_GET['id_country']);
    Redirect::toHome();
}


$V = new View_Private();
$DS = new Data_Structure();
$cnts = $DS->load_countries();

$V->__set('cnts', $cnts);
$V->__set('body', $V->render('sel_country'));

$html = $V->render('html_private');

print $html;
