<?php
/**
* Layout generator
* 
* @package daeimplementation.eu
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2012 Tech4i2
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/

/**
 *  Abstract class for the Layouts
 */
abstract class __Layout {
	
	public $title='';
	
	public $files=array();
        
	public $files_css=array();
        
	public $files_js=array();
	
	public $security_level=0;
	
	public $charset='UTF-8';
	
	public $doctype='XHTML 1.0 Strict';
	
	public $lang='it';
	
	public $tidy_config=array();
	
	public $h1;
	
	public $keywords;
	
	private $breadcrumbs='';
	
	private $HTML='';
	
	private $custom_js='';
	
	private $custom_css=array();
	
	protected $is_open = false;
	
	protected $is_closed = false;
	
	protected $default_css=array();
	
	protected $conditional_css=array();
	
	protected $default_js=array();
	
	protected $custom_head_code='';

	protected $footer_html='';
	
	protected $header_html='';
	
	protected $meta='';

	protected $box_login;

	protected $namespaces;



	public function __construct(){

	    if(defined('GOOGLE_ANALYTICS_CODE') 
                    && GOOGLE_ANALYTICS_CODE!=''
                    && isset($_SERVER['REMOTE_ADDR']) 
                    && defined('ADDRESS_NO_ANALYTICS') 
                    && $_SERVER['REMOTE_ADDR']!=ADDRESS_NO_ANALYTICS){
                
			$this->custom_head_code="
			<script type=\"text/javascript\">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '".GOOGLE_ANALYTICS_CODE."']);
                        _gaq.push(['_setDomainName', 'egovap-evaluation.eu']);
			_gaq.push(['_trackPageview']);
                        

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

			</script>
			";

	    }


		

		$this->box_login="";

	}
	

	public function check_security($condizione='', $redirect=''){
		
		if($this->security_level===0){
			
			// non fa nulla, non interviene nel flusso
		}
		else{
			
			// clausola di sicurezza
			if($condizione){
				
				
				
			}
			else{
				
				// NON ESISTE IL COOKIE: REDIRECT SULL'AUTH
				header("Location: ".$redirect);
				exit;
			}
		}
	}

	
	public function addHTML($html){
		
		$this->HTML.=$html;
	}
	
	function addCustomJS($js){
		
		$this->custom_js=$js;
	}
	
	public function addCustomCSS($code,$media='all'){
		
		$this->custom_css[0]=$code;
		$this->custom_css[1]=$media;
	}
	
	function addCustomHeadCode($code){
		
		$this->custom_head_code=$code;
	}
	
	function addMeta($code){
	
		$this->meta.=$code."\n";
	}
	
	
	function addBreadcrumbs($array_bread=array(),$id="briciole",$testo='',$sep='&gt;'){
		
		$this->breadcrumbs="\n\t\t<div id=\"$id\">$testo\n";
		
		$n_bread = count($array_bread);
		
		$c=1;
		
		foreach ($array_bread as $titolo=>$url) {
			
			if($n_bread>$c){
				$this->breadcrumbs.="<a href=\"$url\">$titolo</a> $sep ";
				$c++;
			}
			else{
				$this->breadcrumbs.="<span class=\"current\">$titolo</span>";
			}
		}
		
		$this->breadcrumbs.="\t\t</div>\n";
	}
	

	public function addFile($file, $type=''){
            
            if($type=='js'){
                
                $this->files_js[]=$file;
            }
            else if($type=='css'){
                
                $this->files_css[]=$file;
            }
            else{
            
                if(substr($file,-4,4)==".css" || preg_match("|[\W]+css\??|",$file)){
                        $this->files_css[]=$file;
                }
                elseif(substr($file,-3,3)==".js" || preg_match("|[\W]+js\??|",$file)){
                        $this->files_js[]=$file;
                }
            }
	}
	

	public function sendFeedback($msg, $class="feedback"){

		$feedback="
		<div class=\"$class\">
			<img src=\"/img/light/alert32.png\" alt=\"\" width=\"32\" height=\"32\" />
			<span class=\"feedback-msg\">$msg</span>
		</div>
		";

		return $feedback;
	}
	
	
	public function addNamespaces($str){

		$this->namespaces=$str;
	}

