<?php

define('STORE_DB_LOG', false);

abstract class Entity {
    
    protected $vmsql;
    protected $debug = false;
    protected $__nometabella = '';
    protected $__pk = '';
    
    
    
    public function __construct() {
        
        $this->vmsql = mysqli_vmsql::init();
    }
    
    public function set_debug($set){
        $this->debug = (bool) $set;
    }

    public function delete($id) {

        $id = (int) $id;

        if ($id == 0) {
            return null;
        }

        // Log
        if (STORE_DB_LOG) {
            $pre = $this->getRecord($id);
            $this->insertLog('delete', $pre, '', $id);
        }

        $sql = "DELETE FROM $this->__nometabella WHERE $this->__pk=" . $id;

        $q = $this->vmsql->query($sql);

        $res = $this->vmsql->affected_rows($q);

        if ($this->debug) {
            return $res;
        } 
        else {
            return ($res == 1) ? true : false;
        }
    }

    public function select($id) {

        $id = (int) $id;

        $sql = "SELECT * FROM $this->__nometabella WHERE $this->__pk=" . $id;

        $q = $this->vmsql->query($sql);

        $RS = $this->vmsql->fetch_assoc($q);

        return $RS;
    }
    
    public function getPublicVars () {
        return call_user_func('get_object_vars', $this);
    }

    public function save() {
        
        $attrs = $this->getPublicVars();
        
        print_r($attrs);

        if (isset($attrs[$this->__pk]) && intval($attrs[$this->__pk]) > 0) {
            
            // Look for the record:
            if($this->record_exists($attrs[$this->__pk])){
                return $this->update();
            }
            else{
                return $this->insert(true);
            }
        } 
        else {
            return $this->insert();
        }
    }

    protected function insert($force_insert_key=false) {

        $attrs = $this->filter_scalar($this->getPublicVars());
        
        $sql_campi = $sql_val = ' ';

        foreach ($attrs as $k => $v) {

            if ($k == $this->__pk && !$force_insert_key) {
                continue;
            }
            
            $sql_campi.="$k,";

            if (is_array($v)) {

                $v = $this->parse_array($v);
                $sql_val.= ( $v == '') ? 'NULL,' : $v . ",";
            } 
            else {
                $sql_val.= ( $v == '') ? 'NULL,' : "'" . $this->vmsql->escape($v) . "',";
            }
        }

        $sql = "INSERT INTO $this->__nometabella (" . substr($sql_campi, 0, -1) . ") "
                . "VALUES (" . substr($sql_val, 0, -1) . ")";

        if ($this->debug) {
            echo $sql;
        }

        $q = $this->vmsql->query($sql);

        $res = $this->vmsql->affected_rows($q);

        if ($res == 1) {

            if(intval($attrs[$this->__pk]) >0){
                $id_record = $attrs[$this->__pk];
            }
            else{
                $id_record = $this->vmsql->insert_id($this->__nometabella, $this->__pk);
            }
            
            
            // Log
            if (STORE_DB_LOG) {
                $this->insertLog('insert', '', json_encode($arr), $id_record);
            }

            return $id_record;
        } else {
            return false;
        }
    }
    
    private function filter_scalar($attributes){
        
        $pa = array();
        
        foreach($attributes as $k=>$v){
            if(is_scalar($v)){
                $pa[$k]=$v;
            }
        }
        
        return $pa;
    }

    protected function update() {
        
        $attrs = $this->filter_scalar($this->getPublicVars());

        $_sql = ' ';

        foreach ($attrs as $k => $v) {

            if ($k == $this->__pk)
                continue;

            $_sql.="$k=";

            if (is_array($v)) {

                $v = $this->parse_array($v);
                $_sql.= ( $v == '') ? 'NULL,' : $v . ",";
            }
            else {
                $_sql.= ( $v == '') ? 'NULL,' : "'" . $this->vmsql->escape($v) . "',";
            }
        }

        $sql = "UPDATE $this->__nometabella SET " . substr($_sql, 0, -1) . " WHERE $this->__pk=" . intval($attrs[$this->__pk]);

        if ($this->debug) {
            echo $sql;
        }

        if (STORE_DB_LOG) {
            $pre = $this->getRecord($attrs[$this->__pk]);
        }

        $q = $this->vmsql->query($sql);

        $res = $this->vmsql->affected_rows($q);

        if ($res >= 0) {

            // Log
            if (STORE_DB_LOG) {
                $this->insertLog('update', $pre, json_encode($attrs), $attrs[$this->__pk]);
            }

            return intval($attrs[$this->__pk]);
        } else {
            return 0;
        }
    }
    
    protected function record_exists($id) {

        $sql = "SELECT 1 FROM {$this->__nometabella} WHERE {$this->__pk}='$id'";
        $q = $this->vmsql->query($sql);
        return ($this->vmsql->num_rows($q) > 0) ? true:false;
    }
    
    protected function getRecord($id) {

        $sql = "SELECT * FROM {$this->__nometabella} WHERE {$this->__pk}='$id'";

        $q = $this->vmsql->query($sql);
        $RS = $this->vmsql->fetch_assoc($q);
        $json = json_encode($RS);

        return $json;
    }

    /**
     *
     * @param string $type
     * @param string $pre
     * @param string $post
     * @param int $id
     * @return boolean esito
     */
    protected function insertLog($type, $pre, $post, $id = 0) {

        $sql = sprintf("INSERT INTO log (tabella,tipo,pre,post,auth,id_record)
                    VALUES('%s', '%s', '%s', '%s', %d, %d)", $this->__nometabella, $type, $this->vmsql->escape($pre), $this->vmsql->escape($post), id_user(), intval($id));

        $test = $this->vmsql->query_try($sql, false);

        return $test;
    }
    
    protected function parse_array($a) {

        /* DATA */
        if (isset($a['gg'])) {

            if ($a['aaaa'] == '')
                $value = '';
            else
                $value = "'" . $this->vmsql->escape($a['aaaa'])
                        . "-" . $this->vmsql->escape($a['mm'])
                        . "-" . $this->vmsql->escape($a['gg']) . "'";
        }
        else{
            $value = $a;
        }
        
        return $value;
    }
}