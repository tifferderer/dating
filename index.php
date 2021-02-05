<?php

//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

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
    var_dump($_POST);
    if(isset($_POST['fname'])) {
        $_SESSION['fname'] = $_POST['fname'];
    }
    if(isset($_POST['lname'])) {
        $_SESSION['lname'] = $_POST['lname'];
    }
    if(isset($_POST['phone'])) {
        $_SESSION['phone'] = $_POST['phone'];
    }
    if(isset($_POST['pname'])) {
        $_SESSION['pname'] = $_POST['pname'];
    }
    if(isset($_POST['age'])) {
        $_SESSION['age'] = $_POST['age'];
    }
    if(isset($_POST['gender'])) {
        $_SESSION['gender'] = $_POST['gender'];
    }
    $view = new Template();
    echo $view->render('views/profile-form.html');
});

//define an interests form route
$f3->route('POST /interests', function () {
    var_dump($_POST);
    if(isset($_POST['email'])) {
        $_SESSION['email'] = $_POST['email'];
    }
    if(isset($_POST['state'])) {
        $_SESSION['state'] = $_POST['state'];
    }
    if(isset($_POST['seeking'])) {
        $_SESSION['seeking'] = $_POST['seeking'];
    }
    if(isset($_POST['bio'])) {
        $_SESSION['bio'] = $_POST['bio'];
    }
    $view = new Template();
    echo $view->render('views/interests-form.html');
});

//define profile summary route
$f3->route('POST /summary', function () {
    var_dump($_POST);
    if(isset($_POST['indoor'])) {
        $_SESSION['indoor'] = implode(" ", $_POST['indoor']);
    }
    if(isset($_POST['outdoor'])) {
        $_SESSION['outdoor'] = implode(" ", $_POST['outdoor']);
    }
    $view = new Template();
    echo $view->render('views/summary.html');
});

//run fat free
$f3->run();