<?php
/**
 * Created: 28/03/2018 16:18
 */

abstract class queryhelper
{
    /********************************************* USER SESSION QUERYS ************************************************/

    public static function USER_SESSION_CREATE(): string{
       $query = "INSERT INTO ".user_session::TABLE." (ID, token, username, lastactive, lastquestion) VALUES (NULL, UUID(), :username, NOW(), 0 );";
       log::debug("QUERYHELPER: " . $query);
       return $query;
    }
    public static function USER_SESSION_BY_TOKEN(): string {
        $query = "SELECT * FROM ".user_session::TABLE." WHERE token = :token;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }
    public static function USER_SESSION_BY_ID(): string {
        $query = "SELECT * FROM ".user_session::TABLE." WHERE ID = :id;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }
    public static function USER_SESSION_UPDATE_NAME(): string {
        $query = "UPDATE ".user_session::TABLE." SET username = :username WHERE ID = :id;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }

    /******************************************** QUESTION QUERYS *****************************************************/
    public static function QUESTION_BY_ID(): string {
        $query = "SELECT * FROM ".quizz_question::TABLE." WHERE ID = :id;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }
    public static function QUESTION_BY_RANDOM(): string {
        $query = "SELECT * FROM ".quizz_question::TABLE." WHERE area = :area ORDER BY RAND() LIMIT 1;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }

    public static function QUESTIONS_ALL(): string {
        $query = "SELECT * FROM ".quizz_question::TABLE.";";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }

    /******************************************** ANSWER QUERYS *******************************************************/
    public static function ANSWER_BY_ID(): string {
        $query = "SELECT * FROM ".quizz_answer::TABLE." WHERE ID = :id;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }

    public static function ANSWERS_BY_QUESTION_ID(): string {
        $query = "SELECT * FROM ".quizz_answer::TABLE." WHERE qID = :qid;";
        log::debug("QUERYHELPER: " . $query);
        return $query;
    }
}