<?php
/**
 * Questo file è in uso?
 * Sembra di no... 
 */


$action_title = ($this->action['action_n'] > 0) ? "Action zzz". ($this->anumbers['action_n']) : 'Institutional Framework';

?>
<section id="intro-text">
    <p>To track progress in the implementation of other priorities and actions across countries – return to <a href="../dashboard">Dashboard page</a></p>
    <p>The Scale Up Manifesto Policy Tracker is a dynamic tool, open to 
        suggestions for improvement and external contributions. If you would 
        like to share with us a country or regional initiative which you believe 
        should be included in this survey, please leave your comment below.</p>

</section>

<h3 class="detail-h"><?php echo $action_title;?> in <span><?php echo $this->country['country'];?></span></h3>
<div class="citation">&#8220;<?php echo $this->action['action'];?>&#8221;</div>
<table class="ddetail">
    <tr>
        <th>Number</th>
        <th>Indicator</th>
        <th>Completed</th>
        <th>Evidence</th>
    </tr>
    
    <?php foreach ($this->indicators as $ind): ?>
    <tr>
        <td class="t-number"><?php echo $ind->ind_label;?></td>
        <td class="t-indicator"><?php echo $ind->indicator;?></td>
        <td class="t-response"><?php echo Data_Structure::response($ind->_data['presence']);?></td>
        <td class="t-evidence"><?php echo $ind->_data['evidence'];?></td>
    </tr>
    <?php endforeach; ?>
    
</table>



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