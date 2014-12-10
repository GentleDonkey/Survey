<?php
//============================================================================================
// Session, configuration file, localization constructor
//============================================================================================
require '../includes/php/bootstrap.php';

$SESSION = new \Zend_Session_Namespace('survey', true);

if (!isset($SESSION->lang) || empty($SESSION->lang)) {
    $l10n = new L10nTranslate();
} else {
    $l10n = new L10nTranslate($SESSION->lang);
}

//============================================================================================
// Model
//============================================================================================
require_once 'models/setting.php';
$model = new Questions();

require FS_INCLUDES . '/l10n/header-external.php';

//============================================================================================
// Load the page requested by the user
//============================================================================================
if (!isset($_GET['page'])){
	$Services = $model -> listAllServ();
	if (!isset($_GET['service'])){
		//genneral ques
		$Questions = $model -> listAllQues('0');
		$DelQuestions = $model -> listDelQues('0');
	}else{
		$Questions = $model -> listAllQues($_GET['service']);
		$DelQuestions = $model -> listDelQues($_GET['service']);
	}

    require_once 'l10n/setting.php';
    require_once FS_PHP . '/header-external.php';
    require_once 'views/setting.php';
    require_once FS_PHP . '/footer-external.php';
    
} elseif ($_GET['page'] === "update") {
	print_r($_POST);
	$model -> updatePriority($_POST);
	
} else{
	require_once FS_PHP . '/error.php';
}

