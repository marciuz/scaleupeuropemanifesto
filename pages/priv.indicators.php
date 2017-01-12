<?php
/**
 *
 * Get all the indicator for a specific area 
 *  
 */

$DS = new Data_Structure_RW();
$V = new View_Private();

$id_priority = (isset($_GET['id_priority'])) ? $_GET['id_priority'] : 0;

// Aactions when sent
if(isset($_POST['id_country'])){
    
    $affected = $DS->save_form($_POST);
    
    header("Location: ".FRONT_DOCROOT."/members/indicators?id_priority=".$id_priority."&feedback=".$affected);
    exit;
    /*
    print "<pre>\n";
    print_r($_POST);
    print $affected;
    exit;
     */
}



$id_country = id_country();

$_data = $DS->load($id_priority);

$data = $_data->priorities[0];
$_comp = $DS->get_data($id_country, $id_priority);

$OUT='';

$OUT.="<h2>".$data->id_area." " .$data->area." <span class=\"gray\">in ".Common::country2id_country($_SESSION['id_country'])."</h2>";


$OUT.="<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n";


$OUT.="<div class=\"row\">\n";
$OUT.="<div class=\"col-sm-9\" >\n";

// GET DATA
foreach ($data->actions as $a){
    
    
    $OUT.= "<fieldset>";
    
    // Print the section
    if($data->id_area == 0){
        
    }
    else{
        $OUT.= "<legend>".($a->number) ." ". $a->action."</legend>";
    }
    
    foreach($a->indicators as $i){
        
        $defaults = ECC_Array::findWhere($_comp, array('id_indicator' => $i->id_indicator));
        
        if(is_array($defaults)){
            $presence = $defaults['presence'];
            $evidence = $defaults['evidence'];
        }
        else{
            $presence = $evidence = null;
        }
        
        $V->__set('ind_text', $i->ind_label." - ".$i->indicator);
        $V->__set('radio', $DS->radio($i->id_indicator, $presence));
        $V->__set('evidence', $DS->evidence_text($i->id_indicator, $evidence));
        $OUT.=$V->render('indicator');
        
    }
    
    $OUT.="</fieldset>\n";
}

$OUT.="<input type=\"hidden\" name=\"id_country\" value=\"".$id_country."\" />\n";

$OUT.="</div>\n";

$feedback_text = (isset($_GET['feedback'])) ? 
        ($_GET['feedback']>0) 
            ? "<div id=\"expire-msg\" class=\"expire alert alert-success\" data-ms=\"3000\">Data correctly saved</div>"
            : "<div id=\"expire-msg\" class=\"expire alert alert-warning\" data-ms=\"3000\">No data to save</div>"
        : '';

$OUT.="<div class=\"col-xs-12 col-sm-3\" >
        <div class=\"col-xs-12 col-sm-3 fixed centered\">
            <input type=\"submit\" value=\" Save data \" class=\"btn btn-primary btn-lg\" />
            
            $feedback_text
        </div>
    </div>\n";

$OUT.="</div>\n";

$OUT.="</form>\n";

$V->add_js('jquery.are-you-sure.js', 'footer');
$V->add_js('indicators.js', 'footer');
$V->__set('body', $OUT);
$html = $V->render('html_private');

print $html;
