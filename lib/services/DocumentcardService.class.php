<?php
class documentcard_DocumentcardService extends f_persistentdocument_DocumentService
{
	/**
	 * @var documentcard_DocumentcardService
	 */
	private static $instance;
	
	/**
	 * @return documentcard_DocumentcardService
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
	 * @return documentcard_persistentdocument_documentcard
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_documentcard/documentcard');
	}
	
	/**
	 * Create a query based on 'modules_documentcard/documentcard' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_documentcard/documentcard');
	}
	
	/**
	 * @param Integer[] $mediaIdsArray
	 * @param Integer $parent
	 */
	public function createNewInstancesFromMediaIds($mediaIdsArray, $parentNodeId, $beforeId, $afterId)
	{
		$documentCardId = null;
		try
		{
			$this->tm->beginTransaction();
			foreach ($mediaIdsArray as $mediaId)
			{
				$media = DocumentHelper::getDocumentInstance($mediaId);
				if (!($media instanceof media_persistentdocument_media) || !$media->isPublished())
				{
					continue;
				}
				$documentCard = $this->getNewDocumentInstance();
				$documentCard->setFile($media);
				$documentCard->setLabel($media->getLabel());
				$documentCard->save();
				$this->moveTo($documentCard, $parentNodeId, $beforeId, $afterId);
				if ($documentCardId == null)
				{
					$documentCardId = $documentCard->getId();
				}
			}
			$this->tm->commit();
		}
		catch (Exception $e)
		{
			$this->tm->rollBack($e);
		}
		return $documentCardId;
	}
	
	/**
	 * @param documentcard_persistentdocument_documentcard $document
	 * @param string $forModuleName
	 * @param array $allowedSections
	 * @return array
	 */
	public function getResume($document, $forModuleName, $allowedSections = null)
	{
		$data = parent::getResume($document, $forModuleName, $allowedSections);
		$media = $document->getFile();
		if ($media->isContextLangAvailable())
		{
			$lang = RequestContext::getInstance()->getLang();
			
		}
		else
		{
			$lang = $media->getLang();
			
		}
		$rc = RequestContext::getInstance();
		try 
		{
			$rc->beginI18nWork($lang);
			$info = $media->getInfo();
			$data['content'] = array(
				'mimetype' => $media->getMimetype() ,
				'size' => $info['size'],
			);			
			
			$data['content']['previewimgurl'] = array('id' => $media->getId(), 'lang' => $lang);
			if ($media->getMediatype() == MediaHelper::TYPE_IMAGE)
			{
				$data['content']['previewimgurl']['image'] = LinkHelper::getDocumentUrl($media, $lang, array('max-height' => 128, 'max-width' => 128));
			}
			else
			{
				$data['content']['previewimgurl']['image'] = '';
			}
			
			$rc->endI18nWork();
		}
		catch (Exception $e)
		{
			$rc->endI18nWork($e);
		}

		return $data;
	}

}