<?php

?><section id="intro-text">
    The progress of implementation of Startup Manifesto is being monitored by a group of experts from 28 European countries.
</section>

<hr />

<section id="experts" class="row">
    <?php foreach($this->experts as $expert): ?>
    <div class="expert cols-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="ex-img">
            <img src="<?php echo $expert['picture'];?>" alt="<?php echo $expert['fn'];?>" />
        </div>
        <div class="ex-desc">
            <h3><?php echo $expert['country'];?>, <span><?php echo $expert['fn'];?></span></h3>
            <p><?php echo $expert['title'];?>  at <?php echo $expert['organisation'];?></p>
        </div>

    </div>
    <?php endforeach; ?>
</section>

<!-- 
<section class="row">
    <div class="col-sm-6 col-md-4 col-lg-3" id="exp-login" >
        <form class="form-signin" action="login" method="post">
            <h2 class="form-signin-heading">Expert access</h2>
            <?php if(isset($_GET['feed'])): ?>
            <div class="alert alert-warning"><strong>Authentication error:</strong> please check your email and password</div>
            <?php endif; ?>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" name="passwd" placeholder="Password" required>
            <button class="btn btn-lg btn-edfx1 btn-block" type="submit">Sign in</button>
        </form>
    </div>
</section>
-->

