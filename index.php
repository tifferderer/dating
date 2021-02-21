<?php
//Tiffany Ferderer
//version 2.0
//index.php

//This is my CONTROLLER

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//require the autoload file
require_once('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validate.php');

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
$f3->route('GET|POST /register', function ($f3) {

    //if the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get data from post array
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $phone = trim($_POST['phone']);
        $pname= trim($_POST['pname']);
        $age = trim($_POST['age']);

        //Validate
        if(validName($fname)) {
            $_SESSION['fname'] = $fname;
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["fname"]',"First name cannot be blank.");
        }
        if(validName($lname)) {
            $_SESSION['lname'] = $lname;
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["lname"]',"Last name cannot be blank.");
        }
        if(validPhone($phone)) {
            $_SESSION['phone'] = $phone;
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["phone"]',"Please type a valid phone number.");
        }
        if(validName($pname)) {
            $_SESSION['pname'] = $pname;
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["pname"]',"Pet name cannot be blank.");
        }
        if(validAge($age)) {
            $_SESSION['age'] = $age;
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["age"]',"Age must be in the range of 18-118.");
        }

        if(isset($_POST['gender'])) {

            $userGender = $_POST['gender'];

            if(validGender($userGender)) {
                $_SESSION['userGender'] = $userGender;
            }
            else{
                $f3->set('errors["gender"]', "Please select a gender.");
            }
        }

        //if there are no errors, redirect
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile');  //get
        }
    }

    $f3->set('genders', getGender());
    $f3->set('fname', isset($fname) ? $fname : "");
    $f3->set('lname', isset($lname) ? $lname : "");
    $f3->set('phone', isset($phone) ? $phone : "");
    $f3->set('pname', isset($pname) ? $pname : "");
    $f3->set('age', isset($age) ? $age : "");
    $f3->set('userGender', isset($userGender) ? $userGender : "");

    $view = new Template();
    echo $view->render('views/personal-form.html');
});

//define profile form route
$f3->route('GET|POST /profile', function ($f3) {

    //STATE IS NOT VALIDATED NOR STICKY *****************

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get required data
        $email = trim($_POST['email']);

        if (validEmail($email)) {
            $_SESSION['email'] = $email;
        } else {
            $f3->set('errors["email"]', "Email required.");
        }

        //get optional data
        if (isset($_POST['seeking'])) {

            $seeking = $_POST['seeking'];

            if (validGender($seeking)) {
                $_SESSION['seeking'] = $seeking;
            } else {
                $f3->set('errors["seeking"]', "Please select a gender.");
            }
        }

        if (isset($_POST['state'])) {

            $userState = $_POST['state'];

            if (validState($userState)) {
                $_SESSION['userState'] = $userState;
            } else {
                $f3->set('errors["state"]', "Please select a valid state.");
            }
        }

        if (isset($_POST['bio'])) {

            $bio = trim($_POST['bio']);

            if (!empty($bio)) {
                $_SESSION['bio'] = $bio;
            }
        }

        //if there are no errors, redirect
        if (empty($f3->get('errors'))) {
            $f3->reroute('/interests');  //get
        }
    }

    $f3->set('seekings', getGender());
    $f3->set('states', getStates());

    $f3->set('email', isset($email) ? $email : "");
    $f3->set('seeking', isset($seeking) ? $seeking : "");
    $f3->set('userState', isset($userState) ? $userState : "");
    $f3->set('bio', isset($bio) ? $bio : "");

    $view = new Template();
    echo $view->render('views/profile-form.html');
});

//define an interests form route
$f3->route('GET|POST /interests', function () {

    $view = new Template();
    echo $view->render('views/interests-form.html');
});

//define profile summary route
$f3->route('POST /summary', function () {

    $view = new Template();
    echo $view->render('views/summary.html');
});

//run fat free
$f3->run();