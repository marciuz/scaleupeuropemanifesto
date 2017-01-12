<?php

class View {
    
    protected $template_dir;
    protected $vars = array();
    protected $js_scripts_header = array();
    protected $js_scripts_footer = array();
    protected $js_scripts_inline = '';
    protected $css_all;


    public function __construct() {
        $this->template_dir = FRONT_ROOT.'/tpl';
    }
    
    public function render($template_file, $return=true) {
        
        $fname = $this->template_dir."/".$template_file.".tpl.php";
        
        if (file_exists($fname)) {
            
            if($return){
                ob_start();
                include $fname;
                $out = ob_get_contents();
                ob_end_clean();
                return $out;
            }
            else{
                
                include $fname;
            }
        } 
        else {
            throw new Exception('no template file ' . $template_file . ' present in directory ' . $this->template_dir);
        }
    }
    
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    
    public function __get($name) {
        return (isset($this->vars[$name])) ? $this->vars[$name] : null;
        //return $this->vars[$name];
    }
    
    public function set_title($title){
        $this->vars['title']=$title;
    }
    
    public function add_js($url, $position='footer'){
        if($position == 'footer'){
            $this->js_scripts_footer[] = $url;
        }
        else if($position == 'inline'){
            $this->js_scripts_inline.=$url."\n";
        }
        else{
            $this->js_scripts_header[] = $url;
        }
    }
    
    public function add_css($url, $type='all'){
        $this->css_all[] = $url;
    }
    
    public function render_css(){
        $out = '';
        
        if(isset($this->css_all) && is_array($this->css_all)){
            foreach($this->css_all as $css){
                $out.="<link href=\"".FRONT_DOCROOT."/assets/css/$css\" rel=\"stylesheet\" />\n";
            }
        }
        
        return $out;
    }


    public function render_js($type='header'){
        $html_head= $html_footer = '';
        foreach($this->js_scripts_header as $js){
            
            if(substr($js,0,2)=='//' || substr($js, 0, 4) == 'http'){
                $html_head.="\t<script src=\"".$js."\"></script>\n";
            }
            else{
                $html_head.="\t<script src=\"".FRONT_DOCROOT."/assets/js/$js\"></script>\n";
            }
        }
        foreach($this->js_scripts_footer as $js){
            if(substr($js,0,2)=='//' || substr($js, 0, 4) == 'http'){
                $html_footer.="\t<script src=\"".$js."\"></script>\n";
            }
            else{
                $html_footer.="\t<script src=\"".FRONT_DOCROOT."/assets/js/".$js."\"></script>\n";
            }
        }
        
        return ($type == 'header') ? $html_head : $html_footer;
    }
}