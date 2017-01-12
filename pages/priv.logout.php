<?php

$Auth = new Auth();
$Auth->logout();

Redirect::toLogin();