<?php

    $tot_filled = $tot_tot = 0;

?><h2>Summary <span class="gray">in <?php echo $this->country['country'];?></span></h2>

<table class="table table-striped table-bordered">
    
    <thead>
        <tr>
            <th>Priority</th>
            <th>Indicators filled</th>
            <th>Total of indicators</th>
            <th>% Completed</td>
        </tr>
    </thead>
    
  <?php foreach($this->vars['stats'] as $s): 
  
      $tot_filled+= $s['filled'];
      $tot_tot+= $s['tot'];
      
      $s_perc = round($s['filled'] / $s['tot'] * 100);
      $s_tot_perc = round($tot_filled / $tot_tot * 100);
      
  ?>
    <tr>
        <td><a href="<?php echo FRONT_DOCROOT."/members/indicators?id_priority=".$s['id_area']; ?>"><?php print $s['id_area']. " - " . $s['label'];?></a></td>
        <td><?php echo $s['filled'];?></td>
        <td><?php echo $s['tot'];?></td>
        <td>
            <div class="progress">
                <div class="progress-bar " role="progressbar" aria-valuenow="<?php echo $s_perc;?>" 
                     aria-valuemin="" aria-valuemax="100" style="width: <?php echo $s_perc;?>%;">
                  <span><?php echo $s_perc;?>%</span>
                </div>
              </div>
        </td>
    </tr>
  <?php endforeach; ?>
    
    <tr>
        <td><strong>Total</strong></td>
        <td><strong><?php echo $tot_filled;?></strong></td>
        <td><strong><?php echo $tot_tot;?></strong></td>
        <td>
            <div class="progress">
                <div class="progress-bar " role="progressbar" aria-valuenow="<?php echo $s_tot_perc;?>" 
                     aria-valuemin="" aria-valuemax="100" style="width: <?php echo $s_tot_perc;?>%;">
                  <span><?php echo $s_tot_perc;?>%</span>
                </div>
              </div>
        </td>
    </tr>
    
</table>
  
<form id="country-summary" method="post" action="">
  <div class="row-fluid">
      <div>
        <label for="summary">Introduction of the country page:</label><br />
        <textarea name="summary" id="summary"  class="form-control" rows="5" ><?php echo $this->country['summary'];?></textarea>
        <br />
      </div>
      <div class="aright">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
  </div>
</form>
