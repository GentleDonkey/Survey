<?php

if (!isset($l10n)) {
    $l10n = new L10nTranslate();
}

/*foreach($accommodations as &$groups) {
    foreach($groups as &$a) {
        switch($l10n->getLanguage()) {
            case 'en-CA':
                $a['name'] = $a['name_en'];
                break;
            case 'fr-CA':
                $a['name'] = $a['name_fr'];
                break;
        }

        unset($a['name_en'], $a['name_fr']);
    }
}
unset($a, $groups);*/

switch ($l10n->getLanguage()) {
    case 'en-CA':
        //$l10n->setKeyValuePair('documentTitleTag', 'Accommodation management');
        $l10n->setKeyValuePair('pageTitle', 'Survey Questionnaire Management');
        $l10n->setKeyValuePair('dropdownlistDefault', 'Please select a service');
        $l10n->setKeyValuePair('prioritiesSectionTitle', 'Questions priorities');
        //$l10n->setKeyValuePair('dragDrogPlaceholder', 'Drag and drop here as needed…');
        $l10n->setKeyValuePair('deleteSectionTitle', 'Questions not shown on the questionnaire');
        //$l10n->setKeyValuePair('submitBtn', 'Save');
        break;

    case 'fr-CA':
        //$l10n->setKeyValuePair('documentTitleTag', 'Gestion des mesures adaptées');
        $l10n->setKeyValuePair('pageTitle', 'Some French');
        $l10n->setKeyValuePair('dropdownlistDefault', 'Some French');
        $l10n->setKeyValuePair('prioritiesSectionTitle', 'Some French');
        //$l10n->setKeyValuePair('dragDrogPlaceholder', 'Glisser-déplacer selon les besoins…');
        $l10n->setKeyValuePair('deleteSectionTitle', 'Some French');
        //$l10n->setKeyValuePair('submitBtn', 'Some French');
        break;
}