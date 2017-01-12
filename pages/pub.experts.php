<?php

$V = new View_Public();

$Exp = new Experts();

$V->__set('class_active', array( 
    null,
    null,
    'active',
    null,
    ));

$exps = $Exp->get_experts();

$V->__set('experts', $exps);
$V->__set('body',$V->render('expert_area'));
print $V->render('html');