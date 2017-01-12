<?php
/**
 * Action class
 * 
 * @package EDfx2 - Scale Up Europe Manifesto Tracker
 * @author Mario Marcello Verona <marcelloverona@gmail.com>
 * @copyright 2015-2016 Open Evidence
 */

class Action extends Entity {
    
    public $action_n;
    public $id_area;
    public $action;
    public $short_desc;
    public $number;
    public $start_date;
    public $end_date;
    public $leading_role;
    public $in_dae;
    public $indicators = array();
    
    protected $__pk = 'action_n';
    protected $__nometabella = 'action';
    
}