	 /**
	 * Scrive l'HTML di apertura di una pagina
	 *
	 * @param string $addHTML
	 * @return string HTML
	 */
	public function openLayout1($addHTML=true){

		global $link;
		
		$files=$this->files;

		$GLOBALS['layout_APERTO']=1;

		$css = array();
		$js  = array();
                
		
		$DOCTYPES=array(
		"HTML 4.01 Strict"=>"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">",
		"HTML 4.01 Transitional"=>"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">",
		"HTML 4.01 Frameset"=>"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">",
		"XHTML 1.0 Strict"=>"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">",
		"XHTML 1.0 Transitional"=>"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">",
		"XHTML 1.0 Frameset"=>"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">",
		"XHTML 1.1"=>"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">",
		"HTML 5.0"=>"<!DOCTYPE html>",
		);


		$OUT= "{$DOCTYPES[$this->doctype]}
<html xmlns=\"http://www.w3.org/1999/xhtml\" {$this->namespaces} xml:lang=\"{$this->lang}\" lang=\"{$this->lang}\" >
<head>
<title>{$this->title}</title>
<meta http-equiv=\"content-type\" content=\"text/html; charset={$this->charset}\"/>\n";
		
	
		$OUT.=$this->meta;
		

        if(count($this->custom_css)>0){
			
			for($i=0;$i<count($this->custom_css);$i++){
                            
                            if(preg_match("|^http|",$this->custom_css[$i][0]))
                                $OUT.="<link href=\"".$this->custom_css[$i][0]."\" rel=\"stylesheet\" type=\"text/css\" media=\"".$this->custom_css[$i][1]."\" title=\"default\" />\n";

                            else
				$OUT.="<link href=\"".FRONT_DOCROOT."/".$this->custom_css[$i][0]."\" rel=\"stylesheet\" type=\"text/css\" media=\"".$this->custom_css[$i][1]."\" title=\"default\" />\n";
			}
		}
                
                # CSS DEAFALT
		foreach($this->default_css as $cssd){
			$OUT.= "<link href=\"".FRONT_DOCROOT."/$cssd\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" title=\"default\" />\n";
		}

		# CSS
		foreach($this->files_css as $css){
			$OUT.= "<link href=\"".FRONT_DOCROOT."/$css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" title=\"default\" />\n";
		}

	

		
		# JS DEFAULT
		foreach($this->default_js as $jsd){
				
			if(preg_match("!^http!",$jsd)){
				$OUT.= "<script type=\"text/javascript\" src=\"$jsd\" ></script>\n";
			}
			else{
				$OUT.= "<script type=\"text/javascript\" src=\"".FRONT_DOCROOT."/$jsd\" ></script>\n";
			}
		}
		
		
		# JS
		//if(count($js)>0){

                foreach($this->files_js as $js){

                        if(!in_array($js,$this->default_js)){

                                if(preg_match("!^http!",$js)){
                                        $OUT.= "<script type=\"text/javascript\" src=\"$js\" ></script>\n";
                                }
                                else{
                                        $OUT.= "<script type=\"text/javascript\" src=\"".FRONT_DOCROOT."/$js\" ></script>\n";
                                }
                        }
                }

		if($this->custom_js!=''){
			
			$OUT.="<script type=\"text/javascript\">\n// <!-- \n".$this->custom_js."\n// -->\n</script>\n";
		}
		
		$OUT.=$this->custom_head_code;

		$OUT.= "</head>\n<body>\n";

		$title_h1 = ($this->h1 == '') ? '' : "\n<h1>".$this->h1."</h1>\n";
		

		$OUT.= $this->header_html . $title_h1;
	
		if($addHTML){

		    $this->HTML .=$OUT;
		}
		else
		    return $OUT;
	}




	
	
