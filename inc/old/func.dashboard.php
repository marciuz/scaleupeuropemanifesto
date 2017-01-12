<?php
/**
* Dashboard functions
* 
* @package daeimplementation.eu
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2012 Tech4i2
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/

/**
 * Apply colors to dashboard
 * 
 * @param type $m
 * @param type $action_n
 * @return string
 */
function color_dashboard($m, $action_n){
    
    
    $aa=array();
    $yes= $no = $na = 0;
    $tot_indicators=0;
    $time_deadline=0;
    
    // filter on action
    for($i=0;$i<count($m);$i++){
	
	if($m[$i]['action_n']==$action_n){
	    
	    $deadline=$m[$i]['deadline'];
	    
	    if($deadline > 0 ){
		
		$time_deadline=  strtotime($deadline."-12-31");
	    }
	    
	    $tot_indicators=count($m[$i]['action_n']);
	    
	    $aa[]=$m[$i];
	    
	    switch($m[$i]['presence']){
		case 2: $no++;
		break;
	    
		case 1: $yes++;
		break;
	    
		case 0: 
		default: $na++;
	    }

	}
	
    }
    
    
    if($time_deadline == 0 ){
	
	$color="grey";
    }
    else if($tot_indicators == 0 ){
	
	$color="grey";
    }
    else{
	
	// non scaduto
	if($time_deadline<time()){
    
	    if($yes == $tot_indicators){

		$color='blue';
	    }
	    
	    else if( $tot_indicators / 2 > $yes ){
	    
		$color='green';
	    }
	    
	    else if($tot_indicators / 2 < $yes ){
	    
		$color='orange';
	    }
	    else{
		
		$color='grey';
	    }
	}
	// scaduto
	else{
	    
	    if($yes == $tot_indicators){

		$color='blue';
	    }
	    else if($yes < $tot_indicators){
		
		$color='red';
	    }
	    else{
		
		$color='grey';
	    }
	    
	    
	}
    
    }
	
    return $color;
    
    
}


function dashboard($descriptions){

    global $vmsql;

    $m1=array();
    
    $PP = new Pillar();

    $pillars=$PP->listArea();

    foreach($pillars as $p){

	$actions=$PP->listActions($p['id_pillar']);

	foreach($actions as $a){

	    $m1[$a['action_n']]=$PP->getIndicators($a['action_n'], true);
	}
    }

    // print_r($m1);

    // take the MS performance



    if(!is_array($PP->countries)){
	$PP->setCountries();
    }

    $c=0;
    $TR_first='';
    
    foreach($PP->countries as $country){
	
	// get the last form
	$sql0="SELECT DISTINCT id_ms_gen 
	    FROM ms_form_gen
	    WHERE id_country=".intval($country['id_country'])."
	    -- AND validate=1
	    ORDER BY date_ins DESC
	    ";

	$q0=$vmsql->query($sql0);

	if($vmsql->num_rows($q0)>0){

	    list($id_ms_form)=$vmsql->fetch_row_all($q0, true);

	   $sql="SELECT mg.id_ms_gen, mg.action_n, mg.id_country, mg.date_ins,
			m.id_indicator, m.presence, m.evidence, a.deadline
		FROM ms_form_gen mg
		INNER JOIN ms_form m ON mg.id_ms_gen=m.id_ms_gen
		INNER JOIN action a ON mg.action_n=a.action_n
		INNER JOIN indicator i ON i.id_indicator = m.id_indicator
		WHERE mg.id_ms_gen IN (".implode(",", $id_ms_form).") 
		AND i.in_dashboard=1 
        AND i.visible=1 
		ORDER BY action_n, num ";
	   
	   $q=$vmsql->query($sql);
	   
	   $mat=$vmsql->fetch_assoc_all($q);
	   
	  

	}
	else{
	    $mat=array();
	}
	
	
	
	
	
	$TR[$c]="<tr>\n<th>".$country['country']."</th>\n";
	
	$pillars=$PP->listArea();
	
	foreach($pillars as $p){
	    
	    $actions=$PP->listActions($p['id_pillar']);
	    
	    $color='';

		foreach($actions as $a){

		    if($c==0){
			$TR_first.="<th>Action ".$a['action_n']."</th>\n";
		    }

		    $color=color_dashboard($mat, $a['action_n']);

		    $TR[$c].="\t<td title=\"".$country['country'].", Action {$a['action_n']} ".htmlspecialchars($a['title']).": ".$descriptions[$color]."\" "
			    ."class=\"color-td color-$color a-{$a['action_n']}\"></td>\n";

		}

		
	    }
	    
	    $TR[$c].="</tr>\n";
	    
	    $c++;
	}

    $TR_first="<tr><th>&nbsp;</th>".$TR_first."</tr>\n";
    
    return  $TR_first.implode("",$TR);

}


