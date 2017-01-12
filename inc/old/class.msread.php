<?php
/**
* Member state Form
* 
* @package daeimplementation.eu
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2012-2013 Tech4i2
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/


/**
 * Forms read class
 *
 */
class MSRead {
    
    private $indicators=array();
    private $indicators_ec=array();
    private $indicators_ms=array();
    
    private $all_ind=null;


    public function __construct() {
	
    }
    
    /**
     * Get all countries
     * @global object $vmsql
     * @return array
     */
    public function getCountries($order_by='country'){
	
	global $vmsql;
	
	$sql="SELECT * FROM country ORDER BY $order_by";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
	
    }
    
    /**
     * Get a coutntry
     * @global object $vmsql
     * @param int $id_country
     * @return array
     */
    public function getCountry($id_country){
	
	global $vmsql;
	
	$sql="SELECT * FROM country WHERE id_country=".intval($id_country);
	
	$q=$vmsql->query($sql);
	
	$RS=$vmsql->fetch_assoc($q);
	
	return $RS;
	
    }
    
    /**
     * 
     * @global object $vmsql
     * @param int $action_n
     * @return array
     */
    public function getSummaryByCountry($id_country){
	
	global $vmsql;
	
	$sql="SELECT ministry, link_action_plan, progress_summary, lastdata
	    FROM ms_gen_info 
	    WHERE id_country=".intval($id_country);
	    // ."AND validate=1";
	
	$q=$vmsql->query($sql);
	
	$mat=array();
	
	$RS=$vmsql->fetch_assoc($q);
	    
	return $RS;
    }
    
    
    public function getSummaryByPillar($id_area){
	
	global $vmsql;
        
        $mat=array();
	/*
	$sql="SELECT id_ms_gen, ms.action_n, ms.summary , date_ins
	    FROM ms_gen_info ms
	    -- INNER JOIN action a ON a.action_n=ms.action_n
	    WHERE a.id_area=".intval($id_area)." 
	    AND id_ms_gen IN 
	    (SELECT MAX(id_ms_gen) FROM ms_form_gen WHERE id_pillar=".intval($id_pillar)."  
		GROUP BY action_n, id_country) ";
	    // ."AND validate=1";
	
	$q=$vmsql->query($sql);
	
	
	
	while($RS=$vmsql->fetch_assoc($q)){
	    
	    $mat[$RS['action_n']]=$RS;
	}
	*/
	return $mat;
    }
    
    
    private function setIndicators(){
	
	global $vmsql;
	
	// Indicators
            $sql="SELECT id_indicator, num, action_n, indicator, evidence_eg, in_dashboard, deadline, responsible, studies, audience
	    FROM indicator 
        WHERE visible=1
	    ORDER BY action_n, num
	    ";
	
	$q=$vmsql->query($sql);
	
	while($RS=$vmsql->fetch_assoc($q)){
	    $this->indicators[$RS['action_n']][] = $RS;
	}
	
    }
    
    protected function getAllIndicatorResults(){
        
        global $vmsql;
        
       $sql="SELECT DISTINCT ai.id_indicator, ai.action_n, ai.deadline, mf.presence, mf.id_country, mf.evidence, d.tot AS n_indicators
            FROM action_indicators ai
            INNER JOIN ms_form mf ON mf.id_indicator = ai.id_indicator
            LEFT JOIN dashboard01 d ON d.action_n = ai.action_n
            WHERE mf.confirmed=1 
            -- AND ai.in_dashboard =1
            ";
       
       $q=$vmsql->query($sql);
       
       $this->all_ind=$vmsql->fetch_assoc_all($q);
    }
    
