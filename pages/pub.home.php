<?php

$V = new View_Public();
$DS = new Data_Structure();

$json_summary = $DS->summary_dashboard_all();

$V->__set('class_active', array( 
    'active',
    null,
    null,
    null,
    ));

$V->__set('legend_labels', array(
    Data_Structure::GREEN => Data_Structure::GREEN_LABEL, 
    Data_Structure::YELLOW => Data_Structure::YELLOW_LABEL, 
    Data_Structure::RED => Data_Structure::RED_LABEL, 
    Data_Structure::NA => Data_Structure::NA_LABEL, 
));


$last_data = $DS->get_last_data(10);

$html_last_data_col1 = $html_last_data_col2 = '';

if(count($last_data) > 0){
    
    $i1 = ceil(count($last_data) / 2);

    // 1st column
    for($i=0; $i< $i1; $i++ ){
        $V->__set('RS', $last_data[$i]);
        $html_last_data_col1 .= $V->render('last_data');
    }
    
    // 2nd column
    for($i=$i1; $i< count($last_data); $i++ ){
        $V->__set('RS', $last_data[$i]);
        $html_last_data_col2 .= $V->render('last_data');
    }
}

$V->__set('last_data_html_1', $html_last_data_col1);
$V->__set('last_data_html_2', $html_last_data_col2);
$V->__set('LAST_UPDATES', $V->render('last_updates'));

$V->__set('body',$V->render('home'));

$V->add_css('map.css');
$V->add_js("d3.min.js");
$V->add_js("topojson.min.js");
$V->add_js("homemap.js");

$V->add_js("var _cdata=$json_summary;", 'inline');

print $V->render('html');

