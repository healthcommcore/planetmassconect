<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class GlossaryController extends JController
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
		$row =& JTable::getInstance( 'Glossary', 'Table');	
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
		$row =& JTable::getInstance( 'Glossary', 'Table');	
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
		$row =& JTable::getInstance( 'Glossary', 'Table');
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);

		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = $cid[0];
		$row->load($id);
		// print_r($row);
					
		$lists = array();
		
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published);
		// Retrieve some current settings
		$lists['limit'] = $limit;
		$lists['limitstart'] = $limitstart;
		HTML_Glossary::editGlossary($row, $lists, $option);
	
	}

	function save ()
	{
		global $option, $mainframe;
		$row =& JTable::getInstance( 'Glossary', 'Table');	
		$db =& JFactory::getDBO();	
	
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
	
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script>alert('".$row->getError(). "');
				
					window.history.go(-1); </script>\n<br />\n";
			exit();
		}
		
		$row->term  = JRequest::getVar('term','','post', 'string', JREQUEST_ALLOWRAW);
		$row->definition  = JRequest::getVar('definition','','post', 'string', JREQUEST_ALLOWRAW);
		$row->source  = JRequest::getVar('source','','post', 'string', JREQUEST_ALLOWRAW);
		$row->author  = JRequest::getVar('author','','post', 'string', JREQUEST_ALLOWRAW);
		$row->published =JRequest::getVar('published',0, 'post');
		
		/* Check for required inputs */
		if ( ( empty( $row->term))  || ( empty( $row->definition)) )
			{
			echo "<script>alert('Please fill in all the required fields in the form');
					window.history.go(-1); </script>\n<br />\n";
			exit();
		
		}
		// Set /modify certain fields
		if ($row->author == '') {
			$my = $mainframe->getUser();
			$row->author = $my->username;
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
				$msg = 'Changes to Glossary saved';
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart . '&task=edit&cid[]=' . $row->id;
				break;
			
			case 'save':		
			default:
				$msg = 'Glossary saved';
				$link = 'index.php?option=' . $option .'&limit='. $limit .'&limitstart='. $limitstart;
			break;
		
		}
		// $mainframe->redirect($link, $msg);
		$this->setRedirect($link, $msg);
		// $this->setRedirect('index.php?option='.  $option .'&limit='. $limit .'&limitstart='. $limitstart,  $msg );
	}

	// Allow for pagination
	function showGLossaries ()
	{
		global $option, $mainframe;
		$limit =JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$limitstart =JRequest::getVar('limitstart', 0);
		$db =& JFactory::getDBO();	

		// Filter, sort, search parameters
		// search filter
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'term',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );

		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );
	

		// Generate HTML
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$this->lists['search']= $search;
		

		// Add to WHERE clause
		$wheresql = '';
		if ($search) {
			// $wheresql = ' WHERE LOWER(u.title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )
				// .' OR LOWER(u.url) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$wheresql = ' WHERE LOWER(u.term) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}
		
		// Set order clause - default column is 'term'
		if ($filter_order != 'term') $ordersql = $filter_order . ' ' . $filter_order_Dir. ' , term ASC';
		else $ordersql = $filter_order . ' ' . $filter_order_Dir;

	
		$query = "SELECT *  FROM #__pmc_glossary $wheresql ORDER BY $ordersql "; 
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

		HTML_Glossary::showGlossaries( $rows, $option, $pageNav);
	
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
	
	

}

?>
