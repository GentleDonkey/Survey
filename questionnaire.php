<?php

//============================================================================================
// Session, configuration file, localization constructor
//============================================================================================
require '../includes/php/bootstrap.php';

$SESSION = new \Zend_Session_Namespace('student', true);

if (!isset($SESSION->lang) || empty($SESSION->lang)) {
    $l10n = new L10nTranslate();
} else {
    $l10n = new L10nTranslate($SESSION->lang);
}

//============================================================================================
// Model and Header and L10N Includes, Authentication
//============================================================================================
require 'models/questionnaire.php';
$model = new Questionnaire();

require FS_INCLUDES . '/l10n/header-external.php';

//============================================================================================
// Load the content
//============================================================================================

if(isset($_GET['user'])){
	if($model -> checkUserExists($_GET['user'])){
		
		$user = $_GET['user'];
		$student = $model -> fetchStudentByHashCode($user);
		$genneral = $model -> listGenneralQuestionnaire();
		$particular = $model -> listParticularQuestionnaire($student['0']['survey_sent_on_service_id']);
			
		if (!isset($_GET['page'])){
			if($student['0']['completed']){
				echo $_GET['user'];
				header('Location: questionnaire.php?page=complete&user=' . $user);
			}else{
				require_once 'l10n/questionnaire.php';
				require_once FS_PHP . '/header-external.php';
				require_once 'views/questionnaire.php';
				require_once FS_PHP . '/footer-external.php';
			}
		}elseif($_GET['page'] === "add"){
			
			$questionAnswer_id = $model -> addQuestionAnswer($_POST);
			$model -> addStudentQuestionAnswer($questionAnswer_id, $student['0']['list_id']);
			$model -> updateStudentList($student['0']['list_id']);
			echo $_GET['user'];
			
		}elseif($_GET['page'] === "complete"){
			
			if($student['0']['completed']){
				if($model -> checkOtherSurvey($_GET['user'])){
					$newQues = $model -> fetchOtherSurvey($_GET['user']);
				}
				
				require_once 'l10n/questionnaire_next.php';
				require_once FS_PHP . '/header-external.php';
				require_once 'views/questionnaire_next.php';
				require_once FS_PHP . '/footer-external.php';
			}else{
				header('Location: questionnaire.php?user=' . $user);
			}
		}else{
    		require_once FS_PHP . '/error.php';
		}		
	}else{
		require_once FS_PHP . '/error.php';
	}
}else{
	require_once FS_PHP . '/error.php';
}
