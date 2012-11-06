<?php

/**
* @version $Id: helper.php 6783 2008-1-2$
* @package MOD_ALLWEBLINKS
* @copyright Copyright (C) 2007 - 2008 SJL Creations. All rights reserved.
* @license GNU/GPL, see LICENSE.php
*
*/

/** ensure this file is being included by a parent file */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modAllWebLinksHelper
{
function getList(&$params)
{
global $mainframe;

$db =& JFactory::getDBO();
$user =& JFactory::getUser();
$userId = (int) $user->get('id');
$aid = $user->get('aid', 0);

# Params
$orderby = $params->def( 'Lorder', 'date DESC'); // Sort order weblinks
$Corderby = $params->def( 'LCorder', 'a.catid'); // Sort order categories
$count = $params->def( 'wlcountr', 9999); // ?number of weblinks
$catids = $params->def( 'Lcatids', ''); // categories to show/exclude
$exclude = $params->def( 'Lexclude', 0); // show or exclude categories

if ("$catids"=="") {
$cats = "";
} else {
	if ("$exclude") {
		$cats = " AND a.catid NOT IN ($catids)";
	} else {
		$cats = " AND a.catid IN ($catids)";
	}
}

# Set up database query
$query = "SELECT a.id, b.id AS catid, a.title, a.description, DATE_FORMAT(a.date,'%Y-%m-%d') as cdate, hits,".
" b.title as ctitle, b.ordering as cordering, b.description as cdes," .
" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(':', a.id, a.alias) ELSE a.id END as slug,".
" CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(':', b.id, b.alias) ELSE b.id END as catslug".
" FROM #__weblinks AS a, #__categories AS b" .
" WHERE a.catid = b.id and a.published ='1' and b.access <= '".(int)$aid."'".
" $cats " .
" ORDER BY $Corderby , $orderby ";

# Query the database
$db->setQuery($query, 0, $count);
$rows = $db->loadObjectList();

$i = 0;
$lists = array();
foreach ( $rows as $row )
{
JFilterOutput::objectHTMLSafe( $row->ctitle, ENT_QUOTES, 'ctitle' );
JFilterOutput::objectHTMLSafe( $row->title, ENT_QUOTES, 'title' );
JFilterOutput::objectHTMLSafe( $row->description, ENT_QUOTES, 'description' );
JFilterOutput::objectHTMLSafe( $row->cdes, ENT_QUOTES, 'cdes' );
$lists[$i]->ctitle = $row->ctitle ;
$lists[$i]->title = $row->title ;
$lists[$i]->description = $row->description ;
$lists[$i]->catid = $row->catid;
$lists[$i]->id = $row->id;
$lists[$i]->hits = $row->hits;
$lists[$i]->cdate = $row->cdate;
$lists[$i]->cdes = $row->cdes;
$lists[$i]->slug = $row->slug;
$lists[$i]->catslug = $row->catslug;

$i++;

}

return $lists;
}
}
?>





