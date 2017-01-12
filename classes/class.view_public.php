<?php

class View_Public extends View {
    
    public function __construct() {
        parent::__construct();
        $this->vars['title'] = PROJ_NAME;
        $this->vars['h1'] = '';
        
        $this->vars['navbar'] = $this->render('navbar_public');
    }
}