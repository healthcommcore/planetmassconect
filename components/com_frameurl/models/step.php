<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.model');
class ModelFrameurlStep extends JModel
{
	var $_urls = null;
	var $_step = null;
	
	function getList()
	{
		global $mainframe;
		if (!$this->_urls)
		
		{
		
			// For Step page, retrieve all links for the page
			// Get the menu item object
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			
			// Get the page/component configuration
			$params = $mainframe->getParams('com_frameurl');
			$step = JRequest::getVar( 'step', '');
			if (empty($step)) 
				$step = $params->get('step', '');
			
		
			// Order by:
			// 	section (and in section order), then url order
			$query = "SELECT DISTINCT u.*,s.title as step, se.title as section, se.description as sectiondescription  FROM #__pmc_url u JOIN #__pmc_step s ON u.stepID = s.id JOIN #__pmc_section se ON u.sectionID = se.id WHERE u.published = '1' AND s.id = $step ORDER BY se.ordering, u.ordering, u.title";
			// echo $query;
				
			
			$this->_urls = $this->_getList( $query, 0, 0);
			// print_r($this->_urls);	
		}
		return $this->_urls;
	}
	function getStep()
	{
		global $mainframe;
		if (!$this->_step) {
			$params = $mainframe->getParams('com_frameurl');
			// Check command line param first
			$step = JRequest::getVar( 'step', '');
			if (empty($step)) 
				$step = $params->get('step', '');
			
			$query = "SELECT title, description FROM #__pmc_step s WHERE id = $step";
			$this->_db->setQuery( $query);
			$this->_step = $this->_db->loadObject();
		}
		return $this->_step;
	}
}
?>