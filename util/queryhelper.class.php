<?php
/**
 * Created: 28/03/2018 16:18
 */

abstract class queryhelper
{
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
}