<?php
/**
* Member state Form
* 
* @package daeimplementation.eu
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2012 Tech4i2
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/


/**
 * Forms read/write
 *
 */
class MSForm extends Pillar {
   
    public $MSformData;
    
    /**
     *
     * @var string 'ec','ms','' 
     */
    public $auth_type;
    
    public function __construct() {
	
	$this->auth_type= (isset($_SESSION['user']['type'])) ? $_SESSION['user']['type']: 'null';
        
	$this->MSformData = new stdClass();
    }
    
    
    public function getGeneralInfo($id_country){
        
        global $vmsql;
        
        $sql="SELECT ministry, link_action_plan, progress_summary, lastdata
            FROM ms_gen_info
            WHERE id_country=".intval($id_country);
        
        $q=$vmsql->query($sql);
        
        return $vmsql->fetch_assoc($q);
    }
    
    
    public function setGeneralInfo($id_country, $RS){
        
        global $vmsql;
        
        $RS = $vmsql->recursive_escape($RS);
        
        $sql=sprintf("INSERT INTO  ms_gen_info (ministry, link_action_plan, progress_summary, lastdata, id_country)
            VALUES ('%s', '%s', '%s', '%s', %d)
            ON DUPLICATE KEY UPDATE ministry='%s', link_action_plan='%s', progress_summary='%s', lastdata='%s'",
            $RS['ministry'],
            $RS['link_action_plan'],
            $RS['progress_summary'],
            date('c'),
            intval($id_country),
                
                // Update values
                $RS['ministry'],
                $RS['link_action_plan'],
                $RS['progress_summary'],
                date('c')
          );
        
        $q=$vmsql->query($sql);
        
        
        return ($vmsql->affected_rows($q) > 0 ) ? true:false;
    }
    
    
    
    
    public function getIndicators($action_n, $id_country){
	
	global $vmsql;
        
        if($id_country==COUNTRY_EC){
            $and_audience = "AND audience IN ('','ec')";
        }
        else if($id_country!=COUNTRY_EC){
            $and_audience = "AND audience IN ('','ms')";
        }
        else{
            $and_audience='';
        }
	
	$sql="SELECT id_indicator, indicator, evidence_eg, deadline, responsible, audience, explanation
	    FROM indicator 
	    WHERE action_n=".intval($action_n)."
        AND visible=1
            $and_audience
	    ORDER BY num
	    ";
	
	$q=$vmsql->query($sql);
	
	$mat = $vmsql->fetch_assoc_all($q);
	
	return $mat;
	
    }
    
    
    
    public function setMSform($id_country, $action_n){
	
	// INDICATORS
	$ind = $this->getIndicators($action_n, $id_country);
        
	$this->MSformData->indicators=$ind;
        
        foreach($this->MSformData->indicators as $indicator){
            
            $id_indicator=$indicator['id_indicator'];
            
            $this->MSformData->indicatorValue[$id_indicator]=$this->getIndicatorData($id_country, $id_indicator);
            
        }
        
	// LAST VALUES (last revision)
	// $this->setLastRevision($id_country,$action_n);
    }
    
     public function getIndicatorData($id_country,$id_indicator){
        
        global $vmsql;
        
        $sql="SELECT f.presence, f.id_country, f.id_indicator, f.evidence, f.lastdata, f.id_user, f.confirmed 
            FROM ms_form f
            WHERE f.id_country=".intval($id_country)."
            AND f.id_indicator=".intval($id_indicator)."
        ";
        
        $q=$vmsql->query($sql);
        
        $mat=$vmsql->fetch_assoc_all($q);
        
        return $mat;
    }
    
    public function getData($id_country,$action_n){
        
        global $vmsql;
        
        $sql="SELECT f.presence, f.id_indicator, f.evidence, f.lastdata, f.id_user, f.confirmed
            FROM ms_form f
            INNER JOIN indicator i ON i.id_indicator=f.id_indicator
            WHERE f.id_country=".intval($id_country)."
            AND i.action_n=".intval($action_n)."
            AND i.visible=1
            ORDER BY f.id_indicator";
        
        $q=$vmsql->query($sql);
        
        $mat=$vmsql->fetch_assoc_all($q);
        
        return $mat;
    }
    
    
    public function save($_data){
	
	global $vmsql;
	
	$_data = $vmsql->recursive_escape($_data);

	// INSERT DETAILS: 
	
	$ins_rows=0;
	$expected=0;
        
        $confirmed = (isset($_data['action_n_confirmed']) && $_data['action_n_confirmed']==1) ? 1:0;
	
	foreach($_data['ind'] as $id_indicator=>$ind){
            
            $sql0="SELECT id_ms_form FROM ms_form WHERE id_indicator=".intval($id_indicator)
                  ." AND id_country=".intval($_data['id_country']);
            
            $q0=$vmsql->query($sql0);
            
            if($vmsql->num_rows($q0)==0){
            
                $sql=sprintf("
                    INSERT INTO ms_form (id_country, id_indicator, presence, evidence, id_user, lastdata, confirmed)
                    VALUES (%d, %d, %d, '%s', %d, '%s', %d)",
                    $_data['id_country'],
                    $id_indicator,
                    $ind['presence'],
                    $ind['evidence'],
                    $_SESSION['user']['id_user'],
                    date('c'),
                    $confirmed
                    );

                $q2=$vmsql->query($sql);
            
            }
            else{
                
                 $sql=sprintf("
                    UPDATE ms_form SET presence=%d, evidence='%s', id_user=%d, lastdata='%s', confirmed=%d 
                    WHERE id_country=%d AND id_indicator=%d",
                    $ind['presence'],
                    $ind['evidence'],
                    $_SESSION['user']['id_user'],
                    date('c'),
                    $confirmed, 
                         
                    $_data['id_country'],
                    $id_indicator
                    );

                $q2=$vmsql->query($sql);
            }
            
	    
	    $result = ($vmsql->affected_rows($q2)>=1) ? 1:0;
	    
	    $ins_rows+=$result;
	    $expected++;
	    
	}
	
	// Test on rows
	if($ins_rows==$expected){
	    
	    return true;
	}
	else{
	    return false;
	}
	
    }
    
}



