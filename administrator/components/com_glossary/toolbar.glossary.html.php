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
	}


class TOOLBAR_Glossary {
	function _NEW() {
		JToolBarHelper::title( JText::_( 'Glossary Entries' ).': <small><small>[ Edit ]</small></small>', 'addedit.png' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
	}
	
	function _DEFAULT() {
		JToolBarHelper::title( JText::_( 'Glossary Entries'), 'generic.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::editList();
		JToolBarHelper::deleteList('Are you sure you want to remove this Glossary Entry?','remove');
		JToolBarHelper::addNew();
	
	}

}


?>