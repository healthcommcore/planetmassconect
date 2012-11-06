<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class PContactViewCategory extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$model = &$this->getModel();
		$list = $model->getList();
		
		$params 	   =& $mainframe->getParams('com_pcontact');
		
		for ($i = 0; $i < count($list); $i++)
		{
			$row =& $list[$i];
			// Set link   here
			// Must hard-code menu item ID so as to remain within Step 2
			$row->link = JRoute::_('index.php?option=' . $option . '&id=' . $row->id . '&view=contact&Itemid=9');
		
		}
		
		$this->assignRef('category', $model->getCategory());
		$this->assignRef('list', $list);
		$this->assignRef('option', $option);
		$this->assignRef('params' , $params);
		parent::display($tpl);
	}

}