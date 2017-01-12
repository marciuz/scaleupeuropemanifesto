<?php
/**
* Actions
* 
* @package daeimplementation.eu
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2012-2013 Tech4i2
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/


/**
 * Pillar class
 *
 */
class Pillar {
    
    public $countries;
    
    public function __construct() {
	
	
    }
    
    public function listArea($id_area=null){
	
	global $vmsql;
        
        if($id_area!==null){
            $and="WHERE id_area=".intval($id_area);
        }
        else 
            $and='';
	
	$sql="SELECT id_area, area, label
	    FROM area
            $and
	    ORDER BY id_area";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
    }
    
    
    public function getFirstAction($id_area, $type=''){
	
	global $vmsql;
        
        if($type=='ms'){
            
            $and = "AND leading_role IN ('Member States', 'Joint') ";
        }
	else if($type=='ec'){
            $and = "AND leading_role IN ('Commission', 'Joint') ";
        }
        else{
            $and='';
        }
	
	$sql="SELECT action_n, id_area, action as title
	    FROM action
	    WHERE id_area=".intval($id_area)."
            $and 
	    ORDER BY action_n
	    LIMIT 1";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc($q);
	
	return $mat;
    }
    
    public function getFirstActionId($id_area, $type){
        
        $act=self::getFirstAction($id_area,$type);
        
        return $act['action_n'];
    }
    
    
    public function listActions($id_area, $type){
	
	global $vmsql;
        
        if($type=='ms'){
            
            $and = "AND leading_role IN ('Member States', 'Joint') ";
        }
	else if($type=='ec'){
            $and = "AND leading_role IN ('Commission', 'Joint') ";
        }
        else{
            $and='';
        }
        
	$sql="SELECT action_n, id_area, action as title , short_desc, end_date as deadline , leading_role
	    FROM action
	    WHERE id_area=".intval($id_area)."
            $and
	    ORDER BY action_n
            ";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
    }
    
    public function listAllActions(){
	
	global $vmsql;
	
	$sql="SELECT a.action_n, a.id_area, a.action, p.area
	    FROM action a
	    INNER JOIN area p ON p.id_area=a.id_area 
	    ORDER BY p.id_area, action_n";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
    }
    
    
    /**
     * Get single action
     * 
     * @global object $vmsql
     * @param int $action_n
     * @return array 
     */
    public function getAction($action_n){
	
	global $vmsql;
	
	$sql="SELECT a.action_n, a.id_area, a.action, a.number, a.start_date, a.end_date, a.leading_role, a.in_dae, 
		p.area
	    FROM action a
	    INNER JOIN area p ON p.id_area=a.id_area 
	    WHERE action_n=".intval($action_n)."
	    ";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc($q);
	
	return $mat;
    }
    
    /**
     * Utility function: get pillar info from action number
     * 
     * @global object $vmsql
     * @param int $action_n
     * @return array (id_pillar, pillar)
     */
    public function getAreaFromAction($action_n){
	
	global $vmsql;
	
	$q=$vmsql->query("SELECT p.id_area, p.area 
		    FROM area p
		    INNER JOIN action a ON a.id_area=p.id_area
		    WHERE action_n=".intval($action_n));
	
	$RS=$vmsql->fetch_assoc($q);
	
	return $RS;
	
    }
    
    public function getIndicators($action_n, $only_id=false, $in_dashboard=true){
	
	global $vmsql;
	
	if($in_dashboard){
	    
	    $sql_add=" AND in_dashboard=1 ";
	}
	else{
	    $sql_add='';
	}
	
	if($only_id){
	
	    $q=$vmsql->query("SELECT id_indicator FROM indicator
			    WHERE action_n=".intval($action_n)." 
                AND visible=1 
			    $sql_add
			    ORDER BY num");

	    list($mat)=$vmsql->fetch_row_all($q, true);

	}
	else{
	    
	    $q=$vmsql->query("SELECT i.*, deadline FROM indicator i
			    INNER JOIN action a ON i.action_n=a.action_n
			    WHERE i.action_n=".intval($action_n)."
                AND i.visible=1 
			    $sql_add
			    ORDER BY num");

	    $mat=$vmsql->fetch_assoc_all($q);

	}
	
	return $mat;
	
    }
    
    public function setCountries($order_by='country'){
	
	global $vmsql;
	
	$sql="SELECT id_country, country, abbr, img_url, flag_url, is_eu
	    FROM country
	    ORDER BY $order_by";
	
	$q=$vmsql->query($sql);
	
	$this->countries=$vmsql->fetch_assoc_all($q);
	
    }
    
    public function getCountries($order='country'){
	
	global $vmsql;
	
	if(!is_array($this->countries)){
	    
	    $this->setCountries($order);
	}
	
	return $this->countries;
    }
    
}



/**
 * Area class
 *
 */
class Area {
    
    public $countries;
    
    public function __construct() {
	
	
    }
    
    public function listArea(){
	
	global $vmsql;
	
	$sql="SELECT id_area, area
	    FROM area 
	    ORDER BY id_area";
	
	$q=$vmsql->query($sql);
	
	$mat=$vmsql->fetch_assoc_all($q);
	
	return $mat;
    }
    
    
    public function setCountries($order_by='country'){
	
	global $vmsql;
	
	$sql="SELECT id_country, country, abbr, img_url, flag_url, is_eu
	    FROM country
	    ORDER BY $order_by";
	
	$q=$vmsql->query($sql);
	
	$this->countries=$vmsql->fetch_assoc_all($q);
	
    }
    
    public function getCountries($order='country'){
	
	global $vmsql;
	
	if(!is_array($this->countries)){
	    
	    $this->setCountries($order);
	}
	
	return $this->countries;
    }
    
}