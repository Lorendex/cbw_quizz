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

unset($conf);