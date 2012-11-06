<?php

defined ( '_JEXEC') or die ('Restricted access');
require_once( JApplicationHelper::getPath('toolbar_html'));

switch($task)
{
	case 'edit':
	case 'add':
		TOOLBAR_PContact::_NEW();
		break;
	case 'categories':
	case 'saveCategories':
	case 'removeCategory':
		TOOLBAR_PContact_category::_DEFAULT();
		break;

	case 'editCategory':
		TOOLBAR_PContact_category::_NEW();
		break;
	default:
		TOOLBAR_PContact::_DEFAULT();
		break;

}

?>