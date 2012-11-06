<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableSection extends JTable

{
	var $id = null;
	var $name = null;
	var $title = null;
	var $description = null;
	var $stepID = null;
	var $ordering = null;
	// var $published = true;

	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_section', 'id', $db);
	}
	/**
	 * Method to move an URL
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function movesection($direction)
	{
		// echo '<br><br>movesection move: '. $direction. '<br><br>';
		
		/*
		if (!$row->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		*/

		if (!$this->move( $direction, ' stepID = '.(int) $this->stepID )) {

			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
}
?>