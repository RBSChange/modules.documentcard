<?php
class documentcard_PreferencesScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return documentcard_persistentdocument_preferences
     */
    protected function initPersistentDocument()
    {
    	$document = ModuleService::getInstance()->getPreferencesDocument('documentcard');
    	return ($document !== null) ? $document : documentcard_PreferencesService::getInstance()->getNewDocumentInstance();
    }
}