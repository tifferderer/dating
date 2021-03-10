<?php

//controllers/controller.php
/**
 * Class PController
 */
class PController
{

    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     *Display home page
     */
    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Display register page
     */
    function register()
    {
        global $validator;
        global $dataLayer;

        //if the form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //get data from post array
            $fname = trim($_POST['fname']);
            $lname = trim($_POST['lname']);
            $phone = trim($_POST['phone']);
            $pname= trim($_POST['pname']);
            $age = trim($_POST['age']);

            //Validate
            if(!$validator->validName($fname)) {
                $this->_f3->set('errors["fname"]',"First name cannot be blank.");
            }
            if(!$validator->validName($lname)) {
                $this->_f3->set('errors["lname"]',"Last name cannot be blank.");
            }
            if(!$validator->validPhone($phone)) {
                $this->_f3->set('errors["phone"]',"Please type a valid phone number.");
            }
            if(!$validator->validName($pname)) {
                $this->_f3->set('errors["pname"]',"Required. Please no spaces");
            }
            if(!$validator->validAge($age)) {
                $this->_f3->set('errors["age"]',"Age must be in the range of 18-118.");
            }

            if(isset($_POST['gender'])) {

                $userGender = $_POST['gender'];

                if(!$validator->validGender($userGender)) {
                    $this->_f3->set('errors["gender"]', "Please select a gender.");
                }
            }

            if(isset($_POST['premium'])) {
                $premium = $_POST['premium'];
            }

            //if there are no errors, redirect
            if(empty($this->_f3->get('errors'))) {

                //premium checkbox validation
                if(isset($_POST['premium'])) {
                    $member = new Premium($fname, $lname, $age, $userGender, $phone, $pname);
                }
                else{
                    $member = new Member($fname, $lname, $age, $userGender, $phone, $pname);
                }
                $_SESSION['member'] = $member;
                $this->_f3->reroute('/profile');  //get
            }
        }

        $this->_f3->set('genders', $dataLayer->getGender());

        $this->_f3->set('fname', isset($fname) ? $fname : "");
        $this->_f3->set('lname', isset($lname) ? $lname : "");
        $this->_f3->set('phone', isset($phone) ? $phone : "");
        $this->_f3->set('pname', isset($pname) ? $pname : "");
        $this->_f3->set('age', isset($age) ? $age : "");
        $this->_f3->set('userGender', isset($userGender) ? $userGender : "");
        $this->_f3->set('premium', isset($premium));

        $view = new Template();
        echo $view->render('views/personal-form.html');
    }

    /**
     * Display profile page
     */
    function profile()
    {
        global $validator;
        global $dataLayer;
        global $database;
        //print_r($_SESSION['member']);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get required data
            $email = trim($_POST['email']);

            if ($validator->validEmail($email)) {
                $_SESSION['member']->setEmail($email);
            } else {
                $this->_f3->set('errors["email"]', "Email required.");
            }

            //get optional data
            if (isset($_POST['seeking'])) {

                $seeking = $_POST['seeking'];

                if ($validator->validGender($seeking)) {
                    $_SESSION['member']->setSeeking($seeking);
                } else {
                    $this->_f3->set('errors["seeking"]', "Please select a gender.");
                }
            }

            if (isset($_POST['state'])) {

                $userState = $_POST['state'];

                if ($validator->validState($userState)) {
                    $_SESSION['member']->setState($userState);
                } else {
                    $this->_f3->set('errors["state"]', "Please select a valid state.");
                }
            }

            if (isset($_POST['bio'])) {

                $bio = trim($_POST['bio']);

                if (!empty($bio)) {
                    $_SESSION['member']->setBio($bio);
                }
            }

            //if there are no errors, redirect
            if (empty($this->_f3->get('errors'))) {
                if($_SESSION['member'] instanceof Premium){
                    $this->_f3->reroute('/interests');
                }
                else {
                   $database->insertMember();
                    $this->_f3->reroute('/summary');//get
                }
            }
        }

        $this->_f3->set('seekings', $dataLayer->getGender());
        $this->_f3->set('states', $dataLayer->getStates());

        $this->_f3->set('email', isset($email) ? $email : "");
        $this->_f3->set('seeking', isset($seeking) ? $seeking : "");
        $this->_f3->set('userState', isset($userState) ? $userState : "");
        $this->_f3->set('bio', isset($bio) ? $bio : "");

        $view = new Template();
        echo $view->render('views/profile-form.html');
    }

    /**
     * Display interest form page
     */
    function interests()
    {
        global $validator;
        global $dataLayer;
        global $database;

        if($_SERVER['REQUEST_METHOD']=='POST') {
            //if condiments selected
            if (isset($_POST['indoor'])) {
                //get from post array
                $userIndoor = $_POST['indoor'];
                //$indoorString =implode(" ", $userIndoor);

                if ($validator->validIndoor($userIndoor)) {
                    $indoorString =implode(" ", $userIndoor);
                    $_SESSION['member']->setIndoorInterests($indoorString);
                } else {
                    $this->_f3->set('errors["indoor"]', "Valid interests only.");
                }
            }
            if (isset($_POST['outdoor'])) {
                //get from post array
                $userOutdoor = $_POST['outdoor'];
                //$_SESSION['outdoorInterest'] = implode(" ", $userOutdoor);

                if ($validator->validOutdoor($userOutdoor)) {
                    $outdoorString =implode(" ", $userOutdoor);
                    $_SESSION['member']->setOutdoorInterests($outdoorString);
                } else {
                    $this->_f3->set('errors["outdoor"]', "Valid interests only.");
                }
            }
            if (empty($this->_f3->get('errors'))) {
                //send to the summary page
                $database->insertMember();
                if (isset($userIndoor)) {
                    foreach ($userIndoor as $indoor) {
                         $id= $database->getInterestId($indoor);
                        $database->insertInterests($id);
                    }
                }
                if (isset($userOutdoor)) {
                    foreach ($userOutdoor as $outdoor) {
                        $id = $database->getInterestId($outdoor);
                        $database->insertInterests($id);
                    }
                }
                $this->_f3->reroute('/summary');
            }
        }
        $this->_f3->set('indoors', $dataLayer->getIndoorInterests());
        $this->_f3->set('outdoors', $dataLayer->getOutdoorInterests());

        $this->_f3->set('indoorInterest', isset($indoorInterest) ? $indoorInterest : "");
        $this->_f3->set('outdoorInterest', isset($outdoorInterest) ? $outdoorInterest : "");

        $view = new Template();
        echo $view->render('views/interests-form.html');
    }

    /**
     * Display summary and clear sessions
     */
    function summary() {

        $view = new Template();
        echo $view->render('views/summary.html');

        session_destroy();
    }

    /**
     * Display admin page
     */
    function admin() {
        global $database;

        $customers = array();
        $profiles = array();
        $interestChoices = array();
        $result = $database ->getMembers();

        foreach ($result as $row) {
            $profiles['full'] = $row['fname'] . " ". $row['lname'];
            $profiles['id'] = $row['member_id'];
            $profiles['email'] = $row['email'];
            $profiles['age'] = $row['age'];
            $profiles['phone'] = $row['phone'];
            $profiles['state'] = $row['state'];
            $profiles['gender'] = $row['gender'];
            $profiles['seeking'] = $row['seeking'];
            $profiles['premium'] = $row['premium'];

             $interests = $database->getInterests($row['member_id']);

            $profiles['interests'] = $interests;

            $customers[] = $profiles;
        }

        $this->_f3->set('customers', $customers);

        $view = new Template();
        echo $view->render('views/admin.html');
    }
}