    /** 
     * Get the indicators in context of single interrogation
     * If it need a massive use of this function (eg in dashboard)
     * use the cached version (@see getIndicators)
     * 
     * @global object $vmsql
     * @param int $action_n
     * @param int $id_country
     * @return \stdClass
     * @see getIndicators
     */
    public function getIndicatorsSingleAction($action_n, $id_country, $audience=''){
	
	global $vmsql;
        
        if($audience!=''){
            
            $sql_add=" AND audience IN ('', '$audience') ";
        }
        else{
            $sql_add='';
        }
        
        // Indicators
        $sql="SELECT id_indicator, num, action_n, indicator, evidence_eg, in_dashboard, deadline, responsible, studies, audience
        FROM indicator 
        WHERE 1=1
        $sql_add
        ORDER BY action_n, num
        ";
	
	$q=$vmsql->query($sql);
	
	while($RS=$vmsql->fetch_assoc($q)){
	    $this->indicators[$RS['action_n']][] = $RS;
	}
	
        
	$id_country=intval($id_country);
	$action_n=intval($action_n);
	
	$Results= new stdClass();
	
	$Results->indicators = $this->indicators[$action_n];
        
	
	
	$sql2="SELECT ai.id_indicator, ai.action_n, ai.deadline, 
                mf.presence, mf.evidence, d.tot as n_indicators, audience
	    FROM action_indicators ai 
	    INNER JOIN ms_form mf ON mf.id_indicator=ai.id_indicator AND mf.id_country=$id_country 
	    INNER JOIN dashboard01 d ON d.id_country=$id_country AND d.action_n=ai.action_n
	    WHERE ai.in_dashboard=1
            AND ai.action_n=$action_n
            AND mf.confirmed=1 
            $sql_add
	    ";
        
        //echo "<!-- $sql2 -->\n";
	
        
        
	$q2=$vmsql->query($sql2);
	
	$Results->details=array();
	
	if($vmsql->num_rows($q2)>0){
	    
	    while($RS=$vmsql->fetch_assoc($q2)){

		$Results->details[]=$RS;
	    }
	}
	
	$Results->status=$this->color_dashboard($Results->details,$action_n);
	
	return $Results;
	
    }
    
    
    public function getIndicatorsSingleAction_MS($action_n, $id_country){
        
        return $this->getIndicatorsSingleAction($action_n, $id_country, 'ms');
    }
    
    
    public function getIndicatorsSingleAction_EC($action_n, $id_country){
        
        return $this->getIndicatorsSingleAction($action_n, $id_country, 'ec');
    }
    
    
    /**
     * Get indicators with a massive use (cached)
     * 
     * @param int $action_n
     * @param int $id_country
     * @return \stdClass
     */
    public function getIndicators($action_n, $id_country){
	
	
	if(count($this->indicators)==0){
	    
	    $this->setIndicators();
	}
	
	$id_country=intval($id_country);
	$action_n=intval($action_n);
	
	$Results= new stdClass();
	$Results->indicators = $this->indicators[$action_n];
        $Results->details=array();
        
        if($this->all_ind===null){
            $this->getAllIndicatorResults();
        }
        
        $n=count($this->all_ind);
        
        for($i=0;$i<$n;$i++){
            
            if($this->all_ind[$i]['id_country']==$id_country
               && $this->all_ind[$i]['action_n']==$action_n){
                
                $Results->details[]=$this->all_ind[$i];
            }
        }
	
	$Results->status=$this->color_dashboard($Results->details,$action_n);
	
	return $Results;
	
    }
    
    public function color_action_dashboard($val, $deadline, $id_country='', $audience=''){
	
	$time_deadline= strtotime($deadline."-12-31");
	
        
        // Special case: different colors for not applicable evaluation
        if($id_country==COUNTRY_EC && $audience=='ms'){
            
            $value=' ';
            $class="color-act-noeval";
        }
        else if($id_country!=COUNTRY_EC && $audience=='ec'){
            
            $value=' ';
            $class="color-act-noeval";
        }
        // from here start the normal evaluation
        // non scaduto
        else  if($time_deadline > time()){
	    
	    switch ($val){

		case '1': 
		    $class='color-act-blue';
		    $value="Y";
		break;
	    
	    
		case '2': 
		    $class='color-act-orange';
		    $value="N";
		break;
	    
		default : 
		    $class='color-act-grey';
		    $value=" ";
		break;
	    }


	}
	else{
	    
	    switch ($val){

		case '1': 
		    $class='color-act-blue';
		    $value="Y";
		break;
	    
	    
		case '2': 
		    $class='color-act-red';
		    $value="N";
		break;
	    
		default : 
		    $class='color-act-grey';
		    $value=" ";
		break;
	    }
	    
	}
	
	return array('value'=>$value, 'class'=>$class);
	
	
    }
    

