<?php

class Indicator extends Entity {
    
    public $id_indicator;
    public $ind_label;
    public $num;
    public $action_n;
    public $indicator;
    public $evidence_eg;
    public $in_dashboard;
    public $deadline;
    public $responsible;
    public $studies;
    public $audience;
    public $explanation;
    
    protected $__pk = 'id_indicator';
    protected $__nometabella = 'indicator';
}