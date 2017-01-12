<?php

class Experts {
    
    private $vmsql;
    
    const PICTURE_NOT_FOUND='not_found.jpg';
    
    public function __construct() {
        
        $this->vmsql = Vmsql::init();
    }
    
    public function get_experts(){
        
        $sql = "SELECT id_user, first_name, last_name, CONCAT(first_name, ' ', last_name) as fn, email, 
            country, abbr, title, organisation
            FROM user u
            INNER JOIN country c ON c.id_country = u.id_country 
            WHERE visible_web = 1
            ORDER BY country, last_name
            ";
        
        $q= $this->vmsql->query($sql);
        
        $mat = array();
        
        while($RS = $this->vmsql->fetch_assoc($q)){
            
            $picture_file = "assets/img/coordinators/".$RS['abbr'].".jpg";
            
            
            if(file_exists(FRONT_ROOT. "/" .$picture_file)){
                $RS['picture'] = $picture_file;
                
            }
            else{
                $RS['picture'] = "assets/img/coordinators/" . self::PICTURE_NOT_FOUND;
            }
            
            $mat[] = $RS;
        }
        
        return $mat;
       
    }
    
}