<?php

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->vars['title']; ?></title>
    <link rel="icon" type="image/x-icon" href="http://www.europeandigitalforum.eu/templates/edf/images/favicon.ico" />
    <!-- Bootstrap -->
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/font-awesome.min.css" rel="stylesheet" >
    <link href='//fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/public.css" rel="stylesheet">
    <?php echo $this->render_css(); ?>
    <!--[if IE]>
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/ie.css" rel="stylesheet">
    <![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(defined('GOOGLE_ANALYTICS_CODE')) : ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '<?php echo GOOGLE_ANALYTICS_CODE;?>', 'auto');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
    </head>
    <body>
      
      <?php echo $this->vars['navbar']; ?>
      
      <div class="container">
          
          <div class="row">
              <div class="col-md-6">
                <h1><a href="<?php echo FRONT_DOCROOT;?>">Startup Manifesto&nbsp;<span class="beta">beta</span></a></h1>
                <h2>Policy Tracker</h2>
              </div>
              <div class="col-md-6" id="local-nav">
                  <ul class="row-fluid">
                      <li class="<?php echo $this->vars['class_active'][0];?> col-xs-3"><a href="<?php echo FRONT_DOCROOT;?>">Home</a></li>
                      <li class="<?php echo $this->vars['class_active'][1];?> col-xs-3"><a href="<?php echo FRONT_DOCROOT;?>/dashboard">Dashboard</a></li>
                      <li class="<?php echo $this->vars['class_active'][3];?> col-xs-3"><a href="<?php echo FRONT_DOCROOT;?>/countries">Countries</a></li>
                      <?php
                      /* <li class="<?php echo $this->vars['class_active'][2];?> col-xs-3"><a href="<?php echo FRONT_DOCROOT;?>/experts">Experts</a></li> */
                      ?>
                  </ul>
              </div>
          </div>
          
        <?php echo $this->vars['body']; ?>
          
        <hr />
        
        <footer>
            <div class="row" itemscope itemtype="http://schema.org/LocalBusiness">
                <div class="col-sm-4 col-md-3" id="ft-sx">
                    <h4>Contact us</h4>
                    <div>
                        <a itemprop="url" href="http://www.open-evidence.com" class="nolink"><span itemprop="name"><strong>Open Evidence</strong></span></a>
                    </div>
                    <div>
                        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <span itemprop="streetAddress">Rambla del Poblenou, 156</span><br />
                            <span itemprop="postalCode">08018</span> 
                            <span itemprop="addressLocality">Barcelona</span> - <span itemprop="addressCountry">Spain</span>
                        </span>
                    </div>
                    <div><br /></div>
                    <div>Email: <a href="mailto:trackerhelp@open-evidence.com" itemprop="email" class="nolink">trackerhelp@open-evidence.com</a></div>
                    <div>Twitter: @openevidence</div>
                </div>
                <div class="col-sm-8 col-md-9">
                    <div id="ft-dx" >
                    <a href="http://ec.europa.eu/digital-agenda/" title="Digital Agenda for Europe - European Commission"><img id="logo-ec" class="logo-dx-ft" 
                             src="<?php echo FRONT_DOCROOT."/";?>assets/img/logo-ec.png" 
                             alt="European Commission"  title="Digital Agenda for Europe - European Commission"/></a>
                    
                    <a href="http://ec.europa.eu/digital-agenda/about-startup-europe" title="Startup Europe"><img 
                            id="logo-startup" class="logo-dx-ft" src="<?php echo FRONT_DOCROOT."/";?>assets/img/logo-startup-europe.png" 
                             alt="Startup Europe" title="Startup Europe" /></a>
                    
                    <a href="http://www.open-evidence.com" title="Open Evidence"><img itemprop="logo" itemtype="http://schema.org/ImageObject" id="logo-oe" 
                             class="logo-dx-ft" src="<?php echo FRONT_DOCROOT."/";?>assets/img/logo_openevidence_small.png" 
                             alt="Open Evidence" title="Open Evidence" /></a>
                    
                    </div>
                    <div class="link-login"><a href="<?php echo FRONT_DOCROOT;?>/members/login">Private area</a></div>
                </div>
            </div>
            
        </footer>
          
      </div>
      
      
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?php echo FRONT_DOCROOT."/"; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo FRONT_DOCROOT."/"; ?>assets/js/general.js"></script>
    <?php
        echo $this->render_js('footer');
        
    ?>
    <?php if($this->js_scripts_inline != '') : ?>
    <script>
        <?php echo $this->js_scripts_inline; ?>
    </script>
    <?php endif; ?>
  </body>
</html>
