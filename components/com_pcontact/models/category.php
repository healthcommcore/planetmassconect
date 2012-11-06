<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.model');
class ModelPContactCategory extends JModel
{
	var $_list = null;
	var $_category = null;
	var $_id = null;
	
	function __construct()
	{
		global $mainframe;
		parent::__construct();
		
		// First check if an ID has been set up as a parameter
		$params = $mainframe->getParams('com_pcontact');
		$id = $params->get('catID', 0);
		
		if (! $id) {
		
			$id = JRequest::getVar('catID', 0);
		}
		$this->_id = $id;
	}
	
	function getList()
	{
		global $mainframe;
		if (!$this->_list)
		
		{
		
			// For Step page, retrieve all links for the page
			// Get the menu item object
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			
			// Get the page/component configuration
			$params = $mainframe->getParams('com_pcontact');
			
		
			// Order by:
			// 	section (and in section order), then url order
			$query = "SELECT co.id, co.organization, co.institution, co.specialty  FROM #__pmc_contact co WHERE co.published = '1' AND co.catID = $this->_id ORDER BY co.organization";
			// echo $query;
			
			$this->_list = $this->_getList( $query, 0, 0);
		}
		return $this->_list;
	}
	function getCategory()
	{
		global $mainframe;
		if (!$this->_category) {
			$params = $mainframe->getParams('com_pcontact');
			
			$query = "SELECT name FROM #__pmc_contact_cat WHERE id = $this->_id";
			$this->_db->setQuery( $query);
			$cat = $this->_db->loadObject();
			$this->_category = $cat->name;
		}
		return $this->_category;
	}
}
?>