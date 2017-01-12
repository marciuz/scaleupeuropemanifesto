<?php
/**
 * Class Data_Structure 
 * 
 * @package EDfx - Startup Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015 Open Evidence
 */

class Data_Structure {
    
    protected $vmsql;
    
    private $data_dash;
    
    const GREEN = 1;
    const YELLOW = 2;
    const RED = 3;
    const NA = 0;
    
    //const GREEN_LABEL = 'All actions completed';
    const GREEN_LABEL = 'Most actions completed';
    const YELLOW_LABEL = 'Some actions completed';
    const RED_LABEL = 'No actions completed';
    const NA_LABEL = 'Data not available yet';
    
    public $dashboard_default_visibility = array(
        's0'=>1,
        's1'=>1,
    );

    public function __construct() {
        $this->vmsql = mysqli_vmsql::init();
    }
    
    public function load_priorities(){
        
         $sql = "SELECT * 
            FROM area 
            ORDER BY id_area ASC";
        
        // Load the priorities
        $q = $this->vmsql->query($sql);
        $mat = $this->vmsql->fetch_object_all($q, 'Priority');
            
        return $mat;
    }
    
    public function load_data_action($action_n='all'){
        
        $where = ($action_n === 'all') ? '' : 'WHERE a.action_n='.intval($action_n);
        
         $sql = "SELECT a.action_n, a.id_area, r.area, a.action, a.short_desc, a.long_desc, a.number 
            FROM action a
            INNER JOIN area r ON a.id_area=r.id_area 
            $where
            ORDER BY a.action_n ASC";
        
        // Load the priorities
        $q = $this->vmsql->query($sql);
        $mat = $this->vmsql->fetch_assoc_all($q);
            
        return ($action_n === 'all' || count($mat) == 0) ? $mat : $mat[0];
    }
    
    public function load_countries(){
        
         $sql = "SELECT c.id_country, c.country, c.abbr, c.flag_url, c.summary, c.ctype
            FROM _country c
            WHERE visible = 1 
            ORDER BY order_num, ctype, country ASC";
        
        // Load the priorities
        $q = $this->vmsql->query($sql);
        $mat = $this->vmsql->fetch_assoc_all($q);
            
        return $mat;
    }
    
    public function load_country_by_abbr($abbr){
        
         $sql = "SELECT id_country, country, abbr, flag_url, summary, ctype
            FROM _country
            WHERE visible = 1 
            AND abbr='".$this->vmsql->escape($abbr)."'";
        
        $q = $this->vmsql->query($sql);
        $RS = $this->vmsql->fetch_assoc($q);
            
        return $RS;
    }
    
    public function load_country_by_id_country($id_country){
        
         $sql = "SELECT id_country, country, abbr, flag_url, summary
            FROM country
            WHERE visible = 1 
            AND id_country=".intval($id_country);
        
        $q = $this->vmsql->query($sql);
        $RS = $this->vmsql->fetch_assoc($q);
            
        return $RS;
    }
    
    
    public function load($id_priority='all'){
        
        $sql_where = ($id_priority === 'all') ? '' : 'WHERE id_area='.intval($id_priority);
        
        $sql = "SELECT * 
            FROM area 
            $sql_where
            ORDER BY id_area ASC";
        
        // Load the priorities
        $q = $this->vmsql->query($sql);
        
        $o = new stdClass();
        
        while($RS = $this->vmsql->fetch_object($q, 'Priority')){
            
            $RS->actions = $this->load_actions($RS->id_area);
            $o->priorities[] = $RS;
        }
        
        return $o;
    }
    
    public function load_actions($id_priority){
        
        $actions = array();
        
        $sql_actions = "SELECT * FROM action WHERE id_area=".intval($id_priority)." ORDER BY number, action_n";
        $qa = $this->vmsql->query($sql_actions);

        while($RSa = $this->vmsql->fetch_object($qa, 'Action')){

            $RSa->indicators = $this->load_indicators($RSa->action_n);
            $actions[] = $RSa;
        }
        
        return $actions;
    }
    
