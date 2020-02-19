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
        $statement = $this->DB->prepare("SELECT * FROM question " .
            "WHERE question.language = :language AND question.time = :time AND question.difficulty = :difficulty AND " .
            "question.category = :category");
        $statement->bindParam('language', $language);
        $statement->bindParam('time', $time);
        $statement->bindParam('difficulty', $difficulty);
        $statement->bindParam('category', $category);
        $statement->execute();      
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>