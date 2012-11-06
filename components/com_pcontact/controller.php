<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class PContactController extends JController
{
	// display() function called by default

	function display()
	{
		$document =& JFactory::getDocument();
		
		// Requested view - default 'category'
		// $viewName = JRequest::getVar( 'view', 'category');
		$viewName = JRequest::getVar( 'view', 'contact');
		
		// Multiple document type - default 'HTML'. Others may be RSS
		// -> run-time error on Mac OSX, ok on Ubuntu
		//$viewType = $document::getType();	
		// $view = &$this->getView($viewName, $viewType);
		$view = &$this->getView($viewName,'html');
		
		$model =& $this->getModel($viewName, 'ModelPContact');
		
		// Check that model exists
		if (!JError::isError( $model)) {
			$view->setModel( $model, true);
		}
		
		// set layout - default 'default'

		$view->setLayout('default');
		$view->display();
		
	}

}

?>
