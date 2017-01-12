<?php


?><!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo FRONT_DOCROOT;?>/members/">Scale Up Manifesto <span class="secline">Policy Tracker</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class=""><a href="<?php echo FRONT_DOCROOT;?>/members/">Summary</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Priorities <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                  
                <?php foreach($this->vars['pr'] as $p): ?>
                
                    <li><a href="<?php echo FRONT_DOCROOT."/members/indicators?id_priority=".$p->id_area; ?>"><?php print $p->id_area . " - " . $p->label;?></a></li>
                
                <?php endforeach; ?>
                  
              </ul>
            </li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(isset($this->vars['is_admin'])): ?>
              <li><a href="<?php echo FRONT_DOCROOT;?>/members/select_country"><i class="fa fa-globe"></i> Change country (<?php echo country_name();?>)</a></li>
            <?php endif; ?>
            <!--<li><a href="<?php echo FRONT_DOCROOT;?>/members/help"><i class="fa fa-life-ring"></i> Help</a></li>-->
            <li><a href="<?php echo FRONT_DOCROOT;?>/members/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
