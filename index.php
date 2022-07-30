<?php
require_once 'connect.php';
require_once 'User.php';

//$user = new User(21, 'Steve', 'Smith', '1982-11-11', 0, 'Minsk');


//    $user->showUser(21);

//    $user->addUser();

//    User::deleteUser(14);

//    echo User::getAgeFromBirthday(21);
//    echo  "<br>";
//    echo User::getGender(21);

var_dump(User::formatUser(21));



