<?php

//autoloader
require_once('D:\applications\xampp\phpMyAdmin\vendor\autoload.php');
// Kickstart the framework
$f3 = require('lib/base.php');

//load db
$f3->set('DEBUG', 1);
if ((float) PCRE_VERSION < 7.9)
    trigger_error('PCRE version is out of date');

// setup
$f3->config('app/config.ini');

$f3->set('JS', $f3->UI_EXTRA.'js');
$f3->set('CSS', $f3->UI_EXTRA.'css');
$f3->set('ROOT', $f3->ADRS);
$f3->set('ENCODING', $f3->ENCODING);
$f3->set('LANGUAGE', 'en');
//routes
$f3->config('app/routes.ini');
//force login if user has note logged in and page is not public
if ($f3->get('SESSION.uid') === NULL && !in_array($f3->get('PATH'), $f3->get('public_pages'))) {
    $f3->reroute('/');
    exit;
}


$f3->run();
