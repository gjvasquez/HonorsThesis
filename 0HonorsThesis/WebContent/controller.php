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

if ($action == 'register') {
    $username = $_GET['username'];
    $password = $_GET['password'];
    if ($theDBA->addUser($username, $password)) {
        $_SESSION['user'] = $username;
        echo "Registered!";
    } else {
        echo 'Username already taken';
    }
}

if ($action == 'login') {
    $username = $_GET['username'];
    $password = $_GET['password'];
    if ($theDBA->getUser($username, $password)) {
        $_SESSION ['user'] = $username;
        echo "Successfully logged in";        
    } else {
        echo 'Invalid Account/Password';
    }
}


if ($action == 'add') {
    $title = $_GET['title'];
    $question = $_GET['question'];
    $solution = $_GET['solution'];
    $hint = $_GET['hint'];
    $language = $_GET['language'];
    $difficulty = $_GET['difficulty'];
    $time = $_GET['time'];
    $category = $_GET['category'];
    
    if ($theDBA->add($title, $question, $solution, $hint, $language, $difficulty, $time, $category)) {
        echo "Question added!";
    }
    else {
        echo "Question already in database!";     
    }
}


if ($action == 'search') {
    $language = $_GET['language'];
    $difficulty = $_GET['difficulty'];
    $time = $_GET['time'];
    $category = $_GET['category'];
    $keyword = $_GET['keyword'];
    $question_array = json_encode($theDBA->search($language, $time, $difficulty, $category, $keyword));
    echo $question_array;
}

if ($action == 'getInfo') {
    $id = $_GET['id'];
    $question_array = json_encode($theDBA->getID($id));
    echo $question_array;
}
    

if ($action == 'addToCart') {
    $qid = $_GET['qid'];
    $user = $_SESSION['user'];
    $question_array = $theDBA->getShoppingCart($user);
    $position = count($question_array) + 1;
    if ($theDBA->addToCart($user, $qid, $position)) {
        echo "Question added to Shopping Cart!";
    }
    else {
        echo "Question already in Shopping Cart!";
    }
}

if ($action == 'deleteQuestion') {
    $qid = $_GET['qid'];
    if ($theDBA->deleteQuestion($qid)) {
        echo "Question deleted!";
    }
    else {
        echo "Error deleting question!";
    }
}



if ($action == 'removeFromCart') {
    $qid = $_GET['qid'];
    $user = $_SESSION['user'];
    if ($theDBA->removeFromCart($user, $qid)) {
        echo "Question successfully removed from Shopping Cart!";
    }
    else {
        echo "Question already removed!";
    }
}

if ($action == 'getShoppingCart') {
    $user = $_SESSION['user'];
    $question_array = json_encode($theDBA->getShoppingCart($user));
    
    echo $question_array;
}

if ($action == 'updateCart') {
    $user = $_SESSION['user'];
    $qid = $_GET['qid'];
    $position = $_GET['position'];
    $question_array = $theDBA->updateCart($user, $qid, $position);
    
    echo "";
}


?>