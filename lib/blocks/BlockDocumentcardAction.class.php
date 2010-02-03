<?php
class documentcard_BlockDocumentcardAction extends abstractdirectory_BlockItemAction
{
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('documentcard');
		$this->setComponentName('documentcard');
		$this->setViewModuleName('documentcard');
	}
}

class documentcard_BlockItemSuccessView extends abstractdirectory_BlockItemSuccessView
{
}