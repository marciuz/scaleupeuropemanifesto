<?php

class View_Private extends View {
    
    public function __construct() {
        parent::__construct();
        $this->vars['title'] = PROJ_NAME;
        $this->vars['h1'] = '';
        
        $DS = new Data_Structure();
        $pr = $DS->load_priorities();
        $this->__set('pr',$pr);
        if(Common::is_admin()){
            $this->__set('is_admin', 1);
        }
        $this->__set('pr',$pr);
        $this->vars['navbar'] = $this->render('navbar');
    }
}