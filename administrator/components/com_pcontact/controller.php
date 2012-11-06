<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class PContactController extends JController
{

	function __construct ( $default = array())
	{
		parent::__construct ( $default );
		// To override default task -> function naming convention
		$this->registerTask ( 'add', 'edit');
		$this->registerTask ( 'apply', 'save');
	}

	
	function publish()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'PContact', 'Table');	
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		
		$row->publish($cid, 1);
	
		// $mainframe->redirect('index.php?option='.  $option);
		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );

	}
	
	function unpublish()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'PContact', 'Table');	
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
		$row =& JTable::getInstance( 'Pcontact', 'Table');
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);

		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		// print_r($row);
					
		$lists = array();
	
		// Retrieve list of categories 
		$db =& JFactory::getDBO();	
		$query = "SELECT id, name FROM #__pmc_contact_cat ORDER BY name ASC";
		$db->setQuery( $query);
		$rows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
			
		// Generate HTML for drop-down list of steps
		$categories[] = array('value' => '', 'text' =>'Select');
		foreach ($rows as $cat )
		{
			$categories[] = array('value' => $cat->id, 'text' => $cat->name);
		}
	
		
		$lists['catID'] = JHTML::_('select.genericList', $categories, 'catID', 'class="inputbox" ' , 'value', 'text', $row->catID);
		
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
		// Retrieve some current settings
		$lists['limit'] = $limit;
		$lists['limitstart'] = $limitstart;
		HTML_PContact::editContact($row, $lists, $option);
	
	}

	function save ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'PContact', 'Table');	
		$db =& JFactory::getDBO();	
	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		$row->catID = JRequest::getVar('catID','','post', 'string', JREQUEST_ALLOWRAW);

		$row->organization  = JRequest::getVar('organization','','post', 'string', JREQUEST_ALLOWRAW);
		$row->specialty  = JRequest::getVar('specialty','','post', 'string', JREQUEST_ALLOWRAW);
		$row->institution  = JRequest::getVar('institution','','post', 'string', JREQUEST_ALLOWRAW);
		$row->building  = JRequest::getVar('building','','post', 'string', JREQUEST_ALLOWRAW);
		$row->address1  = JRequest::getVar('address1','','post', 'string', JREQUEST_ALLOWRAW);
		$row->address2  = JRequest::getVar('address2','','post', 'string', JREQUEST_ALLOWRAW);
		$row->city  = JRequest::getVar('city','','post', 'string', JREQUEST_ALLOWRAW);
		$row->state  = JRequest::getVar('state','','post', 'string', JREQUEST_ALLOWRAW);
		$row->zip  = JRequest::getVar('zip','','post', 'string', JREQUEST_ALLOWRAW);
		$row->url  = JRequest::getVar('url','','post', 'string', JREQUEST_ALLOWRAW);
		$row->email  = JRequest::getVar('email','','post', 'string', JREQUEST_ALLOWRAW);
		$row->telephone  = JRequest::getVar('telephone','','post', 'string', JREQUEST_ALLOWRAW);
		$row->fax  = JRequest::getVar('fax','','post', 'string', JREQUEST_ALLOWRAW);
		$row->published =JRequest::getVar('published',0, 'post');
		
		// Check for required inputs
		if ( ( empty( $row->catID))  || ( empty( $row->organization)) )
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		// Set/modify certain fields
		if ( !empty($row->url)) {
			if ( strcasecmp ('http://', substr($row->url, 0, 7)) && strcasecmp ('https://', substr($row->url, 0, 8)) ) {
				// Insert 
				$row->url = 'http://'.$row->url;
			}
		}
		if ( !empty($row->state)) {
			$row->state= strtoupper($row->state);
		}
		$row->modified = date('Y:m:d H:i:s');
		
		
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
				$msg = 'Changes to Contact saved';
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart . '&task=edit&cid[]=' . $row->id;
				break;
			
			case 'save':		
			default:
				$msg = 'Contact saved';
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart;
			break;
		
		}
		$this->setRedirect($link, $msg);
	}
	// Allow for pagination
	function showContacts ()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	
		
	

		// Filter, sort, search parameters
		// >> Sort by : category, city, organization, institution?, modified
		// search filter
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'organization',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );

		$filter_catid		= $mainframe->getUserStateFromRequest( $option.'filter_catid',		'filter_catid',		'',				'string' );
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
	
		// Retrieve list of categories for selection
		$query = "SELECT * FROM #__pmc_contact_cat ORDER BY name ASC";
		$db->setQuery( $query);
		$catrows = $db->loadObjectList();
		if ( $db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		$categories = array();
		$categories[] = array('value' => '', 'text' => '- Select Category -');

		foreach ($catrows as $cat )
		{
			$categories[] = array('value' => $cat->id, 'text' => $cat->name);
		}
		// search filter

		// Generate HTML
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$this->lists['search']= $search;
		$this->lists['categories'] = JHTML::_('select.genericList', $categories, 'filter_catid', 'class="inputbox" '. $javascript , 'value', 'text', $filter_catid);

		

		// Add to WHERE clause
		// >> Search : organization, institution, city
		$wheresql = '';
		if ($search) {
			// $wheresql = ' WHERE LOWER(u.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				// .' OR LOWER(u.url) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$wheresql = ' WHERE LOWER( organization) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		if ($filter_catid) {
			if ($search) $wheresql .= " AND catID = '" . $filter_catid ."'";
			else $wheresql = " WHERE catID = '" . $filter_catid ."'";
		}

		// Set order clause - default column is 'organization'
		if ($filter_order != 'organization') $ordersql = $filter_order . ' ' . $filter_order_Dir. ' , organization ASC';
		else $ordersql = $filter_order . ' ' . $filter_order_Dir;

	
		$query = "SELECT co.*, ca.name  FROM #__pmc_contact co JOIN #__pmc_contact_cat  ca ON co.catID = ca.id $wheresql ORDER BY $ordersql "; 
		// echo $query;
		
		// Retrieve total number of items first
		
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
		// table ordering
		$this->lists['order_Dir'] = $filter_order_Dir;
		$this->lists['order'] = $filter_order;

		HTML_PContact::showContacts( $rows, $option, $pageNav);
	
	}
	
