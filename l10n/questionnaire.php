<?php

if (!isset($l10n)) {
    $l10n = new L10nTranslate();
}

$sub_org_counselling_name = unserialize(ORG_SUB_ORG_COUNSELLING_SERVICE_NAME);

switch ($l10n->getLanguage()) {
    case 'en-CA':
    	$l10n->setKeyValuePair('title', 'SASS Service Evaluation Form - ');
    	$l10n->setKeyValuePair('QuestionnaireTitle', 'Some title');
    	$l10n->setKeyValuePair('helloSASS1', 'Hello, ');
    	$l10n->setKeyValuePair('helloSASS2', '! Please help us improve our SASS services by answering some questions about the services you have received. We are interested in your honest opinions, whether they are positive or negative. Please answer all of the questions. We also welcome your comments and suggestions for improvements of our SASS services. Thank you, we appreciate your help.');
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
		$l10n->setKeyValuePair('title', 'Questionnaire de satisfaction des services du SASS - ');
    	$l10n->setKeyValuePair('QuestionnaireTitle', '(fr)Some title');
    	$l10n->setKeyValuePair('helloSASS1', 'Bonjour ');
    	$l10n->setKeyValuePair('helloSASS2', '! Merci de nous aider à améliorer les services du SASS en répondant à quelques questions sur le service que vous avez utilisé. Nous souhaitons obtenir votre opinion sincère, quelle soit positive ou négative, et vous prions de répondre à toutes les questions. Vos commentaires et suggestions sont également les bienvenus. Merci, nous apprécions votre rétroaction.');
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