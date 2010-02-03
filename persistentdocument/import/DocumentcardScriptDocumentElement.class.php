<?php
class documentcard_DocumentcardScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return documentcard_persistentdocument_documentcard
     */
    protected function initPersistentDocument()
    {
    	return documentcard_DocumentcardService::getInstance()->getNewDocumentInstance();
    }
}