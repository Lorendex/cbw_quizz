CREATE TABLE IF NOT EXISTS user_sessions (
  ID int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  token char(36) NOT NULL,
  username varchar(200) DEFAULT NULL,
  lastactive datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  lastquestion int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (ID),
  UNIQUE KEY token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quizz_questions (
  ID int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title varchar(500) NOT NULL,
  question text NOT NULL,
  type tinyint(4) NOT NULL,
  area tinyint(4) NOT NULL,
  summer tinyint(1) NOT NULL,
  from_year smallint(6) NOT NULL,
  moreinfo varchar(10000) NOT NULL,
  PRIMARY KEY (ID),
  KEY type (type),
  KEY area (area),
  KEY from_year (from_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quizz_answers (
  ID int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  qID int(10) UNSIGNED NOT NULL,
  answer_text varchar(4000) NOT NULL,
  correct tinyint(1) NOT NULL,
  PRIMARY KEY (ID),
  KEY qID (qID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quizz_givenanswer (
  ID int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  qID int(10) UNSIGNED NOT NULL,
  correct tinyint(1) NOT NULL,
  sID int(10) UNSIGNED NOT NULL,
  recived datetime NOT NULL,
  wrong_answer varchar(100) DEFAULT NULL,
  PRIMARY KEY (ID),
  KEY qID (qID),
  KEY sID (sID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
