<?php
/**
 * Class Data Structure Read/Write
 * 
 * @package EDfx2 - Scale Up Europe Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015-2016 Open Evidence
 * @license http://www.gnu.org/licenses/gpl.html GNU Public License
 */

class Data_Structure_RW extends Data_Structure {
    

    public function radio($id, $default=''){

        $c1 = $c2 = '';

        if($default == 1) {
            $c1 = 'checked="checked"';
            $c2 = '';
        }
        else if($default == 2){
            $c2 = 'checked="checked"';
            $c1 = '';
        }

        $V = new View();
        $V->__set('checked1', $c1);
        $V->__set('checked2', $c2);
        $V->__set('id', $id);
        $out = $V->render('radiobuttons');

        return $out;

    }

    public function evidence_text($id, $default=''){

        $V = new View();
        $V->__set('id',$id);
        $V->__set('default',$default);
        $out = $V->render('evidence_textarea');
        
        return $out;
    }
    
    /**
     * Get the statistics about the completion of the forms
     * 
     * @param int $id_country
     * @return array
     */
    public function get_stats_fill($id_country){
        
        $sql="SELECT a.id_area, label, count(m.id_indicator) as filled, count(i.id_indicator) as tot
                FROM indicator i
                INNER JOIN action a ON a.action_n = i.action_n 
                INNER JOIN area aa ON aa.id_area = a.id_area 
                LEFT JOIN ms_form m ON m.id_indicator = i.id_indicator AND  m.id_country = ".intval($id_country)."
                WHERE i.visible=1 
                GROUP BY id_area";
        
        return $this->vmsql->get($sql);
    }
    
    public function get_data($id_country, $id_priority='all'){
        
        $sql_priority = ($id_priority === 'all' ) ? '' : 'AND a.id_area='.intval($id_priority);
        
        $sql = "SELECT msf.id_indicator, msf.id_country, msf.presence, msf.evidence, msf.lastdata, msf.id_user, msf.confirmed, 
                i.action_n, i.ind_label
            FROM ms_form msf
            INNER JOIN indicator i ON i.id_indicator = msf.id_indicator 
            INNER JOIN action a ON a.action_n = i.action_n 
            WHERE msf.id_country=".intval($id_country)." 
            $sql_priority
            AND i.visible=1 
            ORDER BY i.action_n, i.ind_label
        ";
        
        return $this->vmsql->get($sql);
    }
    
    
    public function save_form($_data){
        
        $id_country = intval($_data['id_country']);
        
        $aff = 0;
        
        foreach($_data['presence'] as $k=>$v){
            
            if(isset($_data['evidence'][$k])){
                
                $evidence = $this->vmsql->escape($_data['evidence'][$k]);
                
                $sql = sprintf("INSERT INTO ms_form (id_indicator, id_country, presence, evidence, lastdata, id_user)
                    VALUES (%d, %d, %d, '%s', '%s', %d)
                    ON DUPLICATE KEY UPDATE presence=%d, evidence='%s', lastdata='%s', id_user=%d ",
                        
                    $k, 
                    $id_country, 
                    
                    $v, 
                    $evidence,
                    date('Y-m-d H:i:s'),
                    user_id(),
                    
                    $v, 
                    $evidence,
                    date('Y-m-d H:i:s'),
                    user_id());
                
                
                $q = $this->vmsql->query($sql);
                
                $aff+= $this->vmsql->affected_rows($q);
                    
            }
        }
        
        return $aff;
    }
    
    public function save_summary($summary, $id_country){
        
        $sql = sprintf("UPDATE country SET summary='%s' WHERE id_country=%d ",
                $this->vmsql->escape($summary),
                intval($id_country)
            );
        
        $q = $this->vmsql->query($sql);
        
        return $this->vmsql->affected_rows($q);
    }
}