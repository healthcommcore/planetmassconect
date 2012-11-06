<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableFrameurl extends JTable

{
	var $id = null;
	var $title = null;
	var $url = null;
	var $description = null;
	var $instructions = null;
	var $author = null;
	var $sectionID = null;
	var $stepID = null;
	var $ordering = null;
	var $pdf = null;
	var $modified = null;
	var $published = true;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_url', 'id', $db);
	}
	

	
	/**
	 * Method to move an URL
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function moveframeurl($direction)
	{
		
		/*
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		*/

		if (!$this->move( $direction, ' stepID = '.(int) $this->stepID.' AND '. ' sectionID = '.(int) $this->sectionID  )) {

			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
}
?>