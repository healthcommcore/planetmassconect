<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.model');
class ModelGlossaryGlossary extends JModel
{
	var $_id = null;
	var $_glossary = null;
	var $_set = null;
	var $_entry = null;
	var $_sets = array(
		'ABC',
		'DEF',
		'GHI',
		'JKLM',
		'NOPQ',
		'RST',
		'UVWXYZ'
	);
	function __construct()
	{
		global $mainframe;
		parent::__construct();
		/*
		// First check if an ID has been set up as a parameter
		$params = $mainframe->getParams('com_glossary');
		$id = $params->get('id', 0);
		
		if (! $id) {
		
			$id = JRequest::getVar('id', 0);
		}
		$this->_id = $id;
		*/
	}
	function getTotal()
	{
		$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' ORDER BY term ASC"; 
		//  a query without limits to get total
		$this->_total = count($this->_getList( $query, 0, 0));
		return $this->_total;
	}
	function getList()
	{
		global $mainframe;
		if (!$this->_glossary)
		
		{
			// Get the page/component configuration
			$params = $mainframe->getParams('com_glossary');
			$id = $params->get('id', '');
			// $limitstart = JRequest::getVar( 'limitstart', 0);
			// $limit = $params->get('limit', $mainframe->getCfg('list_limit'));
			/*
			if ($limitstart)
		
				$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' ORDER BY term ASC LIMIT $limitstart, $limit"; 
			
			else
				$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' ORDER BY term ASC LIMIT $limit"; 
			*/
			
			$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' ORDER BY term ASC"; 

			$this->_set = $this->_getList( $query, 0, 0);
			// $this->_glossary = $this->_getList( $query, 0, 0);
			// echo $query;
		}
		// return $this->_glossary;
		return $this->_set;
	}
	function getSets()
	{
		return $this->_sets;
	}
	function getSetData( $set)
	{
		global $mainframe;
		if (!$this->_set)
		
		{
			// Get the page/component configuration
			// $params = $mainframe->getParams('com_glossary');
			// $id = $params->get('id', '');
			$wheresql = '';
			for ($i = 0; $i < strlen($set); $i++) {
				$wheresql =   (empty($wheresql)? '': $wheresql. ' OR ') . " LOWER(term) LIKE '" . strtolower($set[$i])."%'";
			}
			$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' AND ($wheresql) ORDER BY term ASC"; 
			// echo $query;

			$this->_set = $this->_getList( $query, 0, 0);
		}
		return $this->_set;
	}
	function getEntry( $term)
	{
		global $mainframe;
		if (!$this->_entry)
		
		{
			// Get the page/component configuration
			$params = $mainframe->getParams('com_glossary');

			// $query = "SELECT * FROM #__pmc_glossary WHERE published = '1' AND LOWER(term) = '" . strtolower($term)."%'";
			$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' AND LOWER(term) = '" . strtolower($term)."'";

			$this->_glossary = $this->_getList( $query, 0, 0);
			// echo $query;
			$this->_entry = $this->_db->loadObject();
		}
		return $this->_entry;
	}
	function getEntryID ( $id)
	{
		global $mainframe;
		if (!$this->_entry)
		
		{
			// Get the page/component configuration
			$params = $mainframe->getParams('com_glossary');

			$query = "SELECT * FROM #__pmc_glossary WHERE published = '1' AND id = $id";

			$this->_glossary = $this->_getList( $query, 0, 0);
			// echo $query;
			$this->_entry = $this->_db->loadObject();
		}
		return $this->_entry;
	}
}
?>