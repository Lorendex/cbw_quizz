<?php
/**
 * Created: 27/03/2018 21:25
 */
defined('CBW_QUIZZ') or die();

$conf = config::getInstance();

$conf->setDbHost("127.0.0.1");
$conf->setDbDatabase("cbw_quizz");
$conf->setDbUser("root");
$conf->setDbPass("changeme");
$conf->setDbPort(3306);

$conf->setLogDebug(true);
$conf->setLogInfo(true);
$conf->setLogWarning(true);
$conf->setLogError(true);
$conf->setLogFatal(true);

$conf->setSessionName("cbw_quizz");
$conf->setCookieName("cbw_quizz");

log::info("Config load successfully.");
unset($conf);