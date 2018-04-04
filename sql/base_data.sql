INSERT INTO quizz_questions (ID, title, question, `type`, `area`, summer, from_year, moreinfo, deleted) VALUES
  (1, 'Question 1', 'Frage 1 Text', 1, 1, 0, 2017, '', 0),
  (2, 'Question 2', 'Frage 2 Text', 2, 1, 1, 2017, 'HS: 1 A: 2da', 0),
  (3, 'Question 3', 'Frage 3 Text', 1, 1, 0, 2016, '', 0),
  (4, 'Question 4', 'Frage 4 Text', 2, 1, 1, 2016, 'HS: 1 A: 1a', 0),
  (5, 'Question 5', 'Frage 5 Text', 1, 1, 0, 2015, '', 0),
  (6, 'Question 6', 'Frage 6 Text', 2, 1, 1, 2015, '', 0),
  (7, 'Question 7', 'Frage 7 Text', 1, 1, 0, 2014, 'HS: 1 A: 1b', 0),
  (8, 'Question 8', 'Frage 8 Text', 2, 1, 1, 2014, '', 0),
  (9, 'Question 9', 'Frage 9 Text', 1, 1, 0, 2013, 'HS: 3 A: 2c', 0),
  (10, 'Question 10', 'Frage 10 Text', 2, 1, 1, 2013, 'HS: 2 A: 4c', 0);

INSERT INTO quizz_answers (ID, qID, answer_text, correct) VALUES
  (NULL, '1', 'Antwort 1', '0'),
  (NULL, '1', 'Antwort 2', '1'),
  (NULL, '1', 'Antwort 3', '0'),
  (NULL, '1', 'Antwort 4', '1'),

  (NULL, '2', 'Antwort 1', '0'),
  (NULL, '2', 'Antwort 2', '0'),
  (NULL, '2', 'Antwort 3', '0'),
  (NULL, '2', 'Antwort 4', '1'),
  (NULL, '2', 'Antwort 5', '0'),
  (NULL, '2', 'Antwort 6', '0'),

  (NULL, '3', 'Antwort 1', '0'),
  (NULL, '3', 'Antwort 2', '1'),
  (NULL, '3', 'Antwort 3', '0'),
  (NULL, '3', 'Antwort 4', '1'),
  (NULL, '3', 'Antwort 5', '0'),
  (NULL, '3', 'Antwort 6', '0'),

  (NULL, '4', 'Antwort 1', '0'),
  (NULL, '4', 'Antwort 2', '1'),
  (NULL, '4', 'Antwort 3', '0'),
  (NULL, '4', 'Antwort 4', '0'),

  (NULL, '5', 'Antwort 1', '0'),
  (NULL, '5', 'Antwort 2', '0'),
  (NULL, '5', 'Antwort 3', '0'),
  (NULL, '5', 'Antwort 4', '1'),
  (NULL, '5', 'Antwort 5', '0'),
  (NULL, '5', 'Antwort 6', '0'),

  (NULL, '6', 'Antwort 1', '0'),
  (NULL, '6', 'Antwort 2', '1'),
  (NULL, '6', 'Antwort 3', '0'),
  (NULL, '6', 'Antwort 4', '0'),

  (NULL, '7', 'Antwort 1', '0'),
  (NULL, '7', 'Antwort 2', '0'),
  (NULL, '7', 'Antwort 3', '0'),
  (NULL, '7', 'Antwort 4', '1'),

  (NULL, '8', 'Antwort 1', '0'),
  (NULL, '8', 'Antwort 2', '0'),
  (NULL, '8', 'Antwort 3', '0'),
  (NULL, '8', 'Antwort 4', '1'),
  (NULL, '8', 'Antwort 5', '0'),
  (NULL, '8', 'Antwort 6', '0'),

  (NULL, '9', 'Antwort 1', '0'),
  (NULL, '9', 'Antwort 2', '0'),
  (NULL, '9', 'Antwort 3', '0'),
  (NULL, '9', 'Antwort 4', '1'),

  (NULL, '10', 'Antwort 1', '0'),
  (NULL, '10', 'Antwort 2', '1'),
  (NULL, '10', 'Antwort 3', '0'),
  (NULL, '10', 'Antwort 4', '0');