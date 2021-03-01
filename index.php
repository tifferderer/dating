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

//Create an instance of Base class
$f3 = Base::instance();
$validator = new PValidate();
$dataLayer = new PDataLayer();
$member = new Member();


$f3->set('DEBUG', 3);

//define a default route(home page)
$f3->route('GET /', function() {
    //echo "Hello";
    $view = new Template();
    echo $view->render('views/home.html');
});

//define an personal information route
$f3->route('GET|POST /register', function ($f3) {

    global $validator;
    global $dataLayer;
    global $member;

    //if the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get data from post array
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $phone = trim($_POST['phone']);
        $pname= trim($_POST['pname']);
        $age = trim($_POST['age']);
        $premium = ($_POST['premium']);

        //Validate
        if($validator->validName($fname)) {
            $member->setFname($fname);
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["fname"]',"First name cannot be blank.");
        }
        if($validator->validName($lname)) {
            $member->setLname($lname);
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["lname"]',"Last name cannot be blank.");
        }
        if($validator->validPhone($phone)) {
            $member->setPhone($phone);
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["phone"]',"Please type a valid phone number.");
        }
        if($validator->validName($pname)) {
            $member->setPname($pname);
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["pname"]',"Required. Please no spaces");
        }
        if($validator->validAge($age)) {
            $member->setAge($age);
        }
        //data is not valid, set error in f3 hive
        else {
            $f3->set('errors["age"]',"Age must be in the range of 18-118.");
        }

        if(isset($_POST['gender'])) {

            $userGender = $_POST['gender'];

            if($validator->validGender($userGender)) {
                $member->setGender($userGender);
            }
            else{
                $f3->set('errors["gender"]', "Please select a gender.");
            }
        }

        //if there are no errors, redirect
        if(empty($f3->get('errors'))) {
            $_SESSION['member'] = $member;
            $f3->reroute('/profile');  //get
        }
    }

    $f3->set('genders', $dataLayer->getGender());

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

    global $validator;
    global $dataLayer;
    global $member;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //get required data
        $email = trim($_POST['email']);

        if ($validator->validEmail($email)) {
            $member->setEmail($email);
            $_SESSION['member']->setEmail($email);
        } else {
            $f3->set('errors["email"]', "Email required.");
        }

        //get optional data
        if (isset($_POST['seeking'])) {

            $seeking = $_POST['seeking'];

            if ($validator->validGender($seeking)) {
                $member->setSeeking($seeking);
                $_SESSION['member']->setSeeking($seeking);
            } else {
                $f3->set('errors["seeking"]', "Please select a gender.");
            }
        }

        if (isset($_POST['state'])) {

            $userState = $_POST['state'];

            if ($validator->validState($userState)) {
                $member->setState($userState);
                $_SESSION['member']->setState($userState);
            } else {
                $f3->set('errors["state"]', "Please select a valid state.");
            }
        }

        if (isset($_POST['bio'])) {

            $bio = trim($_POST['bio']);

            if (!empty($bio)) {
                $member->setBio($bio);
                $_SESSION['member']->setBio($bio);
            }
        }

        //if there are no errors, redirect
        if (empty($f3->get('errors'))) {
            $f3->reroute('/interests');  //get
        }
    }

    $f3->set('seekings', $dataLayer->getGender());
    $f3->set('states', $dataLayer->getStates());

    $f3->set('email', isset($email) ? $email : "");
    $f3->set('seeking', isset($seeking) ? $seeking : "");
    $f3->set('userState', isset($userState) ? $userState : "");
    $f3->set('bio', isset($bio) ? $bio : "");

    $view = new Template();
    echo $view->render('views/profile-form.html');
});

//define an interests form route
$f3->route('GET|POST /interests', function ($f3) {
    global $validator;
    global $dataLayer;

    if($_SERVER['REQUEST_METHOD']=='POST') {
        //if condiments selected
        if (isset($_POST['indoor'])) {
            //get from post array
            $userIndoor = $_POST['indoor'];
            $_SESSION['indoorInterest'] = implode(" ", $userIndoor);

            if ($validator->validIndoor($userIndoor)) {
                $_SESSION['indoorInterest'] = implode(" ", $userIndoor);
            } else {
                $f3->set('errors["indoor"]', "Valid interests only.");
            }
        }
        if (isset($_POST['outdoor'])) {
            //get from post array
            $userOutdoor = $_POST['outdoor'];
            $_SESSION['outdoorInterest'] = implode(" ", $userOutdoor);

            if ($validator->validOutdoor($userOutdoor)) {
                $_SESSION['outdoorInterest'] = implode(" ", $userOutdoor);
            } else {
                $f3->set('errors["outdoor"]', "Valid interests only.");
            }
        }
        if (empty($f3->get('errors'))) {
            //send to the summary page
            $f3->reroute('/summary');
        }
    }
    $f3->set('indoors', $dataLayer->getIndoorInterests());
    $f3->set('outdoors', $dataLayer->getOutdoorInterests());

    $f3->set('indoorInterest', isset($indoorInterest) ? $indoorInterest : "");
    $f3->set('outdoorInterest', isset($outdoorInterest) ? $outdoorInterest : "");

    $view = new Template();
    echo $view->render('views/interests-form.html');
});

//define profile summary route
$f3->route('GET /summary', function () {

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

//run fat free
$f3->run();