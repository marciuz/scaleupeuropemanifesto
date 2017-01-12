<?php

?><section id="intro-text">
</section>

<hr />

<section id="countries" class="row">
    <?php foreach($this->countries_area as $country): ?>
    <div class="country cols-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="ex-img">
            <a href="country/<?php echo $country['abbr'];?>">
                <img src="<?php echo "assets/img/plain_eu/".$country['abbr'].".png";?>" alt="<?php echo $country['country'];?>" />
            </a>
        </div>
        <div class="ex-desc">
            <h3><a href="country/<?php echo $country['abbr'];?>"><?php echo $country['country'];?></a></h3>
            <p><?php echo (strlen($country['summary'])>0) ? Common::get_excerpt($country['summary'], 145, ' [...]') : ''; ?></p>
        </div>

    </div>
    <?php endforeach; ?>
</section>