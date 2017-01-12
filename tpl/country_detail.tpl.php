<h2 class="detail-h">Track progress in <span><?php echo $this->country['country'];?></span></h2>

<section id="intro-text">
    <h4>Summary</h4>
    <p><?php echo $this->country['summary'];?></p>
    <hr />
    <p>To track progress in the implementation of other priorities and actions across countries – visit the interactive <a href="../dashboard">Dashboard page</a></p>
    <p>The Scale Up Manifesto Policy Tracker is a dynamic tool, open to 
        suggestions for improvement and external contributions. If you would 
        like to share with us a country or regional initiative which you believe 
        should be included in this survey, please leave your comment below.</p>
</section>
<hr />

<section>
    
    <span class="expand-all fakelink">Expand all</span> | 
    <span class="collapse-all fakelink">Collapse all</span>
</section>

<?php

$id_area='';

for($i=0;$i<count($this->a_indicators); $i++): 
    
    if($id_area == null || $this->action[$i]['id_area']!=$id_area){
        
        
        // cicli diversi dal primo
        if($i>0): ?>
        </div></section>
        <?php endif;?>
        
        <section id="area-<?php echo $this->action[$i]['id_area'];?>">
            <h3 class="detail-h trigger-area"><?php echo $this->action[$i]['area'];?></h3>
            <div class="area-container" >
        
        <?php
        
        $id_area = $this->action[$i]['id_area'];
    }
    
    $indicators = $this->a_indicators[$i];
    $this->a = $this->action[$i];

    $action_title = ($this->a['action_n'] > 0) ? "Action ". $this->a['number'] : 'Institutional Framework';

    $class_id_open = ($this->a['action_n'] == $this->id) ? 'open_id' : '';
    $icon_open = ($this->a['action_n'] == $this->id) ? 'fa-minus-square' : 'fa-plus-square';
    
    ?>
    
    <h4 id="act-<?php echo $this->a['action_n'];?>" class="detail-h fakelink-over"><i class="fa <?php echo $icon_open;?> icon-title"></i> <?php echo $action_title;?> in <span><?php echo $this->country['country'];?></span></h4>
    <div class="citation">&#8220;<?php echo $this->a['action'];?>&#8221;</div>
    <?php if( count($indicators) > 0 ) : ?>
    <table class="ddetail <?php echo $class_id_open;?>" >
        <tr>
            <th style="width:5%">Number</th>
            <th style="width:42%">Indicator</th>
            <th style="width:5%">Completed</th>
            <th style="width:48%">Evidence</th>
        </tr>

        <?php foreach ($indicators as $ind): ?>
        <tr>
            <td class="t-number"><?php echo $ind->ind_label;?></td>
            <td class="t-indicator"><?php echo $ind->indicator;?></td>
            <td class="t-response"><?php echo Data_Structure::response($ind->_data['presence']);?></td>
            <td class="t-evidence"><?php echo $ind->_data['evidence'];?></td>
        </tr>
        <?php endforeach; ?>

    </table>
    <?php else : ?>
    <div class="no-indicators">There are no indicators for this action.</div>
    <?php endif; ?>

<?php
endfor;
?>
</div>
</section>
<div id="disqus_thread"></div>
<script type="text/javascript">
    var disqus_shortname = 'startupmanifestopolicytracker';
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>


<?php echo $this->LAST_UPDATES; ?>