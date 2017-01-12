<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->vars['title']; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" >
    <link href="<?php echo FRONT_DOCROOT."/"; ?>assets/css/base.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      
      <?php echo $this->vars['navbar']; ?>
      
      <div class="container">
          
        <?php echo $this->vars['h1']; ?>
        
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
                </div>
            </div>
            
        </footer>
      </div>
      
      
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?php echo FRONT_DOCROOT."/"; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo FRONT_DOCROOT."/"; ?>assets/js/general.js"></script>
    <?php
        echo $this->render_js('footer');
    ?>
  </body>
</html>
