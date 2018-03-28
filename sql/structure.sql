CREATE TABLE IF NOT EXISTS user_sessions (
  ID int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  token char(36) NOT NULL,
  username varchar(200) DEFAULT NULL,
  lastactive datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  lastquestion int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (ID),
  UNIQUE KEY token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

