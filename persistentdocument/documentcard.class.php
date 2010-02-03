<?php
class documentcard_persistentdocument_documentcard extends documentcard_persistentdocument_documentcardbase implements indexer_IndexableDocument{
	/**
	 * Get the indexable document
	 *
	 * @return indexer_IndexedDocument
	 */
	public function getIndexedDocument()
	{
		$indexedDoc = new indexer_IndexedDocument();
		$indexedDoc->setId($this->getId());
		$indexedDoc->setDocumentModel('modules_documentcard/documentcard');
		$indexedDoc->setLabel($this->getLabel());
		$indexedDoc->setLang(RequestContext::getInstance()->getLang());
		$indexedDoc->setText($this->getFullTextForIndexation()); 
		return $indexedDoc;
	}
	
	/**
	 * @return String
	 */
	private function getFullTextForIndexation()
	{
		$fullText = ""; 
		$media = $this->getFile();
		if ($media !== null)
		{
			$mediaIndexedDocument = $media->getIndexedDocument();
			if ($mediaIndexedDocument !== null)
			{
				$fullText = $mediaIndexedDocument->getLabel() . " : " . $mediaIndexedDocument->getText();
			}
		}
		$fullText .= " " . $this->getComment();
		return $fullText;
	}
}