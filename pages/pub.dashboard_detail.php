<?php

$DS = new Data_Structure();

$V = new View_Public();

$action_n = (int) $_GET['id'];
$abbr = preg_replace("/[^A-Z]+/", '', $_GET['c']);

try {
    
    $action = $DS->load_data_action($action_n);
    
    $country = $DS->load_country_by_abbr($abbr);
    
    if(count($action)==0){
        throw new General_Exception('Data from URL not available', Edfx_Enum::ERR_DATA_FROM_URL, array('action_n', $_GET['id']));
    }
    else if(count($country) == 0){
         throw new General_Exception('Data from URL not available', Edfx_Enum::ERR_DATA_FROM_URL, array('abbr', $_GET['c']));
    }
    else{

        
        $indicators = $DS->load_indicators($action_n);
        $_data  = $DS->get_country_action_data($country['id_country'], $action_n);
        
        foreach($indicators as $k=>$ind){
            
            $ff = ECC_Array::findWhere($_data, array('id_indicator'=> $ind->id_indicator));
            
            if($ff){
                $indicators[$k]->_data = array(
                    'presence'=>$ff['presence'],
                    'evidence' => Common::clickable($ff['evidence'], array('target'=>'_blank')),
                    'lastdata' => $ff['lastdata'],
                     );
            }
            else{
                $indicators[$k]->_data = array(
                    'presence'=> null,
                    'evidence' => null,
                    'lastdata' => null,
                     );
            }
        }

        $V->__set('class_active', array( 
            null,
            'active',
            null,
            null,
            ));

        $V->__set('anumbers', $DS->anumbers());
        $V->__set('action', $action);
        $V->__set('country', $country);
        $V->__set('indicators', $indicators);
        $V->__set('indicators_n', count($indicators));
        
        // LAST DATA
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
         
        $V->__set('body',$V->render('dashboard_detail'));
        
        print $V->render('html');

    }
}
 catch (General_Exception $e){
     $e->setLog(\Monolog\Logger::ERROR);
 }