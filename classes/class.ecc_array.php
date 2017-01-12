<?php

/**
 * Generic class with function to manipulate arrays
 */
class ECC_Array {
    
    /**
     * Extract an array from a matrix
     * @param array $matrix
     * @param string $key
     * @return array
     */
    public static function extract($matrix, $key){
        
        $a = array();
        
        if(is_array($matrix)){
            foreach($matrix as $k=>$RS){
                if(array_key_exists($key, $RS)){
                    $a[]=$RS[$key];
                }
            }
        }
        
        return $a;
    }
    
    /**
     * Sort a bidimensional array by children key
     * 
     * @param array $m the matrix to be sorted
     * @param string $key the key used for sorting
     * @param string $sort asc|desc (default=asc)
     * @param boolean $reset_keys reset the array key (default false)
     * @return array
     */
    public static function matrix_sort($m, $key, $sort='asc', $reset_keys=false){

        if(!is_array($m)){
                return false;
        }

        $m2=array();

        foreach($m as $k=>$v){
            foreach($v as $kk=>$vv){
                if($kk == $key){
                        $m2[$vv."_".microtime(true)]= array($k=>$v);
                }
            }
        }

        if ($sort == 'desc') {
            krsort($m2);
        } else {
            ksort($m2);
        }

        $m3 = array();

        foreach ($m2 as $v2) {
            $m3 = ($m3 + $v2);
        }

        if ($reset_keys) {
            return array_values($m3);
        } else {
            return $m3;
        }
    }
    
    /**
     * Funzione utile da usare in array_walk
     */
    public static function walk_toint(&$s,$key){
        $s=intval($s);
    }
    
    /**
     * Funzione utile da usare in array_walk
     */
    public static function walk_trim_all(&$s,$key){
        $s=trim($s);
    }
    
    /**
     * Find in multidimensional array, with 1 or more parameters
     * 
     * @param array $array
     * @param array $matching ('search_field' => value [, ...])
     * @return boolean
     */
    public static function findWhere($array, $matching) {
        foreach ($array as $item) {
            $is_match = true;
            foreach ($matching as $key => $value) {

                if (is_object($item)) {
                    if (! isset($item->$key)) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if (! isset($item[$key])) {
                        $is_match = false;
                        break;
                    }
                }

                if (is_object($item)) {
                    if ($item->$key != $value) {
                        $is_match = false;
                        break;
                    }
                } else {
                    if ($item[$key] != $value) {
                        $is_match = false;
                        break;
                    } 
                }
            }

            if ($is_match) {
                return $item;   
            }
        }

        return false;
    }
    
}