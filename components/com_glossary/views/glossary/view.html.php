<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class GlossaryViewGlossary extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$model = &$this->getModel();
		
		// $glossary = $model->getList();
		// $sets = $model->getSets();
		// print_r($sets);
		
		$total = $model->getTotal();
		
		$params 	   =& $mainframe->getParams('com_glossary');
		// $limit = $params->get('limit', $mainframe->getCfg('list_limit'));
		// $limitstart = JRequest::getVar( 'limitstart', 0);
		$itemid = JRequest::getVar( 'Itemid', 0);
		
		
		// Term or cid overrides other params

		$term = JRequest::getVar( 'term', '');
		$cid = JRequest::getVar( 'cid', '');
		$backlink = JRequest::getVar( 'back', '');
		$backtext = JRequest::getVar( 'backtxt', '');
		if ( ! empty($term)) $entry = $model->getEntry($term);
		elseif ( ! empty($cid)) $entry = $model->getEntryID( $cid);
		else {
			// Default to all if none requested
			// $set = JRequest::getVar( 'set', $sets[0]);
			// >> handle blank set
			// $setData = $model->getSetData($set);
			$setData = $model->getList();
		}
	
		// $print = JRequest::getBool('print');
		
		
		// $this->assignRef('glossary', $glossary);
		// $this->assignRef('backlink', $backlink);
		$this->assignRef('option', $option);
		$this->assignRef('params' , $params);
		$this->assignRef('total', $total);
		$this->assignRef('sets', $sets);
		$this->assignRef('itemid', $itemid);
		$this->assignRef('setData', $setData);
		$this->assignRef('entry', $entry);
		$this->assignRef('backlink', $backlink);
		$this->assignRef('backtext', $backtext);
		// $this->assignRef('print', $print);
		parent::display($tpl);




	}

}