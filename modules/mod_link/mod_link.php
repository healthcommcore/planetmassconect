<?php
/**
* @version 1.0 $
* @package Raffle
* @copyright (C) 2007 HCC
*/
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted Access.' );



// echo $params->get( 'moduleclass_sfx' );

/*if (($user = initData()) == NULL) return;
mysql_close( $userMsqlDB);
$userMsqlDB = null;
*/
global $mainframe;
	$view = trim( JRequest::getVar(  'view'));
	if ($view == 'url')  {
	
		return;
		
	}		

$links =  $params->get( 'links' );


// retrieve title and description for each 
		$db =& JFactory::getDBO();	

		if (count($links) > 1) $linklist = implode( ',', $links);
		else $linklist = $links;
		
// print_r($linklist);
			$query = "SELECT * FROM #__pmc_tip WHERE id IN ($linklist) AND published = 1 order by ordering";
			$db->setQuery( $query);
			if (!$db->query())
			{
				echo "Database error:".$db->getErrorMsg() ;
				// exit();
			}
			$rows = $db->loadObjectList();
			if (count($rows) > 0) {
				// print_r($rows);
			}
			

?>
<?php if ( $params->get( 'show_ebplink' ) == 1 ) { ?>
<div class="rightnavimgs"><a href="index.php?option=com_content&view=article&id=16&Itemid=45" title=""><img alt="" src="images/stories/learn_about_EBPs.png" border="0" /></a></div>
<?php } ?>

<div id="AccordionContainer" class="AccordionContainer">
<div class="header">
How do I...</div>

<?php
	$i = 1;
	foreach ($rows as $row) {

	
	// print_r($row);
?>
<!--<div onclick="runAccordion(<?//php echo $i?>);">-->
<div class="tip_title" onselectstart="return false;">
<?php echo $row->title; ?>
</div><!--</div>>-->
<div id="tip<?php echo $i?>content" class="tip_content">
<div class="tip_copy">
<?php echo $row->description; ?>
</div>

<?php 
	if ( $row->contentType == 'Help/Other' ) {
		$url = "index.php?option=com_content&view=article&id=$row->contentID&Itemid=45"; /// Invisible menu, 'EBP' item, but won't affec title or menus
	}
	if ( $row->contentType == 'Glossary' ) {
		// If handle Back link in future: &back=".urlencode($_SERVER['REQUEST_URI']) . "&backtxt=". urlencode($page_title);
		$url = "index.php?option=com_glossary&view=glossary&Itemid=6&cid=$row->contentID";
	}
	if ( $row->contentType == 'Resource' ) {
		// If handle Back link in future: &back=".urlencode($_SERVER['REQUEST_URI']) . "&backtxt=". urlencode($page_title);
		$url = "index.php?option=com_weblinks&view=category&id=$row->contentID&Itemid=7";
	}
	
	
	if ( ($row->contentID != 0 ) && ($row->contentType != 'Tip'))
	{
	// Display Read More link only if something to link to
?>

<p><a class="readmore" href="<?php echo $url ?>">Read more</a></p>
<?php } ?>

</div>

<?php
	
	$i++;
} 

?>


</div>
<?php if ( $params->get( 'show_ccplink' ) == 1 ) { ?>

<div class="rightnavimgs"><a href="http://cancercontrolplanet.cancer.gov/" title="" target="_blank" onclick="pageTracker._trackPageview('/outgoing/cancercontrolplanet.org'"><img alt="" src="images/stories/ccplogo2.gif" border="0" /></a></div>

<?php } ?>
