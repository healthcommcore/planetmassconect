<?php

defined ( '_JEXEC') or die ('Restricted access');
require_once( JApplicationHelper::getPath('toolbar_html'));
//echo 'task =' . $task;

switch($task)
{
	case 'edit':
	case 'add':
		TOOLBAR_Frameurl::_NEW();
		break;
	case 'sections':
	case 'saveSection':
	case 'removeSection':
		TOOLBAR_frameurl_section::_DEFAULT();
		break;

	case 'editSection':
		TOOLBAR_frameurl_section::_NEW();
		break;
	case 'steps':
	case 'saveStep':
	case 'removeStep':
		TOOLBAR_frameurl_step::_DEFAULT();
		break;

	case 'editStep':
		TOOLBAR_frameurl_step::_NEW();
		break;

	case 'tips':
	case 'saveTip':
	case 'removeTip':
		TOOLBAR_frameurl_tip::_DEFAULT();
		break;

	case 'editTip':
		TOOLBAR_frameurl_tip::_NEW();
		break;
		
	default:
		TOOLBAR_Frameurl::_DEFAULT();
		break;

}

?>