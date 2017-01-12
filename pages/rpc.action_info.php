<?php

$DS = new Data_Structure();

$action_n = (isset($_GET['action_n'])) ? intval($_GET['action_n']) : 0;

$action = $DS->load_data_action($action_n);

$data = array(
    'action_n'=> ($action['action_n'] / 10),
    'action'=>$action['action'],
    'desc'=> $action['long_desc'],
    );

header("Content-type: application/json; charset=utf-8");
print json_encode($data);