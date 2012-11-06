<?php
// Do not allow direct access
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

if(!defined('CMSLIB_DEFINED'))
	include_once (dirname($_SERVER['SCRIPT_FILENAME']) . '/libraries/cmslib/spframework.php');

if( cmsVersion() == _CMS_JOOMLA10 )
{
	global $_MAMBOTS;
	$_MAMBOTS->registerFunction( 'onSearch', 'jcSearchComments' );
}
else
{
	global $mainframe;
	$mainframe->registerEvent( 'onSearch', 'jcSearchComments' );
	$mainframe->registerEvent( 'onSearchAreas', 'plgSearchJomCommentAreas' );
}


/**
 * @return array An array of search areas
 */
function &plgSearchJomCommentAreas()
{
	static $areas = array(
		'jomcomment' => 'Comments'
	);
	return $areas;
}

function jcSearchComments( $text, $phrase='', $ordering='' ) {
	global $database, $my, $_MAMBOTS;
	//$db = &cmsInstance('CMSDb');
	
	$db		=& cmsInstance( 'CMSDb' );
	
	if( cmsVersion() ==  _CMS_JOOMLA15 )
	{
		// load plugin params info
	 	$plugin			=& JPluginHelper::getPlugin('search', 'jc.searchbot');
	 	$botParams	= new JParameter( $plugin->params );
	}
	else
	{
		// check if param query has previously been processed
		if ( !isset($_MAMBOTS->_search_mambot_params['jc']) ) {
			// load mambot params info
			$query = "SELECT params"
			. "\n FROM #__mambots"
			. "\n WHERE element = 'jc.searchbot'"
			. "\n AND folder = 'search'"
			;
			$database->setQuery($query);
			//$db->query( $query );
			$database->loadObject($mambot);
			
			// save query to class variable
			$_MAMBOTS->_search_mambot_params['jc'] = $mambot;
		}
		
		// pull query data from class variable
		$mambot = $_MAMBOTS->_search_mambot_params['jc'];	
		
		//No title defined. Use 'Comments' instead?
		$section = 'Comments';
		
		$botParams = new mosParameters( $mambot->params );

	}
	
	$limit = $botParams->def( 'search_limit', 50 );
	
	 $text = trim( $text );

	if ($text == '') {
		return array();
	}


	switch ( $ordering ) {
		case 'alpha':
			$order = 'a.text ASC';
			break;
			
		case 'category':
			$order = 'b.title ASC, a.text ASC';
			break;
			
		case 'popular':
		case 'newest':
		case 'oldest':
		default:
			$order = 'a.text DESC';
			break;
	}
	
	$limitClause	= 'LIMIT 0,' . $limit;

	$url	= '';
	$clause	= '';
	
	if( cmsVersion() == _CMS_JOOMLA15 )
	{
		$url	= "b.sectionid AS sectionid, "
				. "IF(CHAR_LENGTH(b.alias), CONCAT_WS(':',b.id, b.alias), b.id) AS slug, "
				. "IF(CHAR_LENGTH(c.alias), CONCAT_WS(':',c.id,c.alias), c.id) AS cslug ";
				
		$clause	= "LEFT JOIN #__categories AS c ON c.id=b.catid ";
	}
	else
	{
		$url	.= "CONCAT('index.php?option=' , a.option, '&task=view&id=' , a.contentid , '#comment-' , a.id) AS href ";
	}

	// If adding additional fields to search, simply add it below
	$fields = array (
	                    'a.name',
						'a.title',
						'a.comment',
						'a.email',
						'a.website'
					);
	$clause .= _getClause($fields, $text);
	
	$query	= "SELECT a.title AS title, a.option, b.id AS contentid, "
			. "a.comment AS text, "
			. "'2' AS browsernav, "
			. "CONCAT_WS(' / ' , b.title, CONCAT('', ' by ' , a.name)) AS section, "
			. "a.date AS created, "
			. $url
			. "FROM #__jomcomment AS a "
			. "INNER JOIN #__content AS b "
			. "ON b.id=a.contentid "
			. $clause . " "
			. "AND a.option='com_content' "		// only display comments from com_content
			. "AND a.published='1' "
			. $limitClause;

	$db->query( $query );
	$rows	= $db->get_object_list();
	
	if( cmsVersion() == _CMS_JOOMLA15 )
	{
		_getRoute( $rows );
	}

	_getTitle( $rows );
	return $rows;
}

/*
 * Returns the needed clauses in the sql statements
 */
function _getClause($fields, $searchValue){
	$strSQL = 'WHERE (';

	for($i = 0; $i < count($fields); $i++) {
	    if($i == 0){
	        #first field
			$strSQL .= "LOWER($fields[$i]) LIKE LOWER('%$searchValue%')";
		}
		else{
		    $strSQL .= " OR LOWER($fields[$i]) LIKE LOWER('%$searchValue%')";
		}
	}
	$strSQL .= ")";

	return $strSQL;
}

function _getRoute( &$rows )
{
	include_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

	for( $i =0; $i < count($rows); $i++ )
	{
		$row	=& $rows[$i];
		
		switch( $row->option )
		{
			case 'com_content':
				$row->href	= ContentHelperRoute::getArticleRoute($row->slug, $row->cslug, $row->sectionid);
				break;
		}
	}
}

/*
 * Some sites has disabled the title so we need to do some modifications
 * to our column alias "title"
 *
 * Returns: Modified rows
 */
function _getTitle( &$db_rows )
{
	
	foreach($db_rows as $row_number => $row){
	    if(!($row->title)){
	        $row->title = $row->section;
		}
	}
    return $db_rows;
}
?>
