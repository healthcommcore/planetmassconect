<?php

defined ( '_JEXEC') or die ('Restricted access');
$mainframe->registerEvent ( 'onSearch', 'botSearchURL');
$mainframe->registerEvent ( 'onSearchAreas', 'botSearchURLAreas');

function &botSearchURLAreas() {
	static $areas = array( 'link' => 'Link');
	return $areas;
}

function botSearchURL( $text, $phrase='', $ordering='', $areas=null)
{
	// No results if no search text
	if (!$text) {
		return array();
	}
	
	// if search area specified, only if it matches ours 
	if (is_array($areas) ) {
		if (!array_intersect( $areas, array_keys( botSearchURLAreas() ) )) {
			// no match, no results
			return array();
		}
	}
	
	$db =& JFactory::getDBO();
	//echo $phrase;
	if ($phrase == 'exact')
	{
		$where = "(LOWER(title) LIKE '%$text%')
			OR (LOWER(instructions) LIKE '%$text%')";
		$whereStep = " (LOWER(description) LIKE '%$text%') ";
	}
	else
	{
		$words = explode( ' ', $text);
		$wheres = array();
		foreach ($words as $word) {
			$wheres[] = "(LOWER(title) LIKE '%$word%')
			OR (LOWER(instructions) LIKE '%$word%') ";
			$wheresStep[] = "(LOWER(description) LIKE '%$word%') ";
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
		$whereStep = '(' . implode( ") $separator (", $wheresStep ) . ')';
	}
	$where .= ' AND published = 1';
	$whereStep .= ' AND published = 1';
	
	$order = 'title ASC';
	
	
	// Matching data from link that will appear on link page
	/*
	$query = "SELECT title AS title, instructions AS text, '' AS created, ".
		"\n 'Frame Instruction' AS section," .
		"\n 'Frame Instruction' AS category," .
		"\n CONCAT( 'index.php?option=com_frameurl&view=url&Itemid=45&id=', id) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_url" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
		*/
	// get stepID and linkID so as to generate correct href
	$query = "SELECT title AS title, instructions AS text, '' AS created, ".
		"\n 'Frame Instruction' AS section," .
		"\n 'Frame Instruction' AS category," .
		"\n stepID AS href," .
		"\n id AS linkid," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_url" .
		"\n WHERE $where" .
		"\n ORDER BY $order";
	//echo $query;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		
// get stepID => pmc_step id. Then look up menu table, all links = index.php?option=com_frameurl&view=step,
// then params with a step value
// No time now, just hard-coded 

		// For each stepID, generate path and replace href value
		foreach ($rows as $row) {
			// $href = 'index.php?option=com_frameurl&view=url&Itemid='. $step2ItemidMap[$row->href] . '&id='. $row->linkid;
			$href = 'index.php?option=com_frameurl&view=url&id='. $row->linkid;
			$row->href = $href;	// replace value
		}
		

	
	// Matching data from link that will appear on Step page
	/*
	$queryStep = "SELECT title AS title, description AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n CONCAT( 'index.php?option=com_frameurl&view=step&Itemid=45&step=', stepID) AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_url" .
		"\n WHERE $whereStep" .
		"\n ORDER BY $order"; 
		*/	
	$queryStep = "SELECT title AS title, description AS text, '' AS created, ".
		"\n 'Step' AS section," .
		"\n 'Step' AS category," .
		"\n stepID AS href," .
		"\n '2' AS browsernav" .
		"\n FROM #__pmc_url" .
		"\n WHERE $whereStep" .
		"\n ORDER BY $order"; 	
	// echo $queryStep;
		$db->setQuery( $queryStep );
		$rowsStep = $db->loadObjectList();
		// For each stepID, generate path and replace href value
		foreach ($rowsStep as $row) {
			// $href = 'index.php?option=com_frameurl&view=step&Itemid='. $step2ItemidMap[$row->href] . '&step='. $row->href;
			$href = 'index.php?option=com_frameurl&view=step&step='. $row->href;
			$row->href = $href;	// replace value
		}
		
		return array_merge( $rows, $rowsStep);
}
?>