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

    }

    function insertMember()
    {

    }

    function getMembers()
    {

    }

    function getMember($member_id)
    {

    }

    function getInterests($member_id)
    {

    }
}