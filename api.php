<?php
define('CBW_QUIZZ', TRUE);

require_once "base.inc.php";
if(!isset($_GET)) return "ERROR:NO_PARAMETERS";
$action = $_GET["action"];

switch (strtolower($action)){
    case "savename": {
        $username = htmlspecialchars(trim($_GET["username"]));
        if(!empty($username)) {
            $user->setUsernameAndSave($username);
        } else {
            die("ERROR:NO_USERNAME");
        }
        if(isset($_GET["save_name"]) && $_GET["save_name"] == 1){
            setcookie(config::getInstance()->getCookieName(), $username, time()+3600*24*30);
        }
        echo "OK";
    } break;
    case "noname": {
        setcookie("CBW_NO_NAME", 1, time()+3600*24*30);
        echo "OK";
    }

    default: echo "ERROR:UNKNOWN_ACTION"; break;
}