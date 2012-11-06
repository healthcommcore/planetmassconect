<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.model');
class ModelFrameurlUrl extends JModel
{
	var $_url = null;
	var $_id = null;
	var $_step = null;
	var $_tips = null;

	function __construct()
	{
		global $mainframe;
		parent::__construct();
		// First check if an ID has been set up as a parameter
		$params = $mainframe->getParams('com_frameurl');
		$id = $params->get('id', 0);
		
		if (! $id) {
		
			$id = JRequest::getVar('id', 0);
		}
		$this->_id = $id;
	}

	function getUrl()
	{
		global $mainframe;
		if (!$this->_url)
		
		{
		
			// For Step page, retrieve all links for the page
			// Get the menu item object
			$menus = &JSite::getMenu();
			$menu  = $menus->getActive();
			
			// Get the page/component configuration
			$params = $mainframe->getParams('com_frameurl');
			$id = $params->get('id', '');
			
			$query = "SELECT * FROM #__pmc_url WHERE published = '1' AND id = " . $this->_id; 
			$this->_db->setQuery( $query);
			// echo $query;
			$this->_url = $this->_db->loadObject();
		}
		return $this->_url;
	}

	function getUrlStep()
	{
		global $mainframe;
		if (!$this->_step) {
			$params = $mainframe->getParams('com_frameurl');
			// Check command line param first
			$step = JRequest::getVar( 'step', '');
			if (empty($step)) 
				$step = $params->get('step', '');
			
			$query = "SELECT s.title, s.description FROM #__pmc_step s, #__pmc_url u WHERE s.id = u.stepID AND u.id = " . $this->_id;
			// echo $query;
			
			$this->_db->setQuery( $query);
			$this->_step = $this->_db->loadObject();
			// print_r($this->_step);
		}
		return $this->_step;
	}
	// Retrieve all the tips for 
	//	a PDF (if $pdf = true)
	//  a Web (if $pdf == false)
	// This list is independent of the  Step or specific iFrame (except for its type)
	function getUrlTips($pdf)
	{
		global $mainframe;
		// if (!$this->_tips) {
			// $params = $mainframe->getParams('com_frameurl');
			// Check command line param first
			
			
			$query = "SELECT * FROM #__pmc_tip WHERE " . ($pdf ? 'iframePDF': 'iframeWeb') . "= 1 AND published = 1 order by ordering";
			// echo $query;
			
			$this->_db->setQuery( $query);
			$this->_tips = $this->_getList( $query, 0, 0);
			// $this->_tips = $this->_db->loadObject();
			// print_r($this->_tips);
		// }
		return $this->_tips;
	}


}
?>