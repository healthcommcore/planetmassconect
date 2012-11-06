<?php

defined ( '_JEXEC') or die ('Restricted access');

class TablePCategory extends JTable

{
	var $id = null;
	var $name = null;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_contact_cat', 'id', $db);
	}
}
?>