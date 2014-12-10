<?php
//============================================================================================
// Config 
//============================================================================================
require '../includes/php/bootstrap.php';

// SET SESSION to be cron specific, and set user_id to be 0
$SESSION = new \Zend_Session_Namespace('cron', true);
$SESSION->user_id = CRON_USER_ID;

//============================================================================================
// Models
//============================================================================================

require 'models/survey-cronjob.php';
$survey = new SurveyCronJobs();

//============================================================================================
// Cron job activity- call all cron jobs
//============================================================================================

$survey->runAllSurveyJobs();
