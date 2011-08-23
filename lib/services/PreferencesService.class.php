<?php
/**
 * @date Tue, 26 Jun 2007 11:53:39 +0200
 * @author intcoutl
 */
class documentcard_PreferencesService extends f_persistentdocument_DocumentService
{
	/**
	 * @var documentcard_PreferencesService
	 */
	private static $instance;

	/**
	 * @return documentcard_PreferencesService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return documentcard_persistentdocument_preferences
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_documentcard/preferences');
	}

	/**
	 * Create a query based on 'modules_documentcard/preferences' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_documentcard/preferences');
	}
	
	/**
	 * @param documentcard_persistentdocument_preferences $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId)
	{
		$document->setLabel('&modules.documentcard.bo.general.Module-name;');
	}
}