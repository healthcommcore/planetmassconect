<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.model');
class ModelPContactContact extends JModel
{
	var $_contact = null;
	var $_id = null;
	var $_cat = null;

	function __construct()
	{
		global $mainframe;
		parent::__construct();
		
		// First check if an ID has been set up as a parameter
		$params = $mainframe->getParams('com_pcontact');
		$id = $params->get('id', 0);
		
		if (! $id) {
		
			$id = JRequest::getVar('id', 0);
		}
		$this->_id = $id;
	}

	function getContact()
	{
		global $mainframe;
		if (!$this->_contact)
		
		{
		
			// For Step page, retrieve all links for the page
			// Get the menu item object
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			
			// Get the page/component configuration
			$params = $mainframe->getParams('com_pcontact');
			$id = $params->get('id', '');
			
			$query = "SELECT * FROM #__pmc_contact WHERE published = '1' AND id = " . $this->_id; 
			$this->_db->setQuery( $query);
			// echo $query;
			$this->_contact = $this->_db->loadObject();
		}
		return $this->_contact;
	}

	function getCategory()
	{
		global $mainframe;
		if (!$this->_cat) {
			$params = $mainframe->getParams('com_pcontact');
			// Check command line param first
			
			$query = "SELECT name FROM #__pmc_contact co, #__pmc_contact_cat ca WHERE co.id = $this->_id AND ca.id = co.catID";
			// echo $query;
			
			$this->_db->setQuery( $query);
			$row = $this->_db->loadObject();
			$this->_cat = $row->name;
		}
		return $this->_cat;
	}
}
?>