<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableTip extends JTable

{
	var $id = null;
	var $title = null;
	var $description = null;
	var $contentID = 0;
	var $contentType = null;
	var $iframePDF = false;
	var $iframeWeb = false;
	var $modified = null;
	var $ordering = null;
	var $published = true;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_tip', 'id', $db);
	}
	
	/**
	 * Method to move a tip
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function movetip($direction)
	{
		
		/*
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		*/

		if (!$this->move( $direction, true  )) {

			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	
}
?>