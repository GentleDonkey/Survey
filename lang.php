<?php

require '../includes/php/bootstrap.php';

$SESSION = new \Zend_Session_Namespace('student', true);

$acceptedLanguages = L10nTranslate::getAllowedLanguages();

if(empty($_GET['lang'])) {
    // No language sent, check session
    if(empty($SESSION->corr_lang)) {
        $SESSION->corr_lang = DEFAULT_LANGUAGE;
    }
} else {
    if(in_array($_GET['lang'], $acceptedLanguages, true)) {
        // acceptable language
        $SESSION->corr_lang = $_GET['lang'];
    } else {
        // unacceptable language
        $SESSION->corr_lang = DEFAULT_LANGUAGE;
    }
}

if (!isset($SESSION->logged_in) && mb_strpos($_GET['uri'], URL_STUDENT . '/index.php') === FALSE) {
    header('Location: https://'. URL_STUDENT .'/index.php?next='.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    die();
}

$uri = (empty($_GET['uri'])) ? "https://" . URL_STUDENT . "/" : $_GET['uri'];

//Check if URL is safe to redirect to
if (preg_match('#^((https?:)?//' . URL_VENTUS . '/|/(?!/))#', urldecode($uri))) {
    // URL is valid
    header("Location: $uri");
} else {
    // Someone is taking advantage of a safe-looking URL
    // Only use the HTTP referer header if it is a Ventus site
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
exit;