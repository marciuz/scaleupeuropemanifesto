<?php
/**
* LIBRERIA SQL per PDO con gestione errori ed altre utility
* 
* @package VFront
* @subpackage DB-Libraries
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2007-2010 M.Marcello Verona
* @version 0.96 $Id: vmsql.mysqli.php 942 2011-03-31 11:20:28Z marciuz $
* @see vmsql.postgres.php
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/


class pdo_vmsql {

	public $vmsqltype='pdo';

	public $link_db=null;

	protected $transaction_is_open=false;

	protected $connected;

	protected $error_handler=null;

	protected $last_error=null;
        
    protected $stmt;

    protected $PDO;
    
    static protected $_instance;
    
    private $dbtype='mysql';
    
    public static function init(){
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function connect($array_db,$charset='utf8') {

        $dsn = $this->dbtype.":dbname={$array_db['dbname']};host={$array_db['host']}";

        if(isset($array_db['port']) && $array_db['port']!='') {
            $dsn.=";port={$array_db['port']}";
        }
        if($charset!=''){
            $dsn.=";charset={$charset}";
        }

        try {
            $this->PDO = new PDO($dsn, $array_db['user'], $array_db['passw']);
            $this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if($this->PDO){
                $this->connected=true;
            }
            else{
                throw new DbException(
                       "Connection error: is MySQL running? Otherwise please check your conf file.", EccEnum::E_MYSQL_DOWN);
            }

        } catch( DbException $e){
            $e->setLog(\Monolog\Logger::EMERGENCY);
            exit;
        }
    }
        

	/**
	 * @desc Esegue una query $sql
	 * @param string $sql
	 * @param bool $transazione
	 * @return object
	 */
	public function query($sql,$params=array()){
            
        $getmicro=microtime(true);

        if(trim($sql)==''){
            return false;
        }

        $this->stmt = $this->PDO->prepare($sql);

        $this->stmt->execute((array) $params);

        if(isset($GLOBALS['DEBUG_SQL_LOG']) && $GLOBALS['DEBUG_SQL_LOG']){
            $GLOBALS['DEBUG_SQL_STRING'][] = round((microtime(true) - $getmicro),4) . " --- ". $sql;
        }

        return $this->stmt;

	}
        
        
	/**
	 * @desc Funzione di fetch_row
	 * @return array
	 * @param resource $res
	*/
	public function fetch_row(&$res){

            if(is_object($res)){

                $RS= $res->fetch( PDO::FETCH_NUM );
                if($RS) return $RS;
                else return false;
            }
	}
        
        /**
	 * @desc Funzione di fetch_assoc
	 * @return array
	 * @param resource $res
	*/
	public function fetch_assoc(&$res){
            
            if(is_object($res)){

                $RS= $res->fetch( PDO::FETCH_ASSOC);
                if($RS) return $RS;
                else return false;
            }
	}
        
	/**
	 * @desc Funzione di fetch_array
	 * @return array
	 * @param resource $res
	*/
	public function fetch_array(&$res){

            if(is_object($res)){

                $RS= $res->fetch( PDO::FETCH_BOTH );
                if($RS) return $RS;
                else return false;
            }
	}

	/**
	 * @desc Funzione di fetch_object
	 * @return object
	 * @param resource $res
	*/
	public function fetch_object(&$res,$class_name=null){

            if(is_object($res)){

                $RS= $res->fetch( PDO::FETCH_OBJ );
                if($RS) return $RS;
                else return false;
            }
	}

        

	/**
	 * @desc Funzione di num_rows
	 * @return array
	 * @param resource $res
	*/
	public function num_rows(&$res){

            if(is_object($res)){
                return $res->rowCount();
            }
            else{
                return null;
            }
	}
        
        
	/**
	 * @desc Funzione di affected_rows
	 * @return int
	*/
	public function affected_rows($query){

            return $query->rowCount();
	}

        

	/**
	 * @desc  Funzione di insert ID che restituisce l'ultimo ID autoincrement inserito (MySQL)
	 * @param resource $res
	 * @param string $tablename Per compatibilità con Postgres
	 * @param string $fieldname Per compatibilit� con Postgres
	 * @return int
	*/
	public function insert_id($name=null){

            if(is_object($this->PDO)){
                    return $this->PDO->lastInsertId($name); 
            }
            else{
                return null;
            }
	}
        
        /**
         * Get DB Version (in SQL)
         * @return string
         */
	public function db_version(){

            $q=$this->query("SELECT VERSION()");
            list($db_version)=$this->fetch_row($q);
            return $db_version;
	}
        
         
    /**
     * Get single value
     * 
     * @param string $sql
     * @return string
     */
    public function get_value($sql, $parameters=array()){

        $q=$this->query($sql, $parameters);

        if($this->num_rows($q)>0){
            return $q->fetchColumn(0);
        }
        else{
            return null;
        }
    }
        
    /**
     * Alias of get_value
     * 
     * @param string $sql
     * @return string
     */
    public function get_item($sql, $parameters=array()){
        return $this->get_value($sql, $parameters);
    }
        
        
    private function fetch_all($method, &$res, $reverse=false){

        $matrice=array();

        if(is_object($res)){
            $matrice = $res->fetchAll($method);
            if($reverse)
                return $this->reverse_matrix($matrice);
            else
                return $matrice;
        }
    }
        
        
        /**
	 * @return resource
	 * @param resource $res
	 * @desc Funzione utility di fetch_row che restituisce tutta la matrice dei risultati
	*/
	public function fetch_row_all(&$res,$reverse=false){

            return $this->fetch_all(PDO::FETCH_NUM, $res, $reverse);
	}
        
        
        /**
	 * @return resource
	 * @param resource $res
	 * @desc Funzione utility di fetch_row che restituisce tutta la matrice dei risultati
	*/
	public function fetch_assoc_all(&$res,$reverse=false){

            return $this->fetch_all(PDO::FETCH_ASSOC, $res, $reverse);
	}
        
        /**
	 * @return resource
	 * @param resource $res
	 * @desc Funzione utility di fetch_row che restituisce tutta la matrice dei risultati
	*/
	public function fetch_object_all(&$res,$reverse=false){

            return $this->fetch_all(PDO::FETCH_OBJ, $res, $reverse);
	}
        


    /**
     * Prende tutta la matrice da SQL
     * 
     * @param string $sql
     * @param string $type Tipo di risultato: assoc|row|object
     * @return array
     */
    public function get($sql, $type='', $reverse=false){

        $q=$this->query($sql);

        switch($type){

            case 'row' : $mat=$this->fetch_row_all($q, $reverse);
            break;

            case 'object' : $mat=$this->fetch_object_all($q);
            break;

            case 'assoc' : 
            default : 
                    $mat=$this->fetch_assoc_all($q, $reverse);
            break;
        }

        return $mat;
    }
        
        /**
	 * @return  matrix
	 * @param matrix $matrix
	 * @desc restituisce una traslata della matrice partendo da indici numerici
	*/
	public function reverse_matrix($matrix){
        
        if(!is_array($matrix) || count($matrix)==0) return false;
        $keys = array_keys($matrix[0]);

        for($i=0;$i<count($matrix);$i++){
            for($j=0;$j<count($keys);$j++) $rev[$keys[$j]][$i] = $matrix[$i][$keys[$j]];
        }
        return $rev;
	}
        
        
	// FUNZIONI DI TRANSAZIONE


	/**
	 * @desc Funzione di transazione che corrisponde ad un BEGIN
	 * @param resource $this->link_db
	 */
	public function begin(){

        $this->PDO->beginTransaction();
        $this->transaction_is_open=true;
	}

	/**
	 * @desc Funzione di transazione di ROLLBACK
	 * @param resource $this->link_db
	 */
	public function rollback(){

        if($this->transaction_is_open){
            $this->PDO->rollBack();
            $this->transaction_is_open=false;
        }
	}
        
        
    /* Prepared statemens alternative methods */

    public function prepare($sql){
        return (is_string($sql) && $sql!='') ? $this->PDO->prepare($sql) : NULL;
    }

    public function execute($stmt, $params=array()){
        return (is_object($stmt)) ? $stmt->execute( (array) $params ) : NULL;
    }
        


	/**
	 * @desc Funzione di transazione di COMMIT
	 * @param resource $this->link_db
	 */
	public function commit(){
		
        if($this->transaction_is_open){
            $this->PDO->commit();
            $this->transaction_is_open=false;
        }
	}
        
        
	public function close(){

        if($this->error_handler!==null){
            $this->db_error_log($this->error_handler);
        }

        if($this->transaction_is_open){
                if($this->error_handler===null) $this->commit();
                else $this->rollback();
        }

        $this->PDO = null;
	}
        
        /**
	 * Escape function
	 *
	 * @param string $string
	 * @return string
	 */
	public function escape($string=null){

        return $this->PDO->quote($string);
	}
        

	/**
	 * Recursive escape. Work on strings, numbers, array, objects
	 *
	 * @param mixed $mixed
	 * @return mixed
	 */
	public function recursive_escape($mixed){

            if(is_string($mixed)){

                $escaped= $this->escape($mixed);
            }
            else if(is_numeric($mixed)){

                $escaped= $mixed;
            }
            else if(is_array($mixed)){
                $escaped=array();
                foreach ($mixed as $k=>$val)
                        $escaped[$k]=$this->recursive_escape($val);
            }
            else if(is_object ($mixed)){
                $escaped = new stdClass();
                foreach ($mixed as $k=>$val)
                        $escaped->{$k}=$this->recursive_escape($val);
            }
            else{
                $escaped=$mixed;
            }

            return $escaped;
	}

        
        /**
	 * Concat DB sintax
	 *
	 * @param string $args
	 * @param string $args
	 * @return string
	 */
	public function concat($args,$as=''){

		$str="CONCAT($args)";
		if($as!='') $str.=" AS $as";

		return $str;
	}
        
        
	/**
	 * @desc Funzione di free_result
	 * @return void
	*/
	public function free_result(){

        $this->stmt->closeCursor();
	}
        
        
	/**
	 *	For Oracle and MySQLi compatibility
	 *
	 * @param statement $stmt
	 * @return bool
	 */
	public function stmt_close(){
	
        $this->free_result();
        $this->stmt = null;
        return true;
	}
        
        

	/**
	 * Set the LIMIT|OFFSET sintax
	 *
	 * @param int $limit
	 * @param int $offset
	 * @return string
	 */
	public function limit($limit,$offset=''){

        if($offset!='') $str="LIMIT $offset,$limit";
        else $str="LIMIT $limit";

        return $str;
	}
        
        
        
	/**
	 * Esegue una query $sql  e restisce vero|falso a seconda dell'esito
	 * il secure_mode (di default) permette l'uso di sole query SELECT.
	 * Se l'sql contiene errori la funzione restituisce false, ma l'esecuzione prosegue.
	 *
	 * @param string $sql Query SQL da testare
	 * @param bool $secure_mode Imposta il secure mode per le query, invalidando tutte le query con comandi pericolosi
	 * @return bool Esito della query
	 */
	public function query_try($sql, $secure_mode=true, $params=array()){

        $sql=trim(str_replace(array("\n","\r")," ",$sql));

        if($secure_mode){
            // piccolo accorgimento per la sicurezza...
            if(!preg_match("'^SELECT 'i",$sql)) return 0;
            $sql2=preg_replace("'([\W](UPDATE)|(DELETE)|(INSERT)|(GRANT)|(DROP)|(ALTER)|(UNION)|(TRUNCATE)|(SHOW)|(CREATE)|(INFORMATION_SCHEMA)[\W])'ui","",$sql);
            if($sql2!=$sql){
                return -1;
            }
        }

        if(is_object($this->link_db)){

            $res = $this->query($sql, $params);
            //$error = mysqli_error($this->link_db);
            //$errno = mysqli_errno($this->link_db);
        }
        return ($res) ? 1:0;
	}

        
        

	public function __destruct() {
            $this->close();
	}

        
        
   /**
	 * @desc Funzione di num_fields
	 * @return int
	 * @param string $dbname
	*/
        /*
	public function num_fields($dbname){

            return @mysqli_num_fields($dbname);
	}
        */
        
        
        
        /*
         * ------------------------------------------------------------
         */

        
        
        
	/**
	 * @desc Esegue diverse query $sql
	 * @param string $sql
	 * @return object
	 */
	public function multi_query($sql){

		$getmicro=microtime(true);

		$obj = @mysqli_multi_query($this->link_db,$sql)
				or $this->error($sql);

		if(isset($GLOBALS['DEBUG_SQL_LOG']) && $GLOBALS['DEBUG_SQL_LOG']){
			$GLOBALS['DEBUG_SQL_STRING'][] = round((microtime(true) - $getmicro),3) . " --- ". $sql;
		}

		return $obj;

	}





	/**
	 * Funzione di fetch row in caso di multiple query
	 *
	 * @param resource $res
	 * @return array
	 */
	public function fetch_row_multi(&$res){


		$output=array();

		do {
			/* store first result set */
			if ($result = mysqli_store_result($this->link_db)) {
				while ($row = mysqli_fetch_row($result)) {
				   $output[]=$row;
				}
				mysqli_free_result($result);
			}

		} while (mysqli_next_result($this->link_db));


		return $output;

	}











	







	#########################################################################################
	#
	#
	#	FUNZIONI DI ELABORAZIONE
	#

	/**
	 * Funzione che recupera le informazioni sui campi di una tabella data
	 *
	 * @param string $tabella
	 * @param resource $this->link_db
	 * @return array
	 */
	/*public function fields($tabella,$this->link_db){

		$res = $this->query("SELECT * FROM $tabella LIMIT 1",$this->link_db);
		$i = @pg_num_fields($res);
		for ($j = 0; $j < $i; $j++) {
		   $fieldname = @pg_field_name($res, $j);
		   $tab_fields[$fieldname]=@pg_field_type($res, $j);
		}

		return $tab_fields;
	}*/


	/**
	 *  Recupera informazioni dal file e dalla query ed apre la funzione openError del file design/layouts.php dove cancella il buffer e manda a video l'errore codificato
	 *
	 * @return void
	 * @param string $sql
	 * @param string $message
	 * @desc Handler degli errori per le query.
	*/
	public function error($sql, $message=''){

		if(!is_object($this->error_handler)){

			$this->error_handler= new stdClass();
			$this->error_handler->dbtype=$this->vmsqltype;
			$this->error_handler->errors=array();
		}

		$trace=debug_backtrace();
		$last=count($trace)-1;
		$file_line=str_replace(FRONT_ROOT, '', $trace[$last]['file']).":".$trace[$last]['line'];

		$ee=array('date'=>date("c"),
				  'sql'=>$sql,
				  'code'=>mysqli_errno($this->link_db),
				  'msg'=>mysqli_error($this->link_db),
				  'file'=>$file_line
			);

		$this->error_handler->errors[]=$ee;

		$this->last_error=$ee;


		if($GLOBALS['DEBUG_SQL']){

			$this->error_debug();
		}
		else{
			__error(1501,array("vmsql"=>$ee,"SESSION"=>$_SESSION));
			header("Location: /p/errore?dett=1501");
			exit;
		}
	}


	/**
	 * Questa funzione viene eseguita da {@link $this->query} qualora il debug sia attivato
	 * @desc Funzione che restituisce a video l'SQL che ha generato l'errore
	 * @param string $format default "string"
	 */
	public function error_debug($format="string"){

		if($format=='string'){
			var_dump($this->last_error);
		}
	}



	protected function db_error_log($obj){

	    $fp=@fopen(FRONT_ERROR_LOG,"a");
	    $towrite='';

	    if(is_array($obj->errors)){

		    foreach($obj->errors as $e){

			    // prende il tipo query (SELECT , INSERT, UPDATE, DELETE) se il tipo � diverso ahi ahi
			    $tipo_query = substr(trim($e['sql']), 0 , strpos(trim($e['sql'])," "));

			    // restituisci la query che ha dato errore
			    $sql_una_linea = trim(preg_replace("'\s+'"," ",$e['sql']));
                            
                            $SERVER_HOST = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST']: '';
                            $SERVER_ADDR = (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR']: '';

			    // Scrittura del file di errore
			    $towrite.= "[".$e['date']."]\t"
						    . $e['file']."\t"
						    . $SERVER_HOST. " (".$SERVER_ADDR. ")\t"
						    . "<".$tipo_query . ">\t"
						    . $obj->dbtype."\t"
						    . $e['code'] . "\t"
						    . $e['msg'] . "\t"
						    . $sql_una_linea. "\n";
		    }

		    @fwrite($fp,$towrite);
	    }
	    @fclose($fp);
    }
}



