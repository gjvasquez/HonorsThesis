CREATE TABLE Users (
  username     VARCHAR(255)    PRIMARY KEY,
  id           INTEGER,
  password     VARCHAR(255) 
);

CREATE TABLE Exam (
  id           INTEGER         PRIMARY KEY,
  username     VARCHAR(255)    REFERENCES Users(username)  
);

CREATE TABLE Question (
  title        VARCHAR(255),
  id           INTEGER         PRIMARY KEY,
  user_added   VARCHAR(255)    REFERENCES Users(username),
  question     VARCHAR(500),
  solution     VARCHAR(500),
  hint         VARCHAR(255),
  language     VARCHAR(255),
  difficulty   INTEGER,
  time         INTEGER, 
  category     VARCHAR(50)
);

CREATE TABLE ExamQuestion (
  id           INTEGER         PRIMARY KEY,
  questionid   INTEGER         REFERENCES Question(id),
  examid       INTEGER         REFERENCES Exam (id)  
);

CREATE TABLE ShoppingCart (
  username     VARCHAR(255)    REFERENCES Users(username),
  questionid   INTEGER         REFERENCES Question(id),
  PRIMARY KEY(username, questionid)  
);

INSERT INTO Users
VALUES ('Bob', 000001, 'bob');
INSERT INTO Question
VALUES ('Question 1', 000001, 'Bob', 'What is Python?', 'A programming language.', 'WHat is is categorized as?', 'Python', 1, 2, 'fib');
INSERT INTO Question
VALUES ('Question 2', 000002, 'Bob', 'What is the meaning of life?', '42.', 'It is a number', 'none', 1, 2, 'fib');