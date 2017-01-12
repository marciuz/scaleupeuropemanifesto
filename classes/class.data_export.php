<?php

class Data_Export {
   
    protected $vmsql;

    public function __construct() {
        $this->vmsql = Vmsql::init();
    }
    
    private function raw_export(){

        $sql="SELECT area, 
            id_area, 
            ROUND(action_n / 10, 1) action_n, 
            action, 
            indicator, 
            id_indicator, 
            country, 
            abbr, 
            id_country, 
            CASE presence 
                WHEN 1 THEN 'Yes'
                WHEN 2 THEN 'No'
                WHEN '' THEN 'NA'
                ELSE ''
                END as response, 
            evidence, 
            id_user,
            lastdata as response_date

        FROM responses
        
        ORDER BY id_area, action_n, id_indicator, abbr 
        
        ";
        
        $q=$this->vmsql->query($sql);
        
        $mat = array();
        
        while($RS = $this->vmsql->fetch_assoc($q)){
            $RS['indicator'] = strip_tags($RS['indicator']);
            $mat[]  = $RS;
        }
        
        return $mat;
    }
    
    public function export_csv(){
        
        $data = $this->raw_export();
        
        if(count($data) == 0){
            return null;
        }
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=startup_manifesto-tracker-'.date('Ymd').'.csv');
        
        $fp = fopen('php://output', 'w');
        
        $col_names = array_keys($data[0]);
        fputcsv($fp, $col_names);
        
        for($i=0;$i<count($data); $i++){
            fputcsv($fp, $data[$i]);
        }
        
        fclose($fp);
    }
    
    public function export_json(){
        
        $data = $this->raw_export();
        
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename=startup_manifesto-tracker-'.date('Ymd').'.json');
        
        print json_encode($data);
    }
    
    public function export_xml(){
        
        $data = $this->raw_export();
        
        $n = count($data);
        
        header('Content-Type: text/xml; charset=utf-8');
        // header('Content-Disposition: attachment; filename=startup_manifesto-tracker-'.date('Ymd').'.json');
        
        print '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        print "<results rownum=\"".$n."\" date=\"".date('c')."\">\n";
        for($i=0;$i<$n;$i++){
            print $this->xml_encode($data[$i]);
        }
        print "</results>\n";
        exit;
    }
    
    private function xml_encode($RS){
        
        $row = "<row>\n";
        foreach($RS as $k=>$v){
            if(is_numeric($v)){
                $row.="<$k>".$v."</$k>";
            }
            else{
                $row.="<$k><![CDATA[".$v."]]></$k>";
            }
        }
        $row.="</row>\n";
        return $row;
    }
}