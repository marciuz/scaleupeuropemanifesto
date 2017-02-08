<?php
/**
 * Common class
 * Utilities and common static functions
 * 
 * @package EDfx2 - Scale Up Europe Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015-2016 Open Evidence
 */

class Common {


    /**
     * Get the client ip
     * 
     * @return type string ip
     */
    public static function getIP() {

        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }

        return $ip;
    }
    
    /**
     * Get the Country name from the country ID
     * @param int $id_country
     * @return string
     */
    public static function country2id_country($id_country){
        
        $vmsql = mysqli_vmsql::init();
        return $vmsql->get_item("SELECT country FROM country WHERE id_country=".intval($id_country));
    }
    
    /**
     * Get the Country audience from the country ID
     * @param int $id_country
     * @return string
     */
    public static function country_audience($id_country){
        
        $vmsql = mysqli_vmsql::init();
        return $vmsql->get_item("SELECT ctype FROM _country WHERE id_country=".intval($id_country));
    }
    
    /**
     * Returns the logged user is an administrator
     * @return bool
     */
    public static function is_admin(){
        $Auth = new Auth();
        return $Auth->is_admin();
    }
    
    static public function clickable($text, $attributes=array()){
        
        $attr_string='';
        foreach($attributes as $attr=>$value){
            $attr_string.=" $attr=\"$value\"";
        }
        
        return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" '.$attr_string.'>$1</a>', $text);
    }
    
    static public function get_excerpt($text, $size=140, $after='... '){
        $excerpt = preg_replace(" (\[.*?\])",'',$text);
        $excerpt = strip_tags($excerpt);
        $excerpt = substr($excerpt, 0, $size);
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
        $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
        $excerpt.= $after;
        return $excerpt;
    }
}