/*

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
			
			
			$query = "DELETE FROM #__pmc_glossary WHERE id IN ( $cids)";
			$db->setQuery( $query);
			if ( !$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
			}
		}
		$this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}
	*/

	/* Categories */
	
	/* SHow all categories */ 
	function categories() {
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	
	
	
		// Short list, no filtering/sorting
		
		// 
		$query = "SELECT * FROM #__pmc_contact_cat ORDER BY name";
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
	
		HTML_PContact::showCategories ( $rows, $option, $pageNav);
	}
	function editCategory()
	{
		global $option;
		$row =& JTable::getInstance( 'PCategory', 'Table');
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		
		HTML_PContact::editCategory($row, $option, $lists);
	}

	function saveCategory ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'PCategory', 'Table');	
		$db =& JFactory::getDBO();	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		
	
		$row->name  = JRequest::getVar('name','','post', 'string', JREQUEST_ALLOWRAW);
		
		
		if  ( empty( $row->name))
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
			
			case 'save':		
			default:
				$msg = 'Category saved';
				$link = 'index.php?option=' . $option . '&task=categories';
				break;
		
		}
		// $mainframe->redirect($link, $msg);
		$this->setRedirect($link, $msg);
	}
	function removeCategory()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$cid =JRequest::getVar('cid',array(), '', 'array');
		$db =& JFactory::getDBO();	
		
		if (count ($cid))
		{
			$cids = implode( ',', $cid);


			// Check whether there are contacts with this category
			//	 If so, tell user to first delete them
			$query = "SELECT * FROM #__pmc_contact WHERE catID IN ($cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			$rows = $db->loadObjectList();
			if (count($rows) > 0) {
				echo "<script>alert('There are contacts assigned to this category. Please edit or remove them first');
						window.history.go(-1); </script>\n<br />\n";
				exit();
			}
			
			

			// Delete the section(s)
			$query = "DELETE FROM #__pmc_contact_cat WHERE id in (  $cids)";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "<script>alert('".$db->getErrorMsg(). "');
						window.history.go(-1); </script>\n";
				exit();
			}
			
		}
		$this->setRedirect('index.php?option='.  $option. '&task=categories&limit='. $limit .'&limitstart='. $limitstart) ;
		
		// $this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart );
	}
	

}

?>
