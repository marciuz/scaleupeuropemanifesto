<?php

    $acopy = $this->dtable_1;
    $first_key = key($acopy);
    unset($acopy);
    
    $countries_all = array_values($this->dtable_1[$first_key]);
    $countries = array_keys($countries_all[0]);
    unset($countries_all);
    
    $n_cols = count($countries) + 1;
    
?>

<section id="intro-text">
    <p>An interactive dashboard shows how concrete policies and actions are being implemented in all 28 European Union member states.
    <br />Click on a selected country field for detailed list of indicators and their progress.</p>
</section>


<section id="dashboard-legenda" class="row">
    <div class="col-xs-12 col-sm-6">
        <h3>Legend</h3>
        <div class="row-legenda"><div class="sq-legenda color-0"></div> <?php echo $this->vars['legend_labels'][0];?></div>
        <div class="row-legenda"><div class="sq-legenda color-1"></div> <?php echo $this->vars['legend_labels'][1];?></div>
        <div class="row-legenda"><div class="sq-legenda color-2"></div> <?php echo $this->vars['legend_labels'][2];?></div>
        <div class="row-legenda"><div class="sq-legenda color-3"></div> <?php echo $this->vars['legend_labels'][3];?></div>
    </div>
    <div class="col-xs-6 col-md-6">
        <h3>Export data</h3>
        <p><small>The data are available under a <a href="https://creativecommons.org/licenses/by/4.0/">CC-BY License</a></small></p>
        <div class="row-legenda"><i class="fa fa-file-text-o"></i>&nbsp; <a href="export?ft=csv">File CSV </a></div>
        <div class="row-legenda"><i class="fa fa-file-code-o"></i>&nbsp;  <a href="export?ft=xml">File XML </a></div>
        <div class="row-legenda"><i class="fa fa-file-o"></i>&nbsp;  <a href="export?ft=json">File JSON </a></div>
    </div>
</section>


<section id="table">
    <table class="dsh">
        <thead>
            <tr>
                <th class="blank">&nbsp;</th>
                <th class="th1">Priority / Action</th>
                <?php foreach($countries as $abbr): ?>
                <th class="thc<?php echo (in_array($abbr, array('EC', '_S', '_E', 'SUP', 'ECO'))) ? ' thc-special' : '';?>">
                    <div title="<?php echo $this->co[$abbr];?>" data-abbr="<?php echo $abbr;?>" data-toggle="tooltip"><?php echo $abbr;?></div>
                </th>
                <?php endforeach; ?>
            </tr>

        </thead>

            <?php foreach($this->dtable_1 as $id_priority => $table): ?>
            
            <tbody id="s<?php echo $id_priority;?>" class="t-sect">

            <tr class="sep" id="tsep-<?php echo $id_priority;?>">
                <?php for($i=0;$i<=$n_cols;$i++): ?>
                <th></th>
                <?php endfor; ?>
            </tr>

            <tr>
                <th class="blank">&nbsp;</th>
                <th class="th-priority" colspan="<?php echo ($n_cols -2);?>"><?php echo $this->priorities[$id_priority];?></th>
                <th class="th-priority toright" colspan="2"><i class="fa fa-chevron-down"></i></th>
            </tr>

                <?php foreach($table as $action_n => $arr): 
                    $numer_action = $this->anumbers[$action_n];
                    $action_name = ($numer_action != '') ? "Action ". $numer_action : 'Institutional Framework'; ?>
                <tr class="r">
                    <td class="action-n"><?php echo ($numer_action != '') ? $numer_action : '' ;?></td>
                    <td class="action-label">
                        <div class="info-icon"><a tabindex="0" data-toggle="popover" data-poload="info?action_n=<?php echo $action_n;?>" data-trigger="focus" ><i class="fa fa-info-circle"></i></a></div> 
                        <div class="action-text" title="<?php echo $this->actions[$action_n];?>"><?php echo $this->actions[$action_n];?></div>
                        
                    </td>

                    <?php foreach($arr as $abbr=>$value): ?>
                    <td class="tdd <?php echo 'cl'.$value;?>" data-val="<?php echo $value;?>" data-c="<?php echo $abbr;?>" data-a="<?php echo $action_n;?>" >
                        <div class="ic" title="<?php echo $action_name;?> by <?php echo $this->co[$abbr];?>" data-toggle="tooltip" />
                    </td>
                    <?php endforeach; ?>

                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endforeach; ?>

    </table>
</section>