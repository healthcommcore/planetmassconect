<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class FrameurlController extends JController
{

	function __construct ( $default = array())
	{
		parent::__construct ( $default );
		// To override default task -> function naming convention
		$this->registerTask ( 'add', 'edit');
		$this->registerTask ( 'apply', 'save');
		$this->registerTask ( 'applyStep', 'saveStep');
		/*
		$this->registerTask ( 'sync', 'syncProject');
		$this->registerTask ( 'list', 'listProject');
		*/
	}

	
	function publish()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Frameurl', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$msg = '';
		$id = $cid[0];
		$row->load($id);
		
		if ( empty( $row->url) ) {
			$row->published = 0;
			$msg = 'The Frame Link could not be published because the URL is not specified.';
		}

		else $row->publish($cid, 1);
	
		// $mainframe->redirect('index.php?option='.  $option);
		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart, $msg );

	}
	
	function unpublish()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Frameurl', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		$row->publish($cid, 0);
		
	
		// $mainframe->redirect('index.php?option='.  $option);
		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}
	

	function edit()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Frameurl', 'Table');
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);

		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		// print_r($row);
					
		$lists = array();
		
		// If new, set some values if specified in listing
		if ($row->id == 0) {


			$sectionID = JRequest::getVar('filter_sectionid',0);
			$stepID = JRequest::getVar('filter_stepid',0);
			$row->sectionID = $sectionID;
			$row->stepID = $stepID;
			// print_r($row->sectionID);
		}

		$steps[] = array('value' => '', 'text' =>'Select');
					
		
		// Retrieve list of steps 
		$db =& JFactory::getDBO();	
		$query = "SELECT id, name FROM #__pmc_step ORDER BY name ASC";
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
			
			
		
		// Retrieve ALL sections 
		$db =& JFactory::getDBO();	
		// $query = "SELECT se.id, se.name, st.id as stepID, st.name as stepname FROM #__pmc_section se join #__pmc_step st on se.stepID = st.id order by stepname, se.ordering";
		$query = "SELECT se.id, se.name, st.id as stepID, st.name as stepname FROM #__pmc_section se join #__pmc_step st on se.stepID = st.id order by stepname";
		//echo $query;
		
		$db->setQuery( $query);
		$sectionrows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		// Create array that Javascript function will use, indexed by step ID
		$sectionbystep = array();
		foreach ($sectionrows as $sectionrow) {
			if (!isset( $sectionbystep[$sectionrow->stepID])) $sectionbystep[$sectionrow->stepID] = array();
			$sectionbystep[$sectionrow->stepID][] = $sectionrow;
		}
		//print_r($sectionbystep);
		$lists['sectionbystep'] = $sectionbystep;

		// If section selected, but not step, need to identify which step section corresponds to
		if (($row->sectionID != 0) && ($row->stepID == 0)) {
					// echo '<br>sectionID set but not stepID <br>';

			foreach ($sectionbystep as $step )
			// for ($i =0; $i < count($sectionbystep); $i++)
			{
				// print_r($sectionbystep[$i]);
				foreach ($step as $section )
				{
					if ($section->id == $row->sectionID  ) {
						// echo '<br>sectionID && stepID found<br>';
						// print_r($section);
						
						$row->stepID = $section->stepID;
						break;
					}
			
				}
			}
		}	
		// Generate HTML for drop-down list of steps
		
		foreach ($rows as $step )
		{
			$steps[] = array('value' => $step->id, 'text' => $step->name);
		}
		$javascript	= 'onchange="changeDynaList( \'sectionID\', jsSections, document.adminForm.stepID.options[document.adminForm.stepID.selectedIndex].value, 0, 0);"';
		$lists['steps'] = JHTML::_('select.genericList', $steps, 'stepID', 'class="inputbox" '. $javascript  , 'value', 'text', $row->stepID);		
		$lists['pdf'] = JHTML::_('select.booleanlist', 'pdf', 'class="inputbox"', $row->pdf);
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
		
		if (($row->sectionID != 0) || ($row->stepID != 0)) {	
			// echo '<br>sectionID or stepID set<br>';
			// Generate HTML for drop-down list
			$sections[] = array('value' => '', 'text' => '- Select section -');
			foreach ($sectionbystep[$row->stepID] as $section )
			{
				$sections[] = array('value' => $section->id, 'text' => $section->name);
			}
			$lists['sections'] = JHTML::_('select.genericList', $sections, 'sectionID', 'class="inputbox" ' , 'value', 'text', $row->sectionID);
		} else  {	
			// echo '<br>sectionID & stepID not set<br>';
			$lists['sections'] = '<select name="sectionID" id="sectionID" class="inputbox" size="1"><option value="" selected="selected">- Select Section -</option></select>';
		}

		// Retrieve some current settings
		$lists['limit'] = $limit;
		$lists['limitstart'] = $limitstart;
		HTML_Frameurl::editFrameurl($row, $lists, $option);
	
	}

	function save ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Frameurl', 'Table');	
		$db =& JFactory::getDBO();	
	
	
	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		
		
		
		$row->title  = JRequest::getVar('title','','post', 'string', JREQUEST_ALLOWRAW);
		$row->url  = JRequest::getVar('url','','post', 'string', JREQUEST_ALLOWRAW);
		$row->description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
		$row->instructions  = JRequest::getVar('instructions','','post', 'string', JREQUEST_ALLOWRAW);
		$row->author  = JRequest::getVar('author','','post', 'string', JREQUEST_ALLOWRAW);
		$row->sectionID = JRequest::getVar('sectionID','','post', 'string', JREQUEST_ALLOWRAW);
		$row->stepID = JRequest::getVar('stepID','','post', 'string', JREQUEST_ALLOWRAW);
		$row->pdf =JRequest::getVar('pdf',0, 'post');
		$row->published =JRequest::getVar('published',0, 'post');
		$row->ordering = JRequest::getVar('ordering','','post', 'string', JREQUEST_ALLOWRAW);

		
		/* Check for required inputs */
		if ( ( empty( $row->title))  /* || ( empty( $row->url)) */ || ( $row->stepID == 0) ||  ( $row->sectionID == 0) )
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		$msg2 = '';
		// Set /modify certain fields
		if ( empty( $row->url) ) {
			$row->published = 0;
			$msg2 = 'The Frame Link was not published.';
		}
		
		
		if ($row->author == '') {
			$my = $mainframe->getUser();
			$row->author = $my->username;
		}
		$row->modified = date('Y:m:d H:i:s');
		
		// IF NOT PDF, Insert http:// if missing from URL
		if ( (!$row->pdf) && !empty($row->url) ){
			if ( strcasecmp ('http://', substr($row->url, 0, 7)) && strcasecmp ('https://', substr($row->url, 0, 8)) ) {
				// Insert 
				$row->url = 'http://'.$row->url;
			}
		}

		
		// IF NEW Set the ordering to the last value for the selected section
		if ($row->ordering == 0) {
			$query = "SELECT max(ordering) FROM #__pmc_url WHERE sectionID = $row->sectionID";
			$db->setQuery( $query);
			$maxorder = $db->loadResult();
			$row->ordering = $maxorder +1;
		}
		
		if (! $row->store())
		{
			echo $row->getError();
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		
		switch ($this->_task)
		{
			case 'apply':
				$msg = 'Changes to the Frame Link saved. '. $msg2;
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart . '&task=edit&cid[]=' . $row->id;
				break;
			
			case 'save':		
			default:
				$msg = 'Frame Link saved. '. $msg2;
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart;
			break;
		
		}
		// $mainframe->redirect($link, $msg);
		$this->setRedirect($link, $msg);
		// $this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart,  $msg );
	}

	// Allow for pagination
	function showFrameurl ()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	

		// Sort params
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'step',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );

		// echo $filter_order;

		// Filter, search parameters
		$filter_stepid		= $mainframe->getUserStateFromRequest( $option.'filter_stepid',		'filter_stepid',		'',				'string' );
		$filter_sectionid		= $mainframe->getUserStateFromRequest( $option.'filter_sectionid',		'filter_sectionid',		'',				'string' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
	
		// Retrieve list of steps for selection
		$query = "SELECT * FROM #__pmc_step ORDER BY name ASC";
		$db->setQuery( $query);
		$steprows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		$steps = array();
		$steps[] = array('value' => '', 'text' => '- Select Step -');

		foreach ($steprows as $step )
		{
			$steps[] = array('value' => $step->id, 'text' => $step->name);
		}
		// search filter

		// Generate HTML
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$this->lists['search']= $search;
		$this->lists['steps'] = JHTML::_('select.genericList', $steps, 'filter_stepid', 'class="inputbox" '. $javascript , 'value', 'text', $filter_stepid);

		// Add to WHERE clause
		$wheresql = '';
		if ($search) {
			$wheresql = ' WHERE LOWER(u.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(u.url) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(u.description) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(u.instructions) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		if ($filter_stepid) {
			if ($search) $wheresql .= " AND u.stepID = '" . $filter_stepid ."'";
			else $wheresql = " WHERE u.stepID = '" . $filter_stepid ."'";
		}


		// Retrieve sections:
		//	- ALL if no step selected
		//	- step sections only if step selected 
		//  Use Name instead of Display Title (to distinguish between identical titles)
		//
		// $query = "SELECT se.id, se.name, st.id as stepID, st.name FROM #__pmc_section se join #__pmc_step st on se.stepID = st.id order by st.name, se.name";

		if ( $filter_stepid) {
			$query = "SELECT se.id, se.name  FROM #__pmc_section se WHERE se.stepID = $filter_stepid order by se.name";
		}
		else {	
			$query = "SELECT se.id, se.name FROM #__pmc_section se order by se.name";
		}
		// echo $query;
		
		$db->setQuery( $query);
		$sectionrows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		
		// IF both a step and a section have been selected, check that the section is in the step; if not, clear the section selection
		if ( $filter_stepid && $filter_sectionid) {
			$found = false;
			foreach ($sectionrows as $section )
			{
				if ( $filter_sectionid == $section->id) $found = true;
			}
			if (!$found) $filter_sectionid = '';
		}
		$sections = array();
		$sections[] = array('value' => '', 'text' => '- Select section -');

		foreach ($sectionrows as $section )
		{
			$sections[] = array('value' => $section->id, 'text' => $section->name);
		}
		$this->lists['sections'] = JHTML::_('select.genericList', $sections, 'filter_sectionid', 'class="inputbox" '. $javascript , 'value', 'text', $filter_sectionid);
		// echo $lists['sections'];

		if ($filter_sectionid) {
			if ($search) $wheresql .= " AND u.sectionID = '" . $filter_sectionid ."'";
			else $wheresql = " WHERE u.sectionID = '" . $filter_sectionid ."'";
		}

		// Set order clause - default column is 'term'
		if ($filter_order != 'step') $ordersql = $filter_order . ' ' . $filter_order_Dir. ' , st.name, section, ordering, title ASC';
		else $ordersql = $filter_order . ' ' . $filter_order_Dir . ' , st.name, section, ordering ASC';
		
		// $ordersql = '  st.name, section, ordering ASC';
	
		// $query = "SELECT u.*, s.name as section, st.name as step FROM #__pmc_url u JOIN #__pmc_section s ON u.sectionID = s.id join #__pmc_step st on s.stepID = st.id $wheresql ORDER BY st.name, section, ordering, title ASC";
		$query = "SELECT u.*, s.name as section, st.name as step FROM #__pmc_url u JOIN #__pmc_section s ON u.sectionID = s.id join #__pmc_step st on s.stepID = st.id $wheresql ORDER BY $ordersql";
		// echo $query;
		
		// Retrieve total number of items first
		// $db->setQuery( $query);
		// $total = $db->getNumRows();
		// echo '<br>total #items = '. $total;
		
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		$total = count( $rows);
		// echo '<br>total #items = '. $total;
		$db->setQuery( $query, $limitstart, $limit);
		$rows = $db->loadObjectList();

		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit);
		// print_r($rows);
		// column ordering
		$this->lists['order_Dir'] = $filter_order_Dir;
		$this->lists['order'] = $filter_order;
		HTML_Frameurl::showFrameurl( $rows, $option, $pageNav);
	
	}
	
	function orderup()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		// Check for request forgeries
		// echo 'Orderup';
		$row =& JTable::getInstance( 'Frameurl', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);
		//print_r($id);
		
		// JRequest::checkToken() or jexit( 'Invalid Token' );
		//$model = $this->getModel('ModelFrameurl');
		//$model->move(-1);
		// print_r($cid);

		$row->moveframeurl(-1);
		$this->reorderUrl($row->sectionID);
		$msg = JText::_( 'New ordering saved' );

		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}

	function orderdown()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		// echo 'Orderdown';
		// Check for request forgeries
		$row =& JTable::getInstance( 'Frameurl', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);

		$row->moveframeurl(1);
		$this->reorderUrl($row->sectionID);
		// print_r($cid);
		$msg = JText::_( 'New ordering saved' );

		//$model = $this->getModel('ModelFrameurl');
		//$model->move(1);

		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}
	
	/**
	 * Method to reorder urls
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 * >> Error handling?
	 */
	function reorderUrl($sectionID)
	{
		$db =& JFactory::getDBO();	
		// echo 'reorder <br>';
		// echo 'URLS for section id='. $sectionID;
	
		// Redo query, to retrieve ALL urls in the same section (no filter, etc...)
		$query = "SELECT u.id, u.ordering FROM #__pmc_url u WHERE u.sectionID = $sectionID ORDER BY ordering";
		// echo $query;
		
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}


		// update ordering values
		// echo "<br><br>reorder total number of rows". count($rows);
		for( $i=0; $i < count($rows); $i++ )
		// for( $i=1; $i <= 1; $i++ )
		{
			// $row->load( (int) $cid[$i] );
			// $groupings[] = $row->catid;

			if ($rows[$i]->ordering != ($i+1))
			{
				// echo "<br><br>reorder from $row->ordering ->". ($i+1) .'<br>' ;
				// print_r($rows[$i]);
				
				$query = 'UPDATE #__pmc_url SET ordering = '.($i+1). ' WHERE id ='. $rows[$i]->id;
				// echo $query;
				$db->setQuery( $query);
				if ( !$db->query())
				{
					echo "<script>alert('".$db->getErrorMsg(). "');
						
							window.history.go(-1); </script>\n";
				}

			}
		}
		return true;
	}
	
