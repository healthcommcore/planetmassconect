<?php

defined ( '_JEXEC') or die ('Restricted access');

class TableGlossary extends JTable

{
	var $id = null;
	var $term = null;
	var $definition = null;
	var $source = null;
	var $author = null;
	var $modified = null;
	var $published = true;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_glossary', 'id', $db);
	}
}
?>