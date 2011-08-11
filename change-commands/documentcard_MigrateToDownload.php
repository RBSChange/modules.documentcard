<?php
/**
 * commands_documentcard_MigrateToDownload
 * @package modules.documentcard.command
 */
class commands_documentcard_MigrateToDownload extends commands_AbstractChangeCommand
{
	/**
	 * @return String
	 * @example "<moduleName> <name>"
	 */
	public function getUsage()
	{
		return "<describe usage here>";
	}

	/**
	 * @return String
	 * @example "initialize a document"
	 */
	public function getDescription()
	{
		return "<describe your command here>";
	}

	/**
	 * @param String[] $params
	 * @param array<String, String> $options where the option array key is the option name, the potential option value or true
	 * @see c_ChangescriptCommand::parseArgs($args)
	 */
	public function _execute($params, $options)
	{
		$this->message("== MigrateToDownload ==");
				
		$this->executeSQLQuery("INSERT INTO m_download_doc_documentcard (document_id, document_model, document_label, document_author, document_authorid, document_creationdate, document_modificationdate, document_publicationstatus, document_lang, document_modelversion, document_startpublicationdate, document_endpublicationdate, document_metas, file, description, visual, document_version) SELECT document_id, 'modules_download/documentcard' AS document_model, document_label, document_author, document_authorid, document_creationdate, document_modificationdate, document_publicationstatus, document_lang, document_modelversion, document_startpublicationdate, document_endpublicationdate, document_metas, file, REPLACE(comment, '\n', '<br />') AS description, image AS visual, 0 FROM m_documentcard_doc_documentcard;");
		$this->executeSQLQuery("INSERT INTO m_download_doc_documentcard_i18n (document_id, lang_i18n, document_label_i18n, document_publicationstatus_i18n, description_i18n) SELECT document_id, lang_i18n, document_label_i18n, document_publicationstatus_i18n, REPLACE(comment_i18n, '\n', '<br />') AS description_i18n FROM m_documentcard_doc_documentcard_i18n;");
		$this->executeSQLQuery("UPDATE f_document SET document_model = 'modules_download/documentcard' WHERE document_model = 'modules_documentcard/documentcard';");
		$this->executeSQLQuery("UPDATE f_relation SET document_model_id1 = 'modules_download/documentcard' WHERE document_model_id1 = 'modules_documentcard/documentcard';");
		$this->executeSQLQuery("UPDATE f_relation SET document_model_id2 = 'modules_download/documentcard' WHERE document_model_id2 = 'modules_documentcard/documentcard';");
		$this->executeSQLQuery("TRUNCATE f_cache;");
		
		$tm = f_persistentdocument_TransactionManager::getInstance();
		$ts = TreeService::getInstance();
		$tfs = download_TreefolderService::getInstance();
		$folder = $tfs->getNewDocumentInstance();
		$folder->setLabel('Importé depuis documentcard');
		$folder->save(ModuleService::getInstance()->getRootFolderId('download'));
		$parentNode = $ts->getInstanceByDocument($folder);		
		
		foreach (download_DocumentcardService::getInstance()->createQuery()->add(Restrictions::eq('modelversion', '1.0'))->find() as $doc)
		{
			try
			{
				$tm->beginTransaction();
				
				$doc->addTopic($doc->getDocumentService()->getParentOf($doc));
				$doc->setModelversion('3.5');
				$doc->save();
				
				$oldNode = $ts->getInstanceByDocument($doc);
				if ($oldNode !== null)
				{
					$ts->deleteNode($oldNode);
				}
				$ts->newLastChildForNode($parentNode, $doc->getId());
							
				$tm->commit();
			}
			catch (Exception $e)
			{
				throw $tm->rollBack($e);
			}
		}
		
		$this->executeSQLQuery("TRUNCATE f_cache;");
		$this->executeSQLQuery("TRUNCATE m_documentcard_doc_documentcard;");
		$this->executeSQLQuery("TRUNCATE m_documentcard_doc_documentcard_i18n;");
		
		$this->quitOk("Command successfully executed");
	}
	
	/**
	 * @param String $query
	 * @return Integer the number of affected rows
	 * @author intbonjf
	 */
	protected final function executeSQLQuery($query)
	{
		$query = trim($query);
		if (strlen($query) > 0)
		{
			return f_persistentdocument_PersistentProvider::getInstance()->executeSQLScript($query);
		}
	}
}