    protected function color_dashboard($m, $action_n, $debug=false){

	$aa=array();
	$yes= $no = $na = 0;
	$tot_indicators=(isset($m[0]['n_indicators'])) ? $m[0]['n_indicators'] : 0;
	$time_deadline=0;

	
	
	// filter on action
	for($i=0;$i<count($m);$i++){

	    //if($m[$i]['action_n']==$action_n){

		$deadline=$m[$i]['deadline'];

		if($deadline > 0 ){

		    $time_deadline=  strtotime($deadline."-12-31");
		}

		

		switch($m[$i]['presence']){
		    
		    case 2: $no++;
		    break;

		    case 1: $yes++;
		    break;

		    case 0: 
		    default: $na++;
		}

	   // }

	}

	
	// echo "<!-- y:$yes n:$no na:$na tot:$tot_indicators -->\n";

	if($time_deadline == 0 ){

	    $color="grey";
	}
	else if($tot_indicators == 0 ){

	    $color="grey";
	}
	else if($tot_indicators==$na){
	    
	    $color="grey";
	}
        else if($tot_indicators < ($yes+$no)){
	    
	    $color="grey";
            if($debug) echo "<!-- HERE -->\n";
	}
	else{

	    // non scaduto
	    if($time_deadline > time()){
		
		// echo "<!-- non scaduto -->\n";

		if($yes == $tot_indicators){

		    $color='blue';
		}

		else if( $yes >= ($tot_indicators / 2)  ){

		    $color='green';
		}

		else if( $yes < ($tot_indicators / 2) ){

		    $color='orange';
		}
		else{
		    if($debug) echo "<!-- ".__LINE__."-->\n";
		    $color='grey';
		}
	    }
	    // scaduto
	    else{
                
                // echo "<!-- $action_n y:$yes n:$no na:$na tot:$tot_indicators -->\n";
		
		// echo "<!-- scaduto -->\n";

		if($yes == $tot_indicators){

		    $color='blue';
		}
                else if($na > 0){
                     
		     if($debug) echo "<!-- ".__LINE__."-->\n";
                     $color='grey';
                }
		else if($yes < $tot_indicators){

		    $color='red';
		}
		else{
		    
		    if($debug) echo "<!-- ".__LINE__."-->\n";
		    $color='grey';
		}


	    }

	}
	

	return $color;
    }
    
    public function action_color($colors){
	
	$red=$orange=$green=$blue=0;
	
	
	if(in_array('red', $colors)){
	    
	    return 'red';
	}
	else if(in_array('orange', $colors)){
	    return 'orange';
	}
	else if(in_array('green', $colors)){
	    return 'green';
	}
	else if(in_array('blue', $colors)){
	    return 'blue';
	}
	
    }
    
    public function summary_status_action($o){
        
        // Europe?
        if($o->leading_role == 'Commission'){
            
            return $this->__summarize_with_date(array($o->iii[0]), $o->deadline);
        }
        else if($o->leading_role == 'Member States'){
            
            unset($o->iii[0]);
            return $this->__summarize_with_date($o->iii, $o->deadline);
        }
        // Joint
        else{
            
            return $this->__summarize_with_date($o->iii, $o->deadline);
        }
        
    }
    
    private function __summarize_with_date($arr, $deadline){
        
        $res=array('na'=>0, 'complete'=>0, 'retard'=>0, 'ontrack'=>0, 'risk'=>0);
        
        if(is_array($arr)){
            foreach($arr as $ii){
                $res[$ii]++;
            }
        }
        
        if(isset($_GET['debug'])){
            echo "<!-- arr : ".print_r($arr, true)." -->\n";
            echo "<!-- res count: ".print_r($res, true)." -->\n";
        }
        
        // removing the na from total
        $tot = (count($arr) - $res['na']);
        
        $year = date('Y');
        
        if($res['complete'] == $tot){
            
            return 'blue';
        }
        else if($year > $deadline && $res['complete'] < $tot){
            
            return 'red';
        }
        else if($deadline >= $year){
            
            if($res['complete'] >= ($tot/2)){
            //if(($res['ontrack'] + $res['complete']) >= ($tot/2)){
                
                return 'green';
            }
            else{
                return 'orange';
            }
        }
        else{
            return 'grey';
        }
    }
    
    
    
