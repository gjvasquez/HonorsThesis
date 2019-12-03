CREATE TABLE Users (
  username     VARCHAR(255),
  id           INTEGER         AUTO_INCREMENT PRIMARY KEY,
  password     VARCHAR(255) 
);

CREATE TABLE Exam (
  id           INTEGER         AUTO_INCREMENT PRIMARY KEY,
  username     VARCHAR(255)    REFERENCES Users(username)  
);

CREATE TABLE Question (
  title        VARCHAR(255),
  id           INTEGER         AUTO_INCREMENT PRIMARY KEY,
  user_added   VARCHAR(255)    REFERENCES Users(username),
  question     TEXT,
  solution     TEXT,
  hint         VARCHAR(255),
  language     VARCHAR(255),
  difficulty   INTEGER,
  time         INTEGER, 
  category     VARCHAR(50)
);

CREATE TABLE ExamQuestion (
  id           INTEGER         AUTO_INCREMENT PRIMARY KEY,
  questionid   INTEGER         REFERENCES Question(id),
  examid       INTEGER         REFERENCES Exam (id)  
);

CREATE TABLE ShoppingCart (
  username     VARCHAR(255)    REFERENCES Users(username),
  questionid   INTEGER         REFERENCES Question(id),
  PRIMARY KEY(username, questionid)  
);

INSERT INTO Users (username, password)
VALUES ('Bob', 'bob');
INSERT INTO Question
VALUES ('Question 1', 000001, 'Bob', 'What is Python?', 'A programming language.', 'WHat is is categorized as?', 'Python', 1, 2, 'fib');
INSERT INTO Question
VALUES ('Question 2', 000002, 'Bob', 'What is the meaning of life?', '42.', 'It is a number', 'none', 1, 2, 'fib');