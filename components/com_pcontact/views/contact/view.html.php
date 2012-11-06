<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class PcontactViewContact extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$model = &$this->getModel();
		
		// $glossary = $model->getList();
		// $sets = $model->getSets();
		// print_r($sets);
		
		// $total = $model->getTotal();
		
		$params 	   =& $mainframe->getParams('com_pcontact');
		// $limit = $params->get('limit', $mainframe->getCfg('list_limit'));
		// $limitstart = JRequest::getVar( 'limitstart', 0);
		$itemid = $params->get('Itemid', 0);
		
		if (! $itemid) {
		
			$itemid = JRequest::getVar('Itemid', 0);
		}
		$contact = $model->getContact();
		$category = $model->getCategory();
		
		
		$this->assignRef('contact', $contact);
		$this->assignRef('category', $category);
		// $this->assignRef('backlink', $backlink);
		$this->assignRef('option', $option);
		$this->assignRef('params' , $params);
		// $this->assignRef('total', $total);
		// $this->assignRef('sets', $sets);
		$this->assignRef('itemid', $itemid);
		// $this->assignRef('setData', $setData);
		// $this->assignRef('entry', $entry);
		$this->assignRef('backlink', $backlink);
		$this->assignRef('backtext', $backtext);
		// $this->assignRef('print', $print);
		parent::display($tpl);




	}

}