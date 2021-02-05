<?php

//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload file
require_once('vendor/autoload.php');

//Create an instance of Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//define a default route(home page)
$f3->route('GET /', function() {
    //echo "Hello";
    $view = new Template();
    echo $view->render('views/home.html');
});

//define an personal information route
$f3->route('GET /register', function () {
    $view = new Template();
    echo $view->render('views/personal-form.html');
});

//define profile form route
$f3->route('POST /profile', function () {
    $view = new Template();
    echo $view->render('views/profile-form.html');
});

//define an interests form route
$f3->route('POST /interests', function () {
    $view = new Template();
    echo $view->render('views/interests-form.html');
});

//define profile summary route
$f3->route('GET /summary', function () {
    $view = new Template();
    echo $view->render('views/summary.html');
});


//run fat free
$f3->run();