<?php
class database {
    private $DB;
    public function __construct() {
        $dataBase =
        'mysql:dbname=honors;charset=utf8;host=127.0.0.1';
        $user =
        'root';
        $password =
        ''; // Empty string with XAMPP install
        try {
            $this->DB = new PDO ( $dataBase, $user, $password );
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    }
 
    public function add($title, $question, $solution, $hint, $language, $difficulty, $time, $category) {
        $statement = $this->DB->prepare("INSERT INTO question (title, question, solution, hint, language, difficulty, " .
            "time, category) VALUES (:title, :question, :solution, :hint, :language, :difficulty, :time, :category)");
        $statement->bindParam('title', $title);
        $statement->bindParam('question', $question);
        $statement->bindParam('solution', $solution);
        $statement->bindParam('hint', $hint);
        $statement->bindParam('language', $language);
        $statement->bindParam('difficulty', $difficulty);
        $statement->bindParam('time', $time);
        $statement->bindParam('category', $category);
        $check = $statement->execute();
        return $check;
    }
    
    
    public function search($language, $time, $difficulty, $category) {
        $searchQuery = "SELECT * FROM question ";
// "WHERE question.language = :language AND question.time = :time AND question.difficulty = :difficulty AND " .
//             "question.category = :category"
        $check = 0;
        if (strcmp($language, "any") != 0) {
            $check = 1;
            $searchQuery .= "WHERE question.language = :language ";              
        }
        if (strcmp($time, "any") != 0) {
            if ($check) {
                $searchQuery .= "AND WHERE question.time = :time ";
            }
            else {
                $searchQuery .= "WHERE question.time = :time ";
            }
            $check = 1;            
        }
        if (strcmp($difficulty, "any") != 0) {
            if ($check) {
                $searchQuery .= "AND WHERE question.difficulty = :difficulty ";
            }
            else {
                $searchQuery .= "WHERE question.difficulty = :difficulty ";
            }
            $check = 1;
        }
        if (strcmp($category, "any") != 0) {
            if ($check) {
                $searchQuery .= "AND WHERE question.category = :category ";
            }
            else {
                $searchQuery .= "WHERE question.category = :category ";
            }
            $check = 1;
        }
        
        $statement = $this->DB->prepare($searchQuery);
        
        if (strcmp($language, "any") != 0) {
            $statement->bindParam('language', $language);
        }
        if (strcmp($time, "any") != 0) {
            $statement->bindParam('time', $time);
        }
        if (strcmp($difficulty, "any") != 0) {
            $statement->bindParam('difficulty', $difficulty);
        }
        if (strcmp($category, "any") != 0) {
            $statement->bindParam('category', $category);
        }
        
        $statement->execute();      
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUser($username, $password) {
        $statement = $this->DB->prepare("SELECT username, password FROM users " .
            "WHERE users.username = :username AND users.password = :password");
        $statement->bindParam('username', $username);
        $statement->bindParam('password', $password);
        $statement->execute();
        $user = $statement->fetch();
        if ($user)
            return true;
            else
                return false;
    }   
    
    public function addUser($username, $password) {
        $statement = $this->DB->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $statement->bindParam('username', $username);
        $statement->bindParam('password', $password);
        $check = $statement->execute();
        return $check;
    }
    
    public function getID($id) {
        $searchQuery = "SELECT * FROM question WHERE question.id = :id";
        
        $statement = $this->DB->prepare($searchQuery);
        
        $statement->bindParam('id', $id);
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>