<?php
/**
 * Auth class
 * 
 * @package EDfx - Startup Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015 Open Evidence
 * @license http://www.gnu.org/licenses/gpl.html GNU Public License
 */

/**
 * Auth class
 */
class Auth {

    /**
     * Sleep anti-brute force
     * @var type int
     */
    public $sleep_no_log = 2;

    /**
     * Login function
     * 
     * @global object $vmsql
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login($email, $password) {

        $vmsql = mysqli_vmsql::init();

        $email = $vmsql->escape(trim($email));

        $password = md5(trim($password));

        if ($email == ''){

            return -2;
        } 
        else {

            $sql = "SELECT u.*, country 
		FROM user u 
		LEFT JOIN country c ON u.id_country=c.id_country
		WHERE u.email='$email' AND u.passwd='$password'
		";

            $q = $vmsql->query($sql);

            if ($vmsql->num_rows($q) == 1){

                $_SESSION['user'] = $vmsql->fetch_assoc($q);
                $_SESSION['id_country'] = $_SESSION['user']['id_country'];
                
                unset($_SESSION['user']['passwd']);

                $this->log_access($_SESSION['user']['id_user']);

                return true;
        } 
        else{

                sleep($this->sleep_no_log);

                return false;
            }
        }
    }

    /**
     * Logout function: destroy the session
     */
    public function logout() {

        if (isset($_SESSION['user'])){
            
            if(isset($_SESSION['id_country'])){
                unset($_SESSION['id_country']);
            }
            
            unset($_SESSION['user']);
            session_destroy();
            session_name(SESSION_NAME);
            session_start();
        }
    }

    /**
     * Is the logged user admin?
     * 
     * @return boolean
     */
    public function is_admin() {

        if (isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 'admin'){
            return true;
        } 
        else{
            return false;
        }
    }

    /**
     * Is the logged user a Member State?
     * 
     * @return boolean
     */
    public function is_ms() {

        if (isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 'ms'){
            return true;
        } else{
            return false;
        }
    }

    /**
     * Is the logged user EU Commission?
     * 
     * @return boolean
     */
    public function is_ec() {

        if (isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 'ec'){

            return true;
    } else{
            return false;
    }
    }

    /**
     * Log the user actions
     * 
     * @global object $vmsql
     * @param integer $id_user
     */
    public function log_access($id_user) {

        $vmsql = mysqli_vmsql::init();

        $id_user = (int) $id_user;

        $sql = "INSERT INTO log_access(id_user, access_date, ip) 
	    VALUES ($id_user, '" . date('Y-m-d H:i:s') . "', '" . Common::getIP() . "')";

        $q = $vmsql->query($sql);

        // Utility: update last date access on user profile
        $info = array('last access' => date('c'));
        $sql2 = "UPDATE user SET other_info='" . $vmsql->escape(json_encode($info)) . "' WHERE id_user=" . $id_user;

        $q2 = $vmsql->query($sql2);
    }

}
