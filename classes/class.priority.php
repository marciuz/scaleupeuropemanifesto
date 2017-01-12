<?php

class Priority extends Entity {
    
    public $id_area;
    public $area;
    public $label;
    public $actions=array();
    
    protected $__pk = 'id_area';
    protected $__nometabella = 'area';
    
}