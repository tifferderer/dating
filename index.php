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

        // GENDER HAS NOT BEEN SET IN THE SESSION NOR HAS IT BEEN VALIDATED!!!!

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

        //if there are no errors, redirect to order2
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
$f3->route('GET|POST /profile', function () {
    //var_dump($_POST);
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
    //var_dump($_POST);
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
    //var_dump($_POST);
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