	/**
	 * Scrive l'HTML di chiusura di una pagina
	 *
	 * @param mixed $back
	 * @return string HTML
	 */
	public function closeLayout1($addHTML=true){

		
	    $OUTPUT_CLOSE=$this->footer_html;

	    $OUTPUT_CLOSE.="\n</body>\n</html>";

	    if($addHTML){
		    $this->HTML .=$OUTPUT_CLOSE;
	    }
	    else return $OUTPUT_CLOSE;
	}


	public function echoLayout($print=false){

	    if($print) {

			$this->HTML.=$this->closeLayout1();
			echo $this->HTML;
		}
	    else{
			return $this->HTML;
	    }
	}

	/*
	public function panic($errorn=0){

		@ob_end_clean();

		header("Location:".FRONT_DOCROOT."/p/errore/?dett=$errorn");
		exit;
	}
	*/
}









/**
 *  Public files Layout
 */
class Lay extends __Layout {

    public $is_home=false;

    public $meta_description='';

    public $spalla_dx=true;
    
    public $add_LI='';

    function  __construct() {
	
        // $this->doctype='HTML 5.0';
        
	$this->lang='en';
	
	$this->default_css=array("sty/default.css", "sty/dae.css");
	
	$this->footer_html="</div>\n";
	
	$this->meta_description="Mid-Term Evaluation of the eGovernment Action Plan";
	$this->keywords="DAE, Digital Agenda, Europe, implementation, Actions, Member States";

	parent::__construct();

    }

    
    public function openLayout1($addHTML = true) {
	
	
	$logged_as = (isset($_SESSION['user'])) ?
		    "<div class=\"logged-as\">Logged as: ".$_SESSION['user']['first_name']
		    ." ".$_SESSION['user']['last_name']
		    // ." - <a href=\"".FRONT_DOCROOT."/logout.php\">logout</a>"
		    ."</div>"
		    : '';
	
	
	$this->title.=" - Mid-Term Evaluation of the eGovernment Action Plan";
	
	$add_LI=$this->add_LI;
	
	$this->addMeta('<meta name="description" content="'.$this->meta_description.'" />');
	$this->addMeta('<meta name="keywords" content="'.$this->keywords.'" />');

	$this->header_html="
	
	<div class=\"yui3-u-1\">
	    <div id=\"header\">
		    <img alt=\"EU Logo\" class=\"euFlag\" src=\"".FRONT_DOCROOT."/img/logo_en.gif\" width=\"172\" height=\"119\" />
		    <p class=\"off-screen\" id=\"banner-title-text\">European Commission<br />
			<span id=\"banner-site-name\">Mid-Term Evaluation of the eGovernment Action Plan</span>
		    </p>
		    <div class=\"title-en\" id=\"banner-image-title\">Mid-Term Evaluation of the eGovernment Action Plan</div>
		    <div class=\"subtitle-en\" id=\"banner-image-subtitle\">Actions under the responsibility of the Commission and the Member States</div>
		    <p class=\"off-screen\">Service tools</p>
		    <ul class=\"reset-list\" id=\"services\">
			    <li><a class=\"first\" href=\"http://ec.europa.eu:80/information_society/index_en.htm\">Information 
			    Society</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/help/legal/index_en.htm\">Legal notice</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/help/contact/index_en.htm\">Contact</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/newsroom/cf/rss-list.cfm\">RSS</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/newsroom/cf/menu.cfm\">Newsroom</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/services/a2z/index_en.htm\">A-Z index</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/help/contact/index_en.htm\">Contact</a></li>
			    <li><a href=\"http://ec.europa.eu:80/information_society/services/sitemap/index_en.htm\">Sitemap</a></li>
		    </ul>

		
		</div>
		<div id=\"path\">
			<p class=\"off-screen\">Navigation path</p>
			<ul class=\"reset-list\">
			    <li class=\"first\"><a href=\"http://ec.europa.eu/index_en.htm\">European Commission</a></li>
			    <li><a href=\"http://ec.europa.eu/digital-agenda/en\">Digital Agenda for Europe</a></li>
			    <li><a href=\"http://ec.europa.eu/digital-agenda/en/digital-life\" title=\"Digital Life\" class=\"\">Digital Life</a></li>
			    <li><a href=\"http://ec.europa.eu/digital-agenda/en/digital-life/government\" title=\"Government\" class=\"\">Government</a></li>
			    <li><a href=\"http://ec.europa.eu/digital-agenda/en/ict-public-services\" title=\"ICT for Public Services\" class=\"\">ICT for Public Services</a></li>
			    <!--<li><a href=\"".FRONT_DOCROOT."/\">Pledges</a></li>-->
				$add_LI
			</ul>
		</div>
	    </div>


	<div class=\"container0\">\n";
	
	$this->footer_html="\n</div>\n<div id=\"footer\"></div>\n";
	
	parent::openLayout1($addHTML);
    }
    
    
    public function closeLayout1($addHTML = true) {
	parent::closeLayout1($addHTML);
    }
	
