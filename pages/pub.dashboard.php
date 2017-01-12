<?php

$V = new View_Public();
$DS = new Data_Structure();

$V->__set('class_active', array( 
    null,
    'active',
    null,
    null,
    ));

$V->__set('legend_labels', array(
    Data_Structure::GREEN => Data_Structure::GREEN_LABEL, 
    Data_Structure::YELLOW => Data_Structure::YELLOW_LABEL, 
    Data_Structure::RED => Data_Structure::RED_LABEL, 
    Data_Structure::NA => Data_Structure::NA_LABEL, 
));

$V->__set('actions', $DS->matrix_action(true));
$V->__set('priorities', $DS->matrix_priority());
$V->__set('anumbers', $DS->anumbers());
$V->__set('dtable_1', $DS->dashboard());
$V->__set('co', $DS->matrix_country());
$V->__set('body',$V->render('dashboard'));

$V->add_js("dashboard.js");

$data = (isset($_SESSION['tablevis'])) ? json_encode($_SESSION['tablevis']) : json_encode($DS->dashboard_default_visibility);
$V->add_js("var tablevis=".$data.";", 'inline');


print $V->render('html');
