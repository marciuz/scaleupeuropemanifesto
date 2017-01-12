<?php

$V = new View_Private();

$V->__set('body', $V->render('help'));
$html = $V->render('html_private');

print $html;


/*
$template = $twig->loadTemplate('help.phtml');

$params = array(
    'first_name' => $_SESSION['user']['first_name'],
    'last_name' => $_SESSION['user']['last_name'],
);

$template->display($params);
*/