    public function areaTabs($action_n=0, $id_country=0, $skip_general=false, $force_type=''){
	
	// DEFAULT VALUES
	// if($action_n==0) $action_n = DEFAULT_ACTION_N;
	if($id_country==0) $id_country = DEFAULT_ID_COUNTRY;
	
	
	$Pillar = new Pillar();
	
	$areas=$Pillar->listArea();

	// AREA ---------------------------------------------------------------

	

	$UL_AREA="<div class=\"oriz-container\"><ul class=\"ul-pillars\">\n";
         
        // MS normal
        if($id_country!=COUNTRY_EC && !$skip_general){
            
            $type='ms';
            
            if($action_n==0 ){
                $UL_AREA.="<li class=\"active\">General information</li>\n";
            }
            else{

               $UL_AREA.="<li><a href=\"?action_n=0&amp;id_country=".$id_country."\" title=\"General information\">General informations</a></li>\n"; 
               $area_info=$Pillar->getAreaFromAction($action_n);
            }
       } 
       
       // EC
       else{
           
           $type='ec';
           $area_info=$Pillar->getAreaFromAction($action_n);
       }
       
       if($force_type=='ms' || $force_type=='ec'){
           $type=$force_type;
       }
       
       print "<!-- Type: $type -->\n";
        
	foreach($areas as $area){
            

	    $first_action=$Pillar->getFirstAction($area['id_area'], $type);

	    if(isset($area_info['id_area']) && $area_info['id_area']==$area['id_area']){
		$UL_AREA.="<li class=\"active\">".$area['id_area']." ".$area['label']."</li>\n";
	    }
	    else{
		$UL_AREA.="<li><a href=\"?action_n=".$first_action['action_n']."&amp;id_country=".$id_country."\" title=\"".$area['area']."\">".$area['id_area']." ". $area['label']."</a></li>\n";
	    }
	}
	$UL_AREA.="</ul></div>\n";
	
	return $UL_AREA;
    }
    
    
    	
