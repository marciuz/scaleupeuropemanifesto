<?php

$V = new View_Public();

$DS = new Data_Structure();

$countries = $DS->load_countries();

// do not show the non-countries
foreach($countries as $k=>$v){
    if($v['ctype'] != 'country'){
        unset($countries[$k]);
    }
}

//$Exp = new Experts();

$V->__set('class_active', array( 
    null,
    null,
    null,
    'active',
    ));


$V->__set('countries_area', $countries);
$V->__set('body', $V->render('countries_area'));
print $V->render('html');