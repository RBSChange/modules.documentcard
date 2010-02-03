<?php
/**
 * @date Wed, 17 Sep 2008 07:14:44 +0000
 * @author intstaufl
 * @package modules.documentcard
 */
class documentcard_CreateFromMediasAction extends f_action_BaseJSONAction   
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$parentNodeId = $request->getParameter('parentNodeId');
		$mediaIds = $request->getParameter('mediaIds');
		$beforeId = $request->getParameter('beforeid');
		$afterId = $request->getParameter('afterid');
		if (!is_numeric($parentNodeId) || $mediaIds === null)
		{
			$this->sendJSONError(f_Locale::translateUI("&modules.documentcard.errors.UnexpectedErrorInCreateFromMedias;"));
		}
		try 
		{
			documentcard_DocumentcardService::getInstance()->createNewInstancesFromMediaIds($mediaIds, $parentNodeId, $beforeId, $afterId);
		}
		catch (Exception $e)
		{
			Framework::exception($e);
			$this->sendJSONException($e);
		}
		$this->sendJSON("");
	}
}