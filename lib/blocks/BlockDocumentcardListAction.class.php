<?php
class documentcard_BlockDocumentcardListAction extends abstractdirectory_BlockListAction
{
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('documentcard');
		$this->setComponentName('documentcard');
	}
}