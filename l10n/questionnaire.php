<?php

if (!isset($l10n)) {
    $l10n = new L10nTranslate();
}

$sub_org_counselling_name = unserialize(ORG_SUB_ORG_COUNSELLING_SERVICE_NAME);

switch ($l10n->getLanguage()) {
    case 'en-CA':
    	$l10n->setKeyValuePair('title', 'Some title');
    	$l10n->setKeyValuePair('QuestionnaireTitle', 'Questionnaire of SASS');
    	$l10n->setKeyValuePair('helloSASS1', 'Hello, ');
    	$l10n->setKeyValuePair('helloSASS2', '! SASS committed to offering excellent client services. Please tell us what you think about SASS and ');
    	$l10n->setKeyValuePair('helloSASS3', ' of SASS.');
    	$l10n->setKeyValuePair('colHeaderQuestionContent', 'Question');
    	$l10n->setKeyValuePair('colHeaderQuestionAnswer', 'YourAnswer');
    	$l10n->setKeyValuePair('colHeaderQuestionComment', 'YourComment');
    	$l10n->setKeyValuePair('1stLevelAnswer', 'Excellent');
    	$l10n->setKeyValuePair('2ndLevelAnswer', 'Very Good');
    	$l10n->setKeyValuePair('3rdLevelAnswer', 'Good');
    	$l10n->setKeyValuePair('4thLevelAnswer', 'Not Very Well');
    	$l10n->setKeyValuePair('5thLevelAnswer', 'Unsatisfied');
    	$l10n->setKeyValuePair('submitBtn', 'Submit');
    	$l10n->setKeyValuePair('submitErrorMsg', 'An error occurred while submitting the form. Please verify that you have a working Internet connection and try again.');
    	$l10n->setKeyValuePair('requiredRadioButton', 'Please select one of these options');
    	break;
    	
	case 'fr-CA':
		$l10n->setKeyValuePair('title', '(fr)Some title');
    	$l10n->setKeyValuePair('QuestionnaireTitle', '(fr)Questionnaire of SASS');
    	$l10n->setKeyValuePair('helloSASS1', '(fr)Hello');
    	$l10n->setKeyValuePair('helloSASS2', '(fr)! SASS committed to offering excellent client services. Please tell us what you think about ');
    	$l10n->setKeyValuePair('helloSASS3', '(fr).');
    	$l10n->setKeyValuePair('colHeaderQuestionContent', '(fr)Question');
    	$l10n->setKeyValuePair('colHeaderQuestionAnswer', '(fr)YourAnswer');
    	$l10n->setKeyValuePair('colHeaderQuestionComment', '(fr)YourComment');
    	$l10n->setKeyValuePair('1stLevelAnswer', '(fr)Excellent');
    	$l10n->setKeyValuePair('2ndLevelAnswer', '(fr)Very Good');
    	$l10n->setKeyValuePair('3rdLevelAnswer', '(fr)Good');
    	$l10n->setKeyValuePair('4thLevelAnswer', '(fr)Not Very Well');
    	$l10n->setKeyValuePair('5thLevelAnswer', '(fr)Unsatisfied');
    	$l10n->setKeyValuePair('submitBtn', '(fr)Submit');
    	$l10n->setKeyValuePair('submitErrorMsg', '(fr)An error occurred while submitting the form. Please verify that you have a working Internet connection and try again.');
    	$l10n->setKeyValuePair('requiredRadioButton', '(fr)Please select one of these options');
    	break;
}