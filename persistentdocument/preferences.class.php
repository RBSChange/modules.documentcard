<?php
/**
 * documentcard_persistentdocument_preferences
 * @package documentcard
 */
class documentcard_persistentdocument_preferences extends documentcard_persistentdocument_preferencesbase 
{
	/**
	 * @see f_persistentdocument_PersistentDocumentImpl::getLabel()
	 *
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translateUI(parent::getLabel());
	}
}