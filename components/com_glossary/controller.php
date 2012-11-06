<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class GlossaryController extends JController
{
	// display() function called by default

	function display()
	{
		$document =& JFactory::getDocument();
	
		
		// Requested view - default 'glossary'
		$viewName = JRequest::getVar( 'view', 'glossary');
		
		

		// Multiple document type - default 'HTML'. Others may be RSS
		// -> run-time error on Mac OSX, ok on Ubuntu
		//$viewType = $document::getType();	
		// $view = &$this->getView($viewName, $viewType);
		$view = &$this->getView($viewName,'html');
		$model =& $this->getModel($viewName, 'ModelGlossary');
		
		// Check that model exists
		if (!JError::isError( $model)) {
			$view->setModel( $model, true);
		}
		
		// set layout - default 'default'
		$term = JRequest::getVar( 'term', '');
		$cid = JRequest::getVar( 'cid', '');
		if ( ! empty($term) || ! empty($cid) ) {
			// $entry = $model->getEntry($term);
			$view->setLayout('entry');
		}
		/*
		elseif ( ! empty($cid)) {
			$view->setLayout('id');
		}
		*/
		else {
		
			$view->setLayout('default');
		}
		$view->display();
		
	}

}

?>