function remove()
	{
		global $option, $mainframe;
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		if (count ($cid))
		{
			$cids = implode( ',', $cid);
			
			
			$query = "DELETE FROM #__pmc_url WHERE id IN ( $cids)";
			$db->setQuery( $query);
			if ( !$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
			}
		}
		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}
	
	/* Sections */
	
	/* SHow all sections */ 
	function sections() {
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	
	
		// Sort params - title, published, ordering
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'name',	'cmd' );
		
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );
		
		// Filter, sort, search parameters
		$filter_stepid		= $mainframe->getUserStateFromRequest( $option.'filter_stepid',		'filter_stepid',		'',				'string' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
	
		// Retrieve list of steps for selection
		$query = "SELECT * FROM #__pmc_step ORDER BY name ASC";
		$db->setQuery( $query);
		$steprows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		$steps = array();
		$steps[] = array('value' => '', 'text' => '- Select Step -');

		foreach ($steprows as $step )
		{
			$steps[] = array('value' => $step->id, 'text' => $step->name);
		}
		// search filter

		// Generate HTML
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$this->lists['search']= $search;
		$this->lists['steps'] = JHTML::_('select.genericList', $steps, 'filter_stepid', 'class="inputbox" '. $javascript , 'value', 'text', $filter_stepid);

		// Add to WHERE clause
		//	>> Search which fields?
		$wheresql = '';
		if ($search) {
			$wheresql = ' WHERE LOWER(s.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(s.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(s.description) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		if ($filter_stepid) {
			if ($search) $wheresql .= " AND stepID = '" . $filter_stepid ."'";
			else $wheresql = " WHERE stepID = '" . $filter_stepid ."'";
		}

		// Ordering 
		// Set order clause - default column is step name, section ordering, section name
		if ( ($filter_order == 'a.ordering') || ($filter_order == 'step') ) {
			$ordersql 	= ' st.name, s.ordering, s.name ASC';
		} else {
			$ordersql 	= $filter_order .' '. $filter_order_Dir .', st.name, s.ordering, s.name ASC';
		}


		// Ordering
		// 
		$query = "SELECT s.*, st.name as step FROM #__pmc_section s join #__pmc_step st on s.stepID = st.id $wheresql
			ORDER BY $ordersql";	// st.name, s.ordering, s.name ASC
		// echo $query;
		
	
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		$total = count($rows);

		$db->setQuery( $query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit);
		$lists = array();
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);

		// column ordering
		$this->lists['order_Dir'] = $filter_order_Dir;
		$this->lists['order'] = $filter_order;
	

		HTML_Frameurl::showSections ( $rows, $option, $pageNav);
	}
	function editSection()
	{
		global $option;
		$row =& JTable::getInstance( 'Section', 'Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		
		// Retrieve list of steps 
		$db =& JFactory::getDBO();	
		$query = "SELECT id, name FROM #__pmc_step ORDER BY name ASC";
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		// If new, set some values if specified in listing
		if ($row->id == 0) {
			$stepID = JRequest::getVar('filter_stepid',0);
			$row->stepID = $stepID;
			// print_r($row->sectionID);
		}
			
		// Generate HTML for drop-down list of steps
		$steps[] = array('value' => '', 'text' =>'Select');
		foreach ($rows as $step )
		{
			$steps[] = array('value' => $step->id, 'text' => $step->name);
		}
	
		
		$lists['steps'] = JHTML::_('select.genericList', $steps, 'stepID', 'class="inputbox" ' , 'value', 'text', $row->stepID);
		HTML_Frameurl::editSection($row, $option, $lists);
	}

	function saveSection ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Section', 'Table');	
		$db =& JFactory::getDBO();	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		
	
		$row->name  = JRequest::getVar('name','','post', 'string', JREQUEST_ALLOWRAW);
		$row->title  = JRequest::getVar('title','','post', 'string', JREQUEST_ALLOWRAW);
		$row->description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
		$row->stepID  = JRequest::getVar('stepID','','post', 'string', JREQUEST_ALLOWRAW);
		$row->ordering  = JRequest::getVar('ordering','','post', 'string', JREQUEST_ALLOWRAW);
		
		
		if  ( empty( $row->title) || empty( $row->name))
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}

		// Set the ordering to the last value for the selected step
		if ($row->ordering == 0) {
			$query = "SELECT max(ordering) FROM #__pmc_url WHERE stepID = $row->stepID";
			$db->setQuery( $query);
			$maxorder = $db->loadResult();
			$row->ordering = $maxorder +1;
		}

		if (! $row->store())
		{
			echo $row->getError();
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		switch ($this->_task)
		{
			
			case 'save':		
			default:
				$msg = 'Section saved';
				$link = 'index.php?option=' . $option . '&task=sections';
				break;
		
		}
		// $mainframe->redirect($link, $msg);
		$this->setRedirect($link, $msg);
	}
	function orderupsection()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		// Check for request forgeries
		// echo 'Orderup';
		$row =& JTable::getInstance( 'Section', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);
		
		$row->movesection(-1);
		$msg2 = $this->reorderSection($row->stepID);
		$msg = JText::_( 'New ordering saved.' .$msg2 );

		$this->setRedirect('index.php?option='.  $option .'&task=sections&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}

	function orderdownsection()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$row =& JTable::getInstance( 'Section', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);

		$row->movesection(1);
		$msg2 = $this->reorderSection($row->stepID);
		$msg = JText::_( 'New ordering saved.' .$msg2 );

		$this->setRedirect('index.php?option='.  $option .'&task=sections&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}

	/**
	 * Method to reorder sections in the same step
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 * >> Error handling?
	 */
	function reorderSection($stepID)
	{
		$db =& JFactory::getDBO();	
		// echo 'reorder <br>';
		// echo 'URLS for section id='. $sectionID;
	
		// Redo query, to retrieve ALL urls in the same section (no filter, etc...)
		$query = "SELECT id, ordering FROM #__pmc_section WHERE stepID = $stepID ORDER BY ordering";
		// echo $query;
		
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		// print_r($rows);

		// update ordering values
		// echo "<br><br>reorder total number of rows". count($rows);
		for( $i=0; $i < count($rows); $i++ )
		// for( $i=1; $i <= 1; $i++ )
		{
			if ($rows[$i]->ordering != ($i+1))
			{
				// echo "<br><br>reorder from $row->ordering ->". ($i+1) .'<br>' ;
				// print_r($rows[$i]);
				
				$query = 'UPDATE #__pmc_section SET ordering = '.($i+1). ' WHERE id ='. $rows[$i]->id;
				// echo $query;
				$db->setQuery( $query);
				if ( !$db->query())
				{
					return ($db->getErrorMsg() );
					// echo "<script>alert('".$db->getErrorMsg(). "');
						
						//window.history.go(-1); </script>\n";
						//exit();
				}

			}
		}
		return '';
	}

	function removeSection()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		
		if (count ($cid))
		{
			$cids = implode( ',', $cid);


			// Check whether there are links with this section
			//	 If so, tell user to first delete them
			$query = "SELECT * FROM #__pmc_url WHERE sectionID IN ($cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			$rows = $db->loadObjectList();
			if (count($rows) > 0) {
				echo "<script>alert('There are Frame Links assigned to this Section. Please edit or remove them first');
						window.history.go(-1); </script>\n<br />\n";
				exit();
			}
			
			

			// Delete the section(s)
			$query = "DELETE FROM #__pmc_section WHERE id in (  $cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
		}
		$this->setRedirect('index.php?option='.  $option. '&task=sections&limit='. $limit .'&limitstart='. $limitstart) ;
		
		// $this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}

	/* SHow all Steps */ 
	function steps() {
		global $option, $mainframe;
		// $limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		// $limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	
	
		// Retrieve total number of items first
		$query = "SELECT count(*) FROM #__pmc_step";
		$db->setQuery( $query);
		$total = $db->loadResult();
	
		$query = "SELECT * FROM #__pmc_step ORDER BY name ASC";
		$db->setQuery( $query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		
		jimport('joomla.html.pagination');
		// $pageNav = new JPagination( $total, $limitstart, $limit);
	
		HTML_Frameurl::showSteps ( $rows, $option, $pageNav);
	}


	function editStep()
	{
		global $option;
		$row =& JTable::getInstance( 'Step', 'Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		
					
		HTML_Frameurl::editStep($row, $option, $lists);
	}

	function saveStep ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Step', 'Table');	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
	
		$row->name  = JRequest::getVar('name','','post', 'string', JREQUEST_ALLOWRAW);
		$row->title  = JRequest::getVar('title','','post', 'string', JREQUEST_ALLOWRAW);
		$row->description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
		// $row->stepnumber = JRequest::getVar('stepnumber','','post', 'string', JREQUEST_ALLOWRAW);
		// print_r($row);
	
		$title  = JRequest::getVar('title','','post', 'string', JREQUEST_ALLOWRAW);
		$description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
	
		
		if  ( empty( $row->title) || empty( $row->name))
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		
		if (! $row->store())
		{
			echo $row->getError();
			echo "<script>alert('".$row->getError(). "');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		switch ($this->_task)
		{
			case 'applyStep':
				$msg = 'Changes to the Step saved. '; // . $msg2;
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart . '&task=edit&cid[]=' . $row->id;
				$link = 'index.php?option=' . $option . '&task=editStep&cid[]=' . $row->id;
				break;
			
			case 'save':		
			default:
				$msg = 'Step saved';
				$link = 'index.php?option=' . $option . '&task=steps';
			break;
		
		}
		/*
		switch ($this->_task)
		{
			
			case 'save':		
			default:
				$msg = 'Step saved';
				$link = 'index.php?option=' . $option . '&task=steps';
				break;
		
		}
		*/
		$this->setRedirect($link, $msg);
	}
	
	function removeStep()
	{
		global $option, $mainframe;
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		
		if (count ($cid))
		{
			$cids = implode( ',', $cid);
			// Check whether there are sections and links with these stepID
			//	 If so, tell user to first delete them
			$query = "SELECT * FROM #__pmc_step s JOIN #__pmc_url u ON  s.id = u.stepID WHERE s.id IN ($cids)";
			// echo $query;
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
			$rows = $db->loadObjectList();
			if (count($rows) > 0) {
				echo "<script>alert('There are Frame Links assigned to this Step. Please edit or remove them first');
						window.history.go(-1); </script>\n<br />\n";
				exit();
			}
			
			$query = "SELECT * FROM #__pmc_step s JOIN #__pmc_section se ON  s.id = se.stepID WHERE s.id IN ($cids)";
			// echo $query;
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
			$rows = $db->loadObjectList();
			if (count($rows) > 0) {
				echo "<script>alert('There are Sections assigned to this Step. Please edit or remove them first');
						window.history.go(-1); </script>\n<br />\n";
				exit();
			}
			

			// Delete the step(s)
			$query = "DELETE FROM #__pmc_step WHERE id in (  $cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
		}
		$this->setRedirect('index.php?option='.  $option. '&task=steps') ;
	}
	/* Tips */
	
	/* SHow all tips */ 
	function tips() {
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	

		// Sort params - title, published, ordering
		// Use GetVar to avoid session problems - otherwise share values with other tasks in this component
		$filter_order		= JRequest::getVar(	'filter_order',		'a.ordering');
		// $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'a.ordering',	'cmd' );
		// $filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',		'order',	'cmd' );
		// echo $filter_order;
		
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );


/*
		// Filter /search parameters
		// >> No Filter yet
		// $filter_stepid		= $mainframe->getUserStateFromRequest( $option.'filter_stepid',		'filter_stepid',		'',				'string' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
		

		// Add to WHERE clause
		$wheresql = '';
		if ($search) {
			$wheresql = ' WHERE LOWER(s.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(s.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				.' OR LOWER(s.description) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		if ($filter_stepid) {
			if ($search) $wheresql .= " AND stepID = '" . $filter_stepid ."'";
			else $wheresql = " WHERE stepID = '" . $filter_stepid ."'";
		}
		*/

		// Ordering 
		// Set order clause - default column is 'ordering'
		if ( ($filter_order == 'a.ordering') || ($filter_order == 'order') ) {
			$ordersql 	= ' ordering ASC';
		} else {
			$ordersql 	= $filter_order .' '. $filter_order_Dir .', ordering';
		}


		$query = "SELECT * FROM #__pmc_tip $wheresql ORDER BY $ordersql";
		
	
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		$total = count($rows);

		$db->setQuery( $query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit);
		$lists = array();
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
		// column ordering
		$this->lists['order_Dir'] = $filter_order_Dir;
		$this->lists['order'] = $filter_order;
		HTML_Frameurl::showTips ( $rows, $option, $pageNav);
	}
	function editTip()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Tip', 'Table');
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);

		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		// print_r($row);
					
		$lists = array();
		
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);

		$types = array();
		$types[] = array('value' => '', 'text' =>'Select');
		$types[] = array('value' => 'Tip', 'text' => 'Tip');
		$types[] = array('value' => 'Glossary', 'text' => 'Glossary');
		$types[] = array('value' => 'Resource', 'text' => 'Resource');
		$types[] = array('value' => 'Help/Other', 'text' => 'Help/Other');
		$lists['type'] = JHTML::_('select.genericList', $types, 'contentType', 'class="inputbox" '. $javascript  , 'value', 'text', $row->contentType);		

		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
		$lists['iframePDF'] = JHTML::_('select.booleanlist', 'iframePDF', 'class="inputbox"', $row->iframePDF);
		$lists['iframeWeb'] = JHTML::_('select.booleanlist', 'iframeWeb', 'class="inputbox"', $row->iframeWeb);

		// Retrieve some current settings
		$lists['limit'] = $limit;
		$lists['limitstart'] = $limitstart;
		HTML_Frameurl::editTip($row, $option, $lists);
	}

	function saveTip ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Tip', 'Table');	
		$db =& JFactory::getDBO();	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		
	
		$row->title  = JRequest::getVar('title','','post', 'string', JREQUEST_ALLOWRAW);
		$row->description  = JRequest::getVar('description','','post', 'string', JREQUEST_ALLOWRAW);
		$row->contentID  = JRequest::getVar('contentID','','post', 'string', JREQUEST_ALLOWRAW);
		$row->contentType  = JRequest::getVar('contentType','','post', 'string', JREQUEST_ALLOWRAW);
		$row->iframePDF  = JRequest::getVar('iframePDF','','post', 'string', JREQUEST_ALLOWRAW);
		$row->iframeWeb  = JRequest::getVar('iframeWeb','','post', 'string', JREQUEST_ALLOWRAW);
		$row->ordering  = JRequest::getVar('ordering','','post', 'string', JREQUEST_ALLOWRAW);
		$row->published =JRequest::getVar('published',0, 'post');
		
		
		if  ( empty( $row->title) || empty( $row->description))
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		$row->modified = date('Y:m:d H:i:s');
		
		// IF NEW Set the ordering to the last value for tips
		if ($row->ordering == 0) {
			$query = "SELECT max(ordering) FROM #__pmc_tip";
			$db->setQuery( $query);
			$maxorder = $db->loadResult();
			$row->ordering = $maxorder +1;
		}

		if (! $row->store())
		{
			echo $row->getError();
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		
		switch ($this->_task)
		{
			
			case 'save':		
			default:
				$msg = 'Tip saved';
				$link = 'index.php?option=' . $option . '&task=tips';
				break;
		
		}
		// $mainframe->redirect($link, $msg);
		$this->setRedirect($link, $msg);
	}
	
	function orderuptip()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		// echo 'Orderup';
		$row =& JTable::getInstance( 'Tip', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);
		
		$row->movetip(-1);
		$msg2 = $this->reorderTip();
		$msg = JText::_( 'New ordering saved.' .$msg2 );

		$this->setRedirect('index.php?option='.  $option .'&task=tips&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}

	function orderdowntip()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$row =& JTable::getInstance( 'Tip', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$id = $cid[0];	// Always move only 1 at a time
		$row->load($id);

		$row->movetip(1);
		$msg2 = $this->reorderTip();
		$msg = JText::_( 'New ordering saved.' .$msg2 );

		$this->setRedirect('index.php?option='.  $option .'&task=tips&limit='. $limit .'&limitstart='. $limitstart, $msg );
	}
	
	/**
	 * Method to reorder all the tips
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 * >> Error handling?
	 */
	function reorderTip()
	{
		$db =& JFactory::getDBO();	
		echo 'reorder tips<br>';
	
		// Redo query, to retrieve ALL tips (no filter, etc...)
		$query = "SELECT id, ordering FROM #__pmc_tip ORDER BY ordering";
		echo $query;
		
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		// print_r($rows);

		// update ordering values
		echo "<br><br>reorder total number of rows". count($rows);
		for( $i=0; $i < count($rows); $i++ )
		// for( $i=1; $i <= 1; $i++ )
		{
			if ($rows[$i]->ordering != ($i+1))
			{
				// echo "<br><br>reorder from $row->ordering ->". ($i+1) .'<br>' ;
				// print_r($rows[$i]);
				
				$query = 'UPDATE #__pmc_tip SET ordering = '.($i+1). ' WHERE id ='. $rows[$i]->id;
				echo $query;
				$db->setQuery( $query);
				if ( !$db->query())
				{
					return ($db->getErrorMsg() );
					// echo "<script>alert('".$db->getErrorMsg(). "');
						
						//window.history.go(-1); </script>\n";
						//exit();
				}

			}
		}
		return '';
	}

	function publishTip()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Tip', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$msg = '';
		$id = $cid[0];
		$row->load($id);
		
		// Test for contentID before publishing?
		/*
		if ( empty( $row->url) ) {
			$row->published = 0;
			$msg = 'The Tip could not be published because the contenID is not specified.';
		}
		*/

		$row->publish($cid, 1);
	
		// $mainframe->redirect('index.php?option='.  $option);
		$this->setRedirect('index.php?option='.  $option .'&task=tips&limit='. $limit .'&limitstart='. $limitstart, $msg );

	}
	
	function unpublishTip()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Tip', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		$row->publish($cid, 0);
		
	
		// $mainframe->redirect('index.php?option='.  $option);
		$this->setRedirect('index.php?option='.  $option .'&task=tips&limit='. $limit .'&limitstart='. $limitstart );
	}

	function removeTip()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		
		if (count ($cid))
		{
			$cids = implode( ',', $cid);
			// echo '<br />tip ids to delete ';
			// print_r($cid);
			$matches = array();

			// Check whether there are links from modules to this tip
			//	 If so, tell user to first delete them
			$query = "SELECT title, params FROM #__modules WHERE module = 'mod_link'";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			// $rows = $db->loadObjectList();
			
			$rows =$db->loadAssocList();
			// check each module's params values 'links'
			foreach ($rows as $row) {

				$params = new JParameter($row['params']);
				$links = $params->get('links');
				// Note that it doesn't necessarily return an array if only one item
				// print_r($links);
					if (count ($links) > 0 ) {
						
						if (count ($links) == 1 ) {
							$oneval = $links;
							$links = array( 0 => $oneval);
						
						}
				
							$match = array_intersect( $cid, $links);
							if (count ($match) > 0) {
								// echo 'module '. $row['title'] . '<br />';
								$matches[] = $row['title'];
							}
				}
			}

			/*
			$msg = 'There are mod_form Modules which link to the selected tip(s). Please remove the tips from the Modules first: ';
			foreach ($matches as $match) {
				$msg .= "'$match' \n";
			}
			*/
			
			// $alert = "<script>alert($msg);window.history.go(-1); </script>\n<br />\n";
		
			if (count( $matches) > 0 ) {
				echo "<script>alert('There are mod_form Modules which link to the selected tip(s). Please remove the tips from the Modules first');							
						window.history.go(-1); </script>\n<br />\n";
				exit();
			}
			

			// Delete the tip(s)
			$query = "DELETE FROM #__pmc_tip WHERE id in (  $cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
		}
		$this->setRedirect('index.php?option='.  $option. '&task=tips&limit='. $limit .'&limitstart='. $limitstart) ;
		
		// $this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}
}
?>
