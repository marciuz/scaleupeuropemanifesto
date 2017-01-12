<h2>Select the country: </h2>
<p>With your account you can manage data for more than one country. Select the country you want to work on.</p>

<ul>
    <?php foreach($this->vars['cnts'] as $co): ?>
    <li class="country-selector">
        <img src="../assets/img/plain_eu/<?php print $co['abbr'];?>.png" alt="<?php echo $co['country'];?>" /> 
        <a href="?id_country=<?php echo $co['id_country'];?>"><?php echo $co['country'];?></a>
    </li>
    <?php endforeach; ?>
</ul>