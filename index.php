<?php
//Tiffany Ferderer
//version 2.0
//index.php

//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload file
require_once('vendor/autoload.php');

//Start a session
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

//Create an instance of Base class
$f3 = Base::instance();
$validator = new PValidate();
$dataLayer = new PDataLayer();
$controller = new PController($f3);
$database = new PDatabase();

$f3->set('DEBUG', 3);

//define a default route(home page)
$f3->route('GET /', function() {
   global $controller;
   $controller->home();
});

//define an personal information route
$f3->route('GET|POST /register', function ($f3) {
    global $controller;
    $controller->register();
});

//define profile form route
$f3->route('GET|POST /profile', function ($f3) {
    global $controller;
    $controller->profile();
});

//define an interests form route
$f3->route('GET|POST /interests', function ($f3) {
   global $controller;
   $controller->interests();
});

//define profile summary route
$f3->route('GET /summary', function () {
    global $controller;
    $controller->summary();
});

$f3->route('GET /admin', function () {
    global $controller;
    $controller->admin();
});

//run fat free
$f3->run();