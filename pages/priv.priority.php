<?php

$V = new View_Private();
$DS = new Data_Structure_RW();

if(isset($_POST['summary'])){
    $result = $DS->save_summary($_POST['summary'], $_SESSION['id_country']);
    header("Location: ".$_SERVER['REQUEST_URI']."?feed=".$result);
    exit;
}

$stats = $DS->get_stats_fill($_SESSION['id_country']);

$country = $DS->load_country_by_id_country($_SESSION['id_country']);

$V->__set('country', $country);
$V->__set('stats',$stats);
$V->__set('body', $V->render('priorities'));

$html = $V->render('html_private');

print $html;
