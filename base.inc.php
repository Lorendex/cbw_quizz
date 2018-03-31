<?php
declare(strict_types=1);
/**
 * Created: 27/03/2018 22:05
 */

# kill direct requets for base.inc.php
defined('CBW_QUIZZ') or die();

# load interfaces
require_once "class/db_entry.interface.php";

# load classes
require_once "class/config.class.php";
require_once "class/user_session.class.php";
require_once "class/quizz_question.class.php";
require_once "class/quizz_answer.class.php";
require_once "class/quizz_solo.class.php";

# load utility
require_once "util/log.class.php";
require_once "util/db.class.php";
require_once "util/queryhelper.class.php";


# load config
require "conf/config.inc.php";

# init connection to database
db::getInstance();

# user session
/** @var user_session $user */
$user = null;
session_start();

if(user_session::userSessionAviable()){
    log::debug("UserSession found, loading it...");
    $user = user_session::loadByToken();
    log::debug("UserSession loaded.");
} else {
    log::debug("UserSession not found, generate one.");
    $user = user_session::generateNewSession();
    log::debug("UserSession generated.");
    $_SESSION[config::getInstance()->getSessionName()]["token"] = $user->getToken();
}





