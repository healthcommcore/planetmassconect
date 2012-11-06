<?php

defined ( '_JEXEC') or die ('Restricted access');
$mainframe->registerEvent ( 'onSearch', 'botSearchGlossary');
$mainframe->registerEvent ( 'onSearchAreas', 'botSearchGlossaryAreas');

function &botSearchGlossaryAreas() {
	static $areas = array( 'glossary' => 'Glossary');
	return $areas;
}

function botSearchGlossary( $text, $phrase='', $ordering='', $areas=null)
{
	// No results if no search text
	if (!$text) {
		return array();
	}
	
	// if search area specified, only if it matches ours 
	if (is_array($areas) ) {
		if (!array_intersect( $areas, array_keys( botSearchGlossaryAreas() ) )) {
			// no match, no results
			return array();
		}
	}
	
	$db =& JFactory::getDBO();
	//echo $phrase;
	if ($phrase == 'exact')
	{
		$where = "(LOWER(term) LIKE '%$text%')
			OR (LOWER(definition) LIKE '%$text%') ";
	}
	else
	{
		$words = explode( ' ', $text);
		$wheres = array();
		foreach ($words as $word) {
			$wheres[] = "(LOWER(term) LIKE '%$word%')
			OR (LOWER(definition) LIKE '%$word%') ";
		}
		if ($phrase == 'all')
		{
			$separator = 'AND';
		}
		else
		{
			$separator = 'OR';
		}
		$where = '(' . implode( ") $separator (", $wheres ) . ')';
	}
	$where .= ' AND published = 1';
	
	$order = 'term ASC';
	
	
	$query = "SELECT term AS title, definition AS text, '' AS created, ".
		"\n 'Glossary' AS section," .
		"\n '' AS category," .
		"\n CONCAT( 'index.php?option=com_glossary&term=', term) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_glossary" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
	// echo $query;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		return $rows;
}
?>