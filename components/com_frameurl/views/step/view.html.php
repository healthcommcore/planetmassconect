<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class FrameurlViewStep extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$model = &$this->getModel();
		$list = $model->getList();
		// print_r($list);
		
		$params 	   =& $mainframe->getParams('com_frameurl');
		
		for ($i = 0; $i < count($list); $i++)
		{
			$row =& $list[$i];
			// Set link   here
			$row->link = JRoute::_('index.php?option=' . $option . '&id=' . $row->id . '&view=url');
		
		}
			
		// If want link to list of all recipes
		// $backlink = JRoute::_('index.php?option='. $option . '&view=all');
		// $print = JRequest::getBool('print');
		
		
		// $this->assignRef('icons', $icons);
		// $this->assignRef('backlink', $backlink);
		$this->assignRef('step', $model->getStep());
		$this->assignRef('list', $list);
		$this->assignRef('option', $option);
		$this->assignRef('params' , $params);
		// $this->assignRef('print', $print);
		parent::display($tpl);
	}

}