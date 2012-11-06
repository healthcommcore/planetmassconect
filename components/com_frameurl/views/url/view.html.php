<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class FrameurlViewUrl extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$model = &$this->getModel();
		
		$url = $model->getUrl();
		$step = $model->getUrlStep();
		$tips = $model->getUrlTips($url->pdf);

		$params 	   =& $mainframe->getParams('com_frameurl');
		
		$itemid = $params->get('Itemid', 0);
		
		if (! $itemid) {
		
			$itemid = JRequest::getVar('Itemid', 0);
		}
		if ($itemid) {
		
			$backlink = JRoute::_('index.php?option='. $option . '&view=step&Itemid=' . $itemid);
		} else $backlink ='';
	
		
		$this->assignRef('step', $step);
		$this->assignRef('url', $url);
		$this->assignRef('tips', $tips);
		
		$this->assignRef('backlink', $backlink);
		$this->assignRef('option', $option);
		$this->assignRef('params' , $params);
		parent::display($tpl);




	}

}