    public function pillarTabsByIdPillar($id_area=0, $id_country=0){
	
	// DEFAULT VALUES
	if($id_area==0) $id_pillar = DEFAULT_ID_AREA;
	if($id_country==0) $id_country = DEFAULT_ID_COUNTRY;
	
	$Pillar = new Pillar();
	
	$pillars=$Pillar->listArea();

	// PILLARS ---------------------------------------------------------------

	$UL_PILLAR="<div class=\"oriz-container\"><ul class=\"ul-pillars\">\n";

	foreach($pillars as $pillar){

	    if($id_area==$pillar['id_area']){
		$UL_PILLAR.="<li class=\"active\">".$pillar['area']."</li>\n";
	    }
	    else{
		$UL_PILLAR.="<li><a href=\"?id_area=".$pillar['id_area']."&amp;id_country=".$id_country."\">".$pillar['label']."</a></li>\n";
	    }
	}
	$UL_PILLAR.="</ul></div>\n";
	
	return $UL_PILLAR;
    }
    
    
    public function actionTabs($action_n=0, $id_country=0, $class='vert-container', $class_ul='ul-actions'){
	
        // FORM TYPE
        if($id_country==COUNTRY_EC){
            $type='ec';
        }
        else{
            $type='ms';
        }
        
	// DEFAULT VALUES
        if($id_country==COUNTRY_EC && $action_n==0){
            
            $action_n=Pillar::getFirstActionId(DEFAULT_ID_AREA, $type);
        }
        else{
            
        }
        
        
	if($id_country==0) $id_country = DEFAULT_ID_COUNTRY;
	
	$Pillar = new Pillar();
        
	$pillar_info=$Pillar->getAreaFromAction($action_n);
	
	$actions=$Pillar->listActions($pillar_info['id_area'], $type);

	$UL_ACTION="<div class=\"$class\"><ul class=\"$class_ul\">\n";

	foreach($actions as $action){

	    if($action['action_n']==$action_n) {
		$UL_ACTION.="<li class=\"active\">Action ".$action['action_n']."</li>\n";
	    }
	    else{
		$UL_ACTION.="<li><a href=\"?action_n=".$action['action_n']."&amp;id_country=".$id_country."\">Action ".$action['action_n']."</a></li>\n";
	    }
	}

	$UL_ACTION.="</ul></div>\n";
	
	return $UL_ACTION;
    }
    
    
     public function countryTabs($action_n=0, $id_country=0, $class='vert-container', $class_ul='ul-countries'){
	
	if(!class_exists('MSRead')){
	    require_once(FRONT_ROOT."/inc/class.msread.php");
	}
	
	// DEFAULT VALUES
	if($action_n==0) $action_n = DEFAULT_ACTION_N;
	if($id_country==0) $id_country = DEFAULT_ID_COUNTRY;
	
	
	$UL_COUNTRIES="<div class=\"$class\"><ul class=\"$class_ul\">\n";
	
	
	$MSRead = new MSRead();
	$countries=$MSRead->getCountries();

	foreach($countries as $country){
            
            if($country['id_country']==COUNTRY_EC) continue;
	    
	    if($country['id_country']==$id_country) {
		$UL_COUNTRIES.="<li class=\"active\">".$country['country']."</li>\n";
	    }
	    else{
		$UL_COUNTRIES.="<li><a href=\"?action_n=".$action_n."&amp;id_country=".$country['id_country']."\">".$country['country']."</a></li>\n";
	    }
	}

	$UL_COUNTRIES.="</ul></div>\n";
	
	return $UL_COUNTRIES;
    }

    
    public function global_nav($active=''){
	
	$out='';
	
	$pages=array();
	
	$pages['Home']= FRONT_DOCROOT.'/';
	
	// if(isset($_SESSION['user'])){
	    $pages['Dashboard']= FRONT_DOCROOT.'/dashboard2.php';
	    $pages['Action Dashboard']= FRONT_DOCROOT.'/dashboard2_actions.php';
	// }
	$pages['European Commission Actions']= FRONT_DOCROOT.'/ec_actions.php';
	$pages['Member States Actions']= FRONT_DOCROOT.'/ms_actions.php';
	//$pages['DAE Actions']= FRONT_DOCROOT.'/dae_actions.php';
	$pages['Member States']= FRONT_DOCROOT.'/member_states.php';
	//$pages['Best Practices']= FRONT_DOCROOT.'/best_practices.php';
	$pages['About']= FRONT_DOCROOT.'/about.php';
	$pages['Help']= FRONT_DOCROOT.'/help.php';
	$pages['Contacts']= FRONT_DOCROOT.'/contacts.php';
	
	if(!isset($_SESSION['user'])){
	    $pages['Login']= FRONT_DOCROOT.'/login.php';
	}
	else{
	    $pages['Online forms']= FRONT_DOCROOT.'/backoffice/list.php';
	    $pages['Logout']= FRONT_DOCROOT.'/logout.php';
	}
	
	$out.="<div id=\"global-nav\">\n";
	
	foreach($pages as $title=>$url){
	    
	    if($active==$title){
		$out.="<span class=\"active\">".$title."</span> | ";
	    }
	    else{
		$out.="<a href=\"".$url."\">".$title."</a> | ";
	    }
	}
	
	$out=substr($out,0, -2);
	
	$out.="</div>\n";
	
	return $out;
	
    }

}