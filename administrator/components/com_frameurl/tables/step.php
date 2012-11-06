<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableStep extends JTable

{
	var $id = null;
	var $name = null;
	var $title = null;
	var $description = null;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_step', 'id', $db);
	}
}
?>