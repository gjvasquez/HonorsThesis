<?php
session_start();
include "database.php";
if (isset($_GET['action'])) {
    $action = $_GET ['action'];
}
else {
    $action = NULL;
}
$theDBA = new database();
if (isset($_SESSION ['registrationError'])) {
    echo $_SESSION ['registrationError'];
    unset($_SESSION ['registrationError']);
} 
// if ($action == 'register') {
//     $username = $_GET['username'];
//     $password = $_GET['password'];
//     if ($theDBA->addUser($username, $password)) {
//         $_SESSION['user'] = $username;
//         echo "Registered!";
//   //      header ( "Location: view.php" );
//     } else {
//         echo 'Username already taken';
//     }
// }

// if ($action == 'login') {
//     $username = $_GET['username'];
//     $password = $_GET['password'];
//     if ($theDBA->getUser($username, $password)) {
//         $_SESSION ['user'] = $username;
//         echo "Successfully logged in";
// //         header ( "Location: view.php" );
//     } else {
//         echo 'Invalid Account/Password';
//     }
// }




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


if ($action == 'search') {
    $language = $_GET['language'];
    $difficulty = $_GET['difficulty'];
    $time = $_GET['time'];
    $category = $_GET['category'];
    $question_array = json_encode($theDBA->search($language, $time, $difficulty, $category));
    echo $question_array;
}

if ($action == 'getInfo') {
    $id = $_GET['id'];
    $question_array = json_encode($theDBA->getID($id));
    echo $question_array;
}
    
?>