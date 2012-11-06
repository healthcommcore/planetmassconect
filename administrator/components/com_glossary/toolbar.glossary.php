<?php

defined ( '_JEXEC') or die ('Restricted access');
require_once( JApplicationHelper::getPath('toolbar_html'));
// echo 'task =' . $task;

switch($task)
{
	case 'edit':
	case 'add':
		TOOLBAR_Glossary::_NEW();
		break;
		
	default:
		TOOLBAR_Glossary::_DEFAULT();
		break;

}

?>