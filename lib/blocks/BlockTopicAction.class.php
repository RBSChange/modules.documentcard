<?php
class documentcard_BlockTopicAction extends abstractdirectory_BlockTopicAction
{
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('documentcard');
		$this->setComponentName('documentcard');
	}
}