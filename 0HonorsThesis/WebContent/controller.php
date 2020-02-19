<?php
session_start();

include "database.php";
$theDBA = new database();
if (isset($_SESSION ['registrationError'])) {
    echo $_SESSION ['registrationError'];
    unset($_SESSION ['registrationError']);
}
if (isset ( $_POST ['login'] )) {
    if ($theDBA->getUser($username, $password)->verified ( $username, $password )) {
        // Store session data so the account name isset and known on any page
        $_SESSION ['user'] = $username;
        // Return to the main page where the user's account name
        // is known and $_SESSION ['user'] is set
        header ( "Location: index.html" );
    } else {
        $_SESSION ['loginError'] = 'Invalid Account/Password';
        header ( "Location: ./login.php?mode=login" );
    }
}


//     $title = $_GET['title'];
//     $question = $_GET['question'];
//     $solution = $_GET['solution'];
//     $hint = $_GET['hint'];
//     $language = $_GET['language'];
//     $difficulty = $_GET['difficulty'];
//     $time = $_GET['time'];
//     $category = $_GET['category'];
    
//     if ($theDBA->add($title, $question, $solution, $hint, $language, $difficulty, $time, $category)) {
//         echo "Question added!";
//     }
//     else {
//         echo "Question already in database!";     }


    $language = $_GET['language'];
    $difficulty = $_GET['difficulty'];
    $time = $_GET['time'];
    $category = $_GET['category'];
    $question_array = json_encode($theDBA->search($language, $time, $difficulty, $category));
    echo $question_array;
?>