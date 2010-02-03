<?php
class documentcard_Setup extends object_InitDataSetup
{

	public function install()
	{
		try
		{
			$this->executeModuleScript('init.xml');
		}
		catch (Exception $e)
		{
			echo "ERROR: " . $e->getMessage() . "\n";
			Framework::exception($e);
		}
	}
}