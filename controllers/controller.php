<?php

//controllers/controller.php

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

    function register()
    {
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
                $this->_f3->set('errors["fname"]',"First name cannot be blank.");
            }
            if($validator->validName($lname)) {
                $member->setLname($lname);
            }
            //data is not valid, set error in f3 hive
            else {
                $this->_f3->set('errors["lname"]',"Last name cannot be blank.");
            }
            if($validator->validPhone($phone)) {
                $member->setPhone($phone);
            }
            //data is not valid, set error in f3 hive
            else {
                $this->_f3->set('errors["phone"]',"Please type a valid phone number.");
            }
            if($validator->validName($pname)) {
                $member->setPname($pname);
            }
            //data is not valid, set error in f3 hive
            else {
                $this->_f3->set('errors["pname"]',"Required. Please no spaces");
            }
            if($validator->validAge($age)) {
                $member->setAge($age);
            }
            //data is not valid, set error in f3 hive
            else {
                $this->_f3->set('errors["age"]',"Age must be in the range of 18-118.");
            }

            if(isset($_POST['gender'])) {

                $userGender = $_POST['gender'];

                if($validator->validGender($userGender)) {
                    $member->setGender($userGender);
                }
                else{
                    $this->_f3->set('errors["gender"]', "Please select a gender.");
                }
            }

            //if there are no errors, redirect
            if(empty($this->_f3->get('errors'))) {
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

        $view = new Template();
        echo $view->render('views/personal-form.html');
    }

    function profile()
    {

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
                $this->_f3->set('errors["email"]', "Email required.");
            }

            //get optional data
            if (isset($_POST['seeking'])) {

                $seeking = $_POST['seeking'];

                if ($validator->validGender($seeking)) {
                    $member->setSeeking($seeking);
                    $_SESSION['member']->setSeeking($seeking);
                } else {
                    $this->_f3->set('errors["seeking"]', "Please select a gender.");
                }
            }

            if (isset($_POST['state'])) {

                $userState = $_POST['state'];

                if ($validator->validState($userState)) {
                    $member->setState($userState);
                    $_SESSION['member']->setState($userState);
                } else {
                    $this->_f3->set('errors["state"]', "Please select a valid state.");
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
            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('/interests');  //get
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

    function interests()
    { global $validator;
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
                    $this->_f3->set('errors["indoor"]', "Valid interests only.");
                }
            }
            if (isset($_POST['outdoor'])) {
                //get from post array
                $userOutdoor = $_POST['outdoor'];
                $_SESSION['outdoorInterest'] = implode(" ", $userOutdoor);

                if ($validator->validOutdoor($userOutdoor)) {
                    $_SESSION['outdoorInterest'] = implode(" ", $userOutdoor);
                } else {
                    $this->_f3->set('errors["outdoor"]', "Valid interests only.");
                }
            }
            if (empty($this->_f3->get('errors'))) {
                //send to the summary page
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

    function summary() {
        $view = new Template();
        echo $view->render('views/summary.html');

        session_destroy();
    }
}
