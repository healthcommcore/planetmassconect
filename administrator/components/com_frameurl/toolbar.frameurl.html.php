<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.html.toolbar');

	function mycustom($task = '', $msg = '', $icon = '', $iconOver = '', $alt = '', $listSelect = true, $x = false)
	{
		$bar = & JToolBar::getInstance('toolbar');

		//strip extension
		$icon	= preg_replace('#\.[^.]*$#', '', $icon);

		// Add a standard button
		// $bar->appendButton( 'Standard', $icon, $alt, $task, $listSelect, $x );
		if ($msg != '') $bar->appendButton( 'Confirm', $msg, $icon, $alt, $task, $listSelect, $x );
		else $bar->appendButton( 'Standard', $icon, $alt, $task, $listSelect, $x );

		// $bar->appendButton( 'Confirm', 'Are you sure you want to synch this url?', 'delete', $alt, $task, true, false );
	}


class TOOLBAR_Frameurl {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Frame Link' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
	}
	
	function _DEFAULT() {
		JToolBarHelper::title( JText::_('Frame Link'), 'generic.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList('Are you sure you want to remove this Frame Link?','remove');
		JToolBarHelper::addNew();
	
	}

}
class TOOLBAR_frameurl_section {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Section' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );

		JToolBarHelper::save('saveSection');
		// JToolBarHelper::apply();
		JToolBarHelper::cancel('sections');
	}

	function _DEFAULT() {
		JToolBarHelper::title( JText::_('Sections'), 'generic.png');
		JToolBarHelper::editList('editSection');
		JToolBarHelper::deleteList('Are you sure you want to remove this section?','removesection');
		JToolBarHelper::addNew('editSection');
	
	}

}


class TOOLBAR_frameurl_step {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Step' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );

		JToolBarHelper::save('saveStep');
		JToolBarHelper::apply('applyStep');
		JToolBarHelper::cancel('steps');
	}

	function _DEFAULT() {
		JToolBarHelper::title( JText::_('Steps'), 'generic.png');
		JToolBarHelper::editList('editStep');
		JToolBarHelper::deleteList('Are you sure you want to remove this step?','removestep');
		JToolBarHelper::addNew('editStep');
	
	}

}

class TOOLBAR_frameurl_tip {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Tip' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );

		JToolBarHelper::save('saveTip');
		//JToolBarHelper::apply('saveTip');
		JToolBarHelper::cancel('tips');
	}

	function _DEFAULT() {
		JToolBarHelper::title( JText::_('Tips'), 'generic.png');
		JToolBarHelper::editList('editTip');
		JToolBarHelper::deleteList('Are you sure you want to remove this tip?','removetip');
		JToolBarHelper::addNew('editTip');
	
	}

}


?>