    public function old_action_color($colors){
	
	$red=$orange=$green=$blue=0;
	
	foreach($colors as $color){
	    
	    if($color=='grey'){
		return 'grey';
	    }
	    else{
		
		switch($color){
		    
		    case 'red': $red++;
		    break;
		    
		    
		    case 'orange': $orange++;
		    break;
		
		
		    case 'green': $green++;
		    break;
		
		    case 'blue': $blue++;
		    break;
		}
	    }
	}
	
	
	
    }


    
    public function findResult($obj, $id_indicator){
	
	if(!isset($obj->details)){
	    
	    return null;
	}
	else{
	
	    foreach($obj->details as $k=>$ii){

		if($ii['id_indicator']==$id_indicator){

		    return $obj->details[$k];
		}
	    }
	}
    }
    
    public function findResult2($id_indicator, $id_country){
        
        global $vmsql;
        
        $sql="SELECT presence, evidence 
              FROM ms_form 
              WHERE id_indicator=".intval($id_indicator)." AND id_country=".intval($id_country)." 
              AND confirmed=1 ";
        
        $q=$vmsql->query($sql);
        
        return $vmsql->fetch_assoc($q);
    }
    
    
    public function getLastUpdates($limit=5, $only_validate=true){
	
	global $vmsql;
        
        $sql_confirmed = ($only_validate) ? "AND f.confirmed=1 " : '';

	$sql="SELECT confirmed, c.id_country, c.country, lastdata, i.action_n, u.id_user, last_name, first_name  
	FROM ms_form f
	INNER JOIN country c ON f.id_country=c.id_country
	INNER JOIN user u ON u.id_user=f.id_user
	INNER JOIN indicator i ON i.id_indicator=f.id_indicator
	WHERE 1=1
        $sql_confirmed
	GROUP BY confirmed, id_country, country , lastdata, action_n, id_user
	ORDER BY lastdata DESC 
	LIMIT $limit";

        
	$q=$vmsql->query($sql);

	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
    }
    
    public function getLastUpdatesHTML($limit=5, $only_validate=true, $max_chars=150){
	
	$mat=$this->getLastUpdates($limit, $only_validate);
	
	if(count($mat)>0){
	    
	    $ccc=0;
	    
	    $OUT="<div id=\"last-updates\">
		<h3>Last updates</h3>
		<ul>\n";
	    
	    
	    foreach($mat as $RS){
		
		
		
		$OUT.="<li class=\"other-li\">";
		$OUT.="<span class=\"other-info\"><a href=\"indicator.php?id_country=".$RS['id_country']."&amp;action_n=".$RS['action_n']."\">";
		$OUT.="Action ".$RS['action_n']." in ".$RS['country']."</a>";
		$OUT.=", updated on ".date("j M Y",strtotime($RS['lastdata']));
		$OUT.=" by ".$RS['country']." representative";
		$OUT.="</span>\n";
		$OUT.="</li>\n";
		
		$ccc++;
	    }
	    
	    $OUT.="</ul>\n</div>\n";
	}
	else{
	    $OUT='';
	}
	
	return $OUT;
    }
    
    
     public function getExternalContributions($id_country, $action_n, $limit=100 ){
	
	global $vmsql;
	
	$sql="SELECT *
	    FROM user_contribution
	    WHERE status=1 
	    AND id_country=".intval($id_country)."
	    AND action_n=".intval($action_n)."
	    ORDER BY last_date 
	    LIMIT $limit";
	
	$q=$vmsql->query($sql);
	
	return $vmsql->fetch_assoc_all($q);
	
    }
    
    
    