    public function load_indicators($action_n, $audience_ctype=null){
        
        $res = array();
        
        $sql_audience = ($audience_ctype !== null) ? " AND audience='".$audience_ctype."' " : '';
        
        $sql_indicators = "SELECT * FROM indicator WHERE visible=1 "
                . "AND action_n = ".intval($action_n)." "
                . $sql_audience
                . "ORDER BY ind_label";
        $qi = $this->vmsql->query($sql_indicators);
        while($RSi = $this->vmsql->fetch_object($qi, 'Indicator')){
            $res[] = $RSi;
        }
        
        return $res;
    }
    
    public function matrix_priority(){
        
        $mat = array();
        
        $sql="SELECT id_area, area FROM area ORDER BY id_area";
        $q=$this->vmsql->query($sql);
        
        while($RS = $this->vmsql->fetch_row($q)){
            $mat[$RS[0]]=$RS[1];
        }
        
        return $mat;
    }
    
    public function matrix_country(){
        
        $mat = array();
        
        $sql="SELECT abbr, country FROM _country ORDER BY order_num, abbr";
        $q=$this->vmsql->query($sql);
        
        while($RS = $this->vmsql->fetch_row($q)){
            $mat[$RS[0]]=$RS[1];
        }
        
        return $mat;
    }
    
    public function matrix_action($trimmered=false){
        
        $mat = array();
        
        $sql="SELECT action_n, action, short_desc FROM action ORDER BY number, action_n";
        $q=$this->vmsql->query($sql);
        
        while($RS = $this->vmsql->fetch_row($q)){
            
            if($trimmered){
                $tk = explode("(", $RS[1]);
                $RS[1]=$tk[0];
            }
            
            $mat[$RS[0]]= (trim($RS[2]) == '') ? $RS[1] : $RS[2];
        }
        
        return $mat;
    }
    
    public function dashboard(){
        
        // Matrix with Countries in x and Action summary in Y
        $cs = $this->load_countries();
        $ds = $this->load();
        
        $table = array();
        
        foreach($ds->priorities as $pr){
            foreach($pr->actions as $action){
                foreach($cs as $c){
                    $table[$pr->id_area][$action->action_n][$c['abbr']] = $this->find_in_dashboard($c['id_country'], $action->action_n);
                }
            }
        }
        
        return $table;
    }
    
    
    /**
     * Find and return ALL YES
     * @param int $id_country
     * @param int $action_n
     * @return int (1 => true, 0 => false, -1 => n.a.)
     */
    private function find_in_dashboard($id_country, $action_n){
        
        // Initialize
        if(!is_array($this->data_dash)){
            $this->data_dash = (array) $this->vmsql->get("SELECT * FROM dashboard02");
        }
        
        for($i=0;$i<count($this->data_dash);$i++){
            if($this->data_dash[$i]['id_country'] == $id_country && $this->data_dash[$i]['action_n'] == $action_n){

                return $this->criteria_01($this->data_dash[$i]['yes'], $this->data_dash[$i]['no'], $this->data_dash[$i]['tot']);
            }
        }

        return self::NA;
    }
    
    
    public function get_country_action_data($id_country, $action_n){
        
        $sql="SELECT f.* , indicator, action_n
            FROM ms_form f
            INNER JOIN indicator i ON f.id_indicator = i.id_indicator 
            WHERE f.id_country=".intval($id_country)." 
            AND i.action_n=".intval($action_n)." 
            AND i.visible=1 
            ORDER BY action_n, id_indicator ";
        
        return $this->vmsql->get($sql);
    }
    
    
    public function summary_dashboard($id_country){
        
        $sql="SELECT d.id_area, a.area, SUM(yes) ty, SUM(no) tn, SUM(na) as tna,  SUM(tot) stot  
            FROM dashboard02 d
            INNER JOIN area a ON a.id_area = d.id_area
            WHERE d.id_country = ".intval($id_country)." 
            GROUP BY id_area
            ORDER BY id_area";
        
        $mat = $this->vmsql->get($sql);

        foreach($mat as $k=>$a){
            
            $mat[$k]['color'] = $this->criteria_01($a['ty'], $a['tn'], $a['stot']);
        }
        
        return $mat;
    }
    
    /**
     * Create a corrispondance table between action_n and numbers.
     * 
     * @return array
     */
    public function anumbers(){
        
        $sql = "SELECT action_n, number FROM action";
        $mat = $this->vmsql->get($sql);
        $mat2 = array();
        
        foreach($mat as $a){
            $mat2[$a['action_n']]= $a['number'];
        }
        
        return $mat2;
    }
    
