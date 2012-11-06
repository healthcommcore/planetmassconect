<?php

defined ( '_JEXEC') or die ('Restricted access');
$mainframe->registerEvent ( 'onSearch', 'botSearchStep');
$mainframe->registerEvent ( 'onSearchAreas', 'botSearchStepAreas');

function &botSearchStepAreas() {
	static $areas = array( 'step' => 'Step');
	return $areas;
}

function botSearchStep( $text, $phrase='', $ordering='', $areas=null)
{
	// No results if no search text
	if (!$text) {
		return array();
	}
	
	// if search area specified, only if it matches ours 
	if (is_array($areas) ) {
		if (!array_intersect( $areas, array_keys( botSearchStepAreas() ) )) {
			// no match, no results
			return array();
		}
	}
	
	$db =& JFactory::getDBO();
	//echo $phrase;
	if ($phrase == 'exact')
	{
		$where = "(LOWER(title) LIKE '%$text%')
			OR (LOWER(description) LIKE '%$text%') ";
	}
	else
	{
		$words = explode( ' ', $text);
		$wheres = array();
		foreach ($words as $word) {
			$wheres[] = "(LOWER(title) LIKE '%$word%')
			OR (LOWER(description) LIKE '%$word%') ";
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
	
// get stepID => pmc_step id. Then look up menu table, all links = index.php?option=com_frameurl&view=step,
// then params with a step value
// No time now, just hard-coded 
	// $step2ItemidMap = array( 1 => 8, 15 => 9 , 19 => 11, 20 => 12 , 18=> 10 , 21 =>1 , 22=> 40);


	/*
	$query = "SELECT title AS title, description AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n CONCAT( 'index.php?option=com_frameurl&view=step&Itemid=45&step=', id) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_step" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
		*/
	$query = "SELECT title AS title, description AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n id AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_step" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
	// echo $query;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		// For each stepID, generate path and replace href value
		foreach ($rows as $row) {
			// $href = 'index.php?option=com_frameurl&view=step&Itemid='. $step2ItemidMap[$row->href] . '&step='. $row->href;
			$href = 'index.php?option=com_frameurl&view=step&step='. $row->href;
			$row->href = $href;	// replace value
		}

	/*
	$querySection = "SELECT name AS title, CONCAT(title, ' ',description) AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n CONCAT( 'index.php?option=com_frameurl&view=step&Itemid=45&step=', stepID) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_section" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
		*/
	$querySection = "SELECT name AS title, CONCAT(title, ' ',description) AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n stepID AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_section" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
	// echo $query;

		$db->setQuery( $querySection );
		$rowsSection = $db->loadObjectList();
		
		// For each stepID, generate path and replace href value
		foreach ($rowsSection as $row) {
			// $href = 'index.php?option=com_frameurl&view=step&Itemid='. $step2ItemidMap[$row->href] . '&step='. $row->href;
			$href = 'index.php?option=com_frameurl&view=step&step='. $row->href;
			$row->href = $href;	// replace value
		}
		
		return array_merge( $rows, $rowsSection);
		// return $rows;
}
?>