    public function test_MS_action_class($arr){
	
	$test_blue=true;
	$test_orange=false;
	$test_red=false;
	
	$n_blue=0;
	$n_orange=0;
	
	// Test grey or all blue
	for($i=0;$i<count($arr);$i++){
	    
	    if($arr[$i]=='color-act-grey'){
		
		return 'color-act-grey';
	    }
	    
	    if($arr[$i]!='color-act-blue'){
		
		$test_blue=false;
	    }
	    else{
		$n_blue++;
	    }
	    
	    if($arr[$i]=='color-act-orange'){
		
		$test_orange=true;
		$n_orange++;
	    }
	    else if($arr[$i]=='color-act-red'){
		
		$test_red=true;
	    }
	    
	}
	
	if($test_blue) return 'color-act-blue';
	else if($test_red) return 'color-act-red';
	else if($test_orange){
	    
	    // Test if is green or orange
	    if(count($arr)==($n_blue+$n_orange)){
		
		if($n_blue>=$n_orange){
		    return 'color-act-green';
		}
		else{
		    return 'color-act-orange';
		}
	    }
	    else{
		return 'color-act-orange';
	    }
	}
	
	    
    }
    
}


class Egov_Tables {
    
    protected $mat;
    
    public function __construct() {
    
        global $vmsql;
        
        /*
        
        $sql="SELECT a.action_n, c.id_country, country, 
                YEAR( a.end_date ) AS deadline, 
                COUNT( i.id_indicator ) AS tot, 
                COUNT( f.presence ) AS n1, 
                COUNT( f2.presence ) AS n2
                
              FROM action AS a
                INNER JOIN country c
                INNER JOIN indicator i ON a.action_n = i.action_n
                LEFT JOIN ms_form f ON c.id_country = f.id_country AND f.id_indicator = i.id_indicator AND f.presence=1
                LEFT JOIN ms_form f2 ON c.id_country = f2.id_country AND f2.id_indicator = i.id_indicator AND f2.presence=2
                GROUP BY action_n, id_country
        ";
        
        */
        
        
        $sql="SELECT a.action_n, c.id_country, country, 
                YEAR( a.end_date ) AS deadline, 
                COUNT( i.id_indicator ) AS tot, 
                COUNT( f.presence ) AS n1, 
                COUNT( f2.presence ) AS n2
                
              FROM action AS a
                INNER JOIN country c
                INNER JOIN indicator i ON a.action_n = i.action_n
                LEFT JOIN ms_form f ON c.id_country = f.id_country AND f.id_indicator = i.id_indicator AND f.presence=1 AND f.confirmed=1
                LEFT JOIN ms_form f2 ON c.id_country = f2.id_country AND f2.id_indicator = i.id_indicator AND f2.presence=2 AND f2.confirmed=1
                
                WHERE c.id_country=".COUNTRY_EC." AND i.audience IN ('', 'ec')
                OR c.id_country!=".COUNTRY_EC." AND i.audience IN ('', 'ms') 

                GROUP BY action_n, id_country
        ";
        
        
        $q=$vmsql->query($sql);
        
        $this->mat=$vmsql->fetch_assoc_all($q);
    
    }
    
    
    public function getAction_Country($id_country, $action_n){
                
        $RS=array();
        $n=count($this->mat);
        for($i=0; $i<$n; $i++){
            
            if($this->mat[$i]['id_country']==$id_country && $this->mat[$i]['action_n']==$action_n){
                $RS=$this->mat[$i];
                break;
            }
        }
        
        if(count($RS)==0)
            return array('res'=>'');
        
            
        $RS['complete']= ($RS['n1']==$RS['tot']);
        $RS['late']= (strtotime($RS['deadline']."-12-31") < time());

        if($RS['n1']=='0' && $RS['n2']=='0'){

            $RS['res']='na';
        }
        else if($RS['complete']){

            $RS['res']="complete";
        }
        else if(!$RS['complete'] && !$RS['late']){

            if( $RS['n1'] >= ($RS['tot']/2)){
                $RS['res']='ontrack';
            }
            else{
                $RS['res']='risk';
            }
        }
        else if(!$RS['complete'] && $RS['late']){

            $RS['res']='retard';
        }
        
        return $RS;
    }
    
    
    public function getIndicators(){
        
        
    }
    
}