    public function summary_dashboard_all($return_type='json'){
        
        $T0 = microtime(true);
        
        $countries = $this->load_countries();
        
        $mat = array();
        
        foreach($countries as $co){
            $data = $this->summary_dashboard($co['id_country']);
            $mat['data'][$co['abbr']] = $data;
            $mat['comp'][$co['abbr']] = $this->calculate_percentage($data);
        }
        
        $mat['time'] = round(microtime(true) - $T0, 3);
        
        if($return_type == 'json'){
            return json_encode($mat);
        }
        else{
            return $mat;
        }
    }
    
    /**
     * Static function, returns a HTML label
     * @param int $res (1|2|null)
     * @return string HTML
     */
    public static function response($res){
        
        switch ($res){
            
            case 1 : $out = 'Yes';
            break;
        
            case 2: $out = 'No';
            break;
        
            default :     
                $out = 'N.A.';
            break;
        }
        
        return "<span class=\"res-".intval($res)."\">".$out."</span>";
    }
    
    /**
     * Calculate the percentage from the array $data,
     * with stot, ty, tn values
     * 
     * @param array $data
     * @return int
     */
    private function calculate_percentage($data){
        $tot= $comp = 0;
        foreach($data as $row){
            $tot += $row['stot']; 
            $comp += $row['ty'] + $row['tn']; 
        }
        return round($comp / $tot * 100);
    }
    
    /**
     * Get the last changes in the forms, grouped by action_n
     * 
     * @param int $limit Default 10
     * @return array
     */
    public function get_last_data($limit=10){
        
        $sql="SELECT lastdata, action_n, action, area, country, abbr, CONCAT(first_name, ' ', last_name) as who 
            FROM responses r
            INNER JOIN user u ON r.id_user = u.id_user
            GROUP BY action_n 
            ORDER BY lastdata DESC
            LIMIT $limit ";
        
        return $this->vmsql->get($sql);
    }
    
    
    /**
     * Tutti NA = NA
     * In caso di alcuni NA si considerano e si conteggiano gli altri
     * Il verde è solo in caso di totalità YES 
     *  -> Modifica 24/09/2015: il verde è > 50%
     * Il rosso è solo in caso di totalità NO
     * Gli altri casi = arancione
     * 
     * @param int $y
     * @param int $n
     * @param int $tot
     * @return int 
     */
    private function criteria_01($y, $n, $tot){
        
        if($y == 0 && $n == 0){
            return self::NA;
        }
        // più del 50%
        else if($y*2 > $tot){
            return self::GREEN;
        }
        else if($n == $tot ){
            return self::RED;
        }
        else if($n > 0 && $y == 0){
            return self::RED;
        }
        else{
            return self::YELLOW;
        }
    }
    
    /**
     * Tutti NA = NA
     * In caso di alcuni NA non si considerano e si conteggiano gli altri
     * Il verde è solo in caso di totalità YES
     * 
     * @param int $y
     * @param int $n
     * @param int $tot
     * @return int 
     */
    private function criteria_01b($y, $n, $tot){
        
        if($y == 0 && $n == 0){
            return self::NA;
        }
        else if($y == $tot){
             return self::GREEN;
        }
        else if($y >= $n ){
            return self::YELLOW;
        }
        else if($y < $n ){
            return self::RED;
        }
    }
    
    /**
     * Tutti NA = NA
     * In caso di alcuni NA si considerano e si conteggiano gli altri
     * Il verde è solo in caso di totalità YES 
     * Il rosso è solo in caso di totalità NO
     * Gli altri casi = arancione
     * 
     * @param int $y
     * @param int $n
     * @param int $tot
     * @return int 
     */
    private function criteria_01_old($y, $n, $tot){
        
        if($y == 0 && $n == 0){
            return self::NA;
        }
        else if($y == $tot){
             return self::GREEN;
        }
        else if($n == $tot ){
            return self::RED;
        }
        else if($n > 0 && $y == 0){
            return self::RED;
        }
        else{
            return self::YELLOW;
        }
    }
    
}