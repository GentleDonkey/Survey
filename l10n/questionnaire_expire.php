<?php

if (!isset($l10n)) {
    $l10n = new L10nTranslate();
}

$sub_org_counselling_name = unserialize(ORG_SUB_ORG_COUNSELLING_SERVICE_NAME);

switch ($l10n->getLanguage()) {
    case 'en-CA':
    	$l10n->setKeyValuePair('title', 'Some title');
    	$l10n->setKeyValuePair('QuestionnaireTitle', 'Questionnaire');
    	$l10n->setKeyValuePair('sorry1', ', this survey for ');
    	$l10n->setKeyValuePair('sorry2', ' of SASS is expired!');
    	$l10n->setKeyValuePair('otherSurveyAsked1', 'We noticed that you have been to ');
    	$l10n->setKeyValuePair('otherSurveyAsked2', ' this semester. ');
    	$l10n->setKeyValuePair('otherSurveyAsked3', ' is an important branch of SASS. Do you have two minutes to complete a survey for ');
    	$l10n->setKeyValuePair('otherSurveyAsked4', ' ? We will be very happy with your answers.');
    	$l10n->setKeyValuePair('sureBtn', 'Sure');
    	$l10n->setKeyValuePair('sorryBtn', 'Sorry');
    	$l10n->setKeyValuePair('doneBtn', 'Done');
    	$l10n->setKeyValuePair('submitErrorMsg', 'An error occurred while submitting the form. Please verify that you have a working Internet connection and try again.');

    	break;
    	
	case 'fr-CA':
		$l10n->setKeyValuePair('title', '(fr)Some title');
    	$l10n->setKeyValuePair('QuestionnaireTitle', '(fr)Questionnaire');
    	$l10n->setKeyValuePair('sorry1', '(fr), this survey for ');
    	$l10n->setKeyValuePair('sorry2', '(fr) of SASS is expired!');
    	$l10n->setKeyValuePair('otherSurveyAsked1', '(fr)We noticed that you have been to ');
    	$l10n->setKeyValuePair('otherSurveyAsked2', '(fr) this semester. ');
    	$l10n->setKeyValuePair('otherSurveyAsked3', '(fr) is an important branch of SASS. Do you have two minutes to complete a survey for ');
    	$l10n->setKeyValuePair('otherSurveyAsked4', '(fr) ? We will be very happy with your answers.');
    	$l10n->setKeyValuePair('sureBtn', '(fr)Sure');
    	$l10n->setKeyValuePair('sorryBtn', '(fr)Sorry');
    	$l10n->setKeyValuePair('doneBtn', '(fr)Done');
    	$l10n->setKeyValuePair('submitErrorMsg', '(fr)An error occurred while submitting the form. Please verify that you have a working Internet connection and try again.');
    	break;
}