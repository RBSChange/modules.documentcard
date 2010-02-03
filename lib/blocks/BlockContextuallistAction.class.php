<?php
class documentcard_BlockContextuallistAction extends abstractdirectory_BlockContextuallistAction
{
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('documentcard');
		$this->setComponentName('documentcard');
	}
}