class Vmsql_Cached extends pdo_vmsql {
    
    private $on;
    private $mc;
    public $write_log=true;
    private $duration;
    private $default_duration;
    protected static $_instance;
    
    protected function __construct(){
        $this->duration =  $this->default_duration = EccEnum::CACHE_1_H;
    }

    public static function init() {
        
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function connect($array_db, $charset = '', $db_memcache=null, $use_cache=false) {
        
        parent::connect($array_db, $charset);
        
        if($use_cache===true && class_exists('Memcache', false)){
            
            try{
                $this->mc = new Memcache();
                $test=@$this->mc->pconnect($db_memcache['host'], $db_memcache['port']);
                if(!$test){
                    throw new EccException('Memcached non connesso su '.$db_memcache['host']." (".$db_memcache['port'].")", 10012);
                }
                $this->on= (bool) $test;
            }
            catch( EccException $e){
                $e->setLog(\Monolog\Logger::ALERT);
            }
            
        }
        else{
            $this->on=false;
        }
    }
    
    public function set_duration($seconds){
        
        $this->duration=intval($seconds);
    }
    
    public function reset_duration(){
        
        $this->duration=$this->default_duration;
    }
    
    public function get($sql, $type='assoc', $reverse_row=false) {
        
        if(!$this->on){
            return parent::get($sql, $type);
        }
        
        $T0=microtime(true);
        
        $id_query=md5($sql);
        
        if($this->on){
            $result = $this->mc->get($id_query);
            
        }
        else
            $result = false;
        
        if(!$result){
            
            $result=parent::get($sql, $type, $reverse_row);
            if($this->on) $this->mc->set($id_query, $result, 0, $this->duration);
            
            $this->log("Setted $id_query -- exec time:".round(microtime(true) - $T0, 4));
        }
        else{
            $this->log("Getted from $id_query -- exec time:".round(microtime(true) - $T0, 4));
        }
        
        return $result;
    }
    
    public function log($string){
        
        if(!$this->write_log) return false;
        
        $fp=fopen(FRONT_TMP."/log_memcache.txt","a");
        fwrite($fp,"[".date('Y-m-d H:i:s')."]\t$string\n");
        fclose($fp);
        
    }
    
    public function get_item($sql, $parameters=array()) {
        return $this->get_value($sql, $parameters);
    }
    
    /**
     * Get single value
     * 
     * @param string $sql
     * @return string
     */
    public function get_value($sql, $parameters=array()){
        
        $id_query=md5($sql);
        
        if($this->on){
            $result = $this->mc->get($id_query);
        }
        else
            $result = false;
        
        if(!$result){
            $result=parent::get_value($sql, $parameters);
            if($this->on) $this->mc->set($id_query, $result, 0, $this->duration);
        }
        
        return $result;
    }
    
    public function __destruct() {
        parent::__destruct();
    }
}


class Vmsql extends pdo_vmsql{
    
}