<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo PROJ_NAME;?> - Expert area</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo FRONT_DOCROOT;?>/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?php echo FRONT_DOCROOT;?>/assets/css/login.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
        
      <form class="form-signin" action="login" method="post">
          
        <div class="centered">
          <a href="<?php echo FRONT_DOCROOT; ?>/"><img src="<?php echo FRONT_DOCROOT; ?>/assets/img/startup-manifesto-logo1.png"  style="max-width: 300px;margin-bottom: 10px"/></a>
          <h2 class="form-signin-heading">Private area</h2>
        </div>
        <?php if(isset($_GET['feed'])): ?>
        <div class="alert alert-warning"><strong>Authentication error:</strong> please check your email and password</div>
        <?php endif; ?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="Password" required>
        <!-- <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo FRONT_DOCROOT; ?>/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
