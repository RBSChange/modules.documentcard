<?php
class documentcard_ViewDetailAction extends f_action_BaseAction
{
/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		try
		{
			$document = $this->getDocumentInstanceFromRequest($request);
			if ($document instanceof documentcard_persistentdocument_documentcard) 
			{
				$url = LinkHelper::getDocumentUrl($document->getFile());
				$context->getController()->redirectToUrl($url);
				return View::NONE;
			}
		}
		catch (Exception $e)
		{
			Framework::exception($e);	
		}
		$context->getController()->forward(AG_ERROR_404_MODULE, AG_ERROR_404_ACTION);
		return View::NONE;
	}

	/**
	 * @param Request $request
	 */
	protected function getDocumentIdArrayFromRequest($request)
	{
		$documentId = $request->getModuleParameter('documentcard', K::COMPONENT_ID_ACCESSOR);
		if (null === $documentId)
		{
			$documentId = $request->getParameter(K::COMPONENT_ID_ACCESSOR);
		}
		if (intval($documentId) > 0)
		{
			return array(intval($documentId));
		}
		return array();
	}

	public function isSecure()
	{
		return false;
	}
}