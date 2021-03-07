<?php
class Database
{
    /*
CREATE TABLE member(
member_id int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
fname VARCHAR(20)NOT NULL,
lname VARCHAR(20)NOT NULL,
pname VARCHAR(20)NOT NULL,
age int(3),
gender VARCHAR(6),
phone int(10),
email  VARCHAR(50)NOT NULL,
state VARCHAR(20)NOT NULL,
seeking VARCHAR(6),
bio VARCHAR(120),
premium int(1),
image VARCHAR(50)
);

CREATE TABLE interest(
interest_id int(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
interest VARCHAR(20)NOT NULL,
type VARCHAR(7)NOT NULL
);

CREATE TABLE member-interest (
member_id int(4),
interest_id int(4),
FOREIGN KEY(member_id) REFERENCES member(member_id),
FOREIGN KEY(interest_id) REFERENCES interest(interest_id)
);
     */
    function connect()
    {
        require  $_SERVER['DOCUMENT_ROOT'].'/../config.php';
    }

    function insertMember()
    {
        $sql = "INSERT INTO member(fname, lname, pname, age, gender, phone, email, state, seeking, bio, premium) " .
 "VALUES (:fname, :lname, :pname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        $statement = $dbh->prepare($sql);

        //bind parameter
        $fname= $_SESSION['member']->getFname();
        $lname= $_SESSION['member']->getLname();
        $pname= $_SESSION['member']->getPname();
        $age= $_SESSION['member']->getAge();
        $gender= $_SESSION['member']->getGenger();
        $phone= $_SESSION['member']->getPhone();
        $email= $_SESSION['member']->getEmail();
        $state= $_SESSION['member']->getState();
        $seeking= $_SESSION['member']->getSeeking();
        $bio= $_SESSION['member']->getBio();
        if($_SESSION['member'] instanceof Premium){
            $premium = 1;
        }
        else {
           $premium = 0;
        }

        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':pname', $pname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_STR);

        //execute
        $statement->execute();
    }

    function getMembers()
    {
        //Define the query
        $sql = "SELECT * FROM member";
        //Prepare the statement
        $statement = $dbh->prepare($sql);

        //Execute
        $statement ->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        echo "First Name" . $row['fname'];}
    }

    function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id = :id";
        //Prepare the statement
        $statement = $dbh->prepare($sql);
        //Bind the parameters
        $id = $member_id;
        $statement ->bindParam(':id', $id, PDO::PARAM_INT);
        //Execute
        $statement ->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        echo "first name" . $row['fname'];
    }

    function getInterests($member_id)
    {
        $sql = "SELECT * FROM member_interest WHERE member_id = :id";
        //Prepare the statement
        $statement = $dbh->prepare($sql);
        //Bind the parameters
        $id = $member_id;
        $statement ->bindParam(':id', $id, PDO::PARAM_INT);
        //Execute
        $statement ->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        echo "Interests" . $row['interest_id'];

    }
}