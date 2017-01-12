<section id="intro-text">
    The progress of implementation of Scale Up Manifesto is being monitored by a group of experts from 28 European countries.
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

