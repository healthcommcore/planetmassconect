<?php

defined ( '_JEXEC') or die ('Restricted access');
$mainframe->registerEvent ( 'onSearch', 'botSearchPContact');
$mainframe->registerEvent ( 'onSearchAreas', 'botSearchPContactAreas');

function &botSearchPContactAreas() {
	static $areas = array( 'contact' => 'Contact');
	return $areas;
}

function botSearchPContact( $text, $phrase='', $ordering='', $areas=null)
{
	// No results if no search text
	if (!$text) {
		return array();
	}
	
	// if search area specified, only if it matches ours 
	if (is_array($areas) ) {
		if (!array_intersect( $areas, array_keys( botSearchPContactAreas() ) )) {
			// no match, no results
			return array();
		}
	}
	
	$db =& JFactory::getDBO();
	//echo $phrase;
	if ($phrase == 'exact')
	{
		$where = "(LOWER(organization) LIKE '%$text%')
			OR (LOWER(institution) LIKE '%$text%') 
			OR (LOWER(specialty) LIKE '%$text%') ";
	}
	else
	{
		$words = explode( ' ', $text);
		$wheres = array();
		foreach ($words as $word) {
			$wheres[] = "(LOWER(organization) LIKE '%$word%')
			OR (LOWER(institution) LIKE '%$word%') 
			OR (LOWER(specialty) LIKE '%$word%') ";
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
	
	$order = 'title ASC';
	
	
	$query = "SELECT co.organization AS title, CONCAT(co.organization,' ',co.institution,' ',co.institution,' ',co.specialty,' ',co.city,' ',co.state,' ',co.zip) AS text, co.modified AS created, ".
		"\n 'Contact' AS section," .
		"\n ca.name AS category," .
		"\n CONCAT( 'index.php?option=com_pcontact&view=contact&id=', co.id) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_contact co, #__pmc_contact_cat ca" .
		"\n WHERE co.catID = ca.id AND $where" .
		"\n ORDER BY $order";
	// echo $query;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		
		return $rows;
}
?>