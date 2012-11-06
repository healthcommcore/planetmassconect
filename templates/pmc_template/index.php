<?php
/**
 * @copyright	Copyright (C) 2005 - 2009 RocketTheme, LLC - All Rights Reserved.
 * @license		GNU/GPL, see LICENSE.php
**/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );

session_start();
$community = '';
$organization = '';
$sessionid = '';
$ip_address = '';
global $mainframe;

require_once ( JPATH_SITE .'/includes/pmc/common.php' );
# create constant
define("IS_COOKIES",count($_COOKIE)?true:false);

// Make sure we're not at the form
$option = trim( JRequest::getVar(  'option', ''));
$id = trim( JRequest::getVar(  'id',0));
$itemid = trim( JRequest::getVar(  'Itemid',0));
$view = trim( JRequest::getVar(  'view', ''));

/*
print_r($option);
print_r($id);
print_r($option);
print_r($view);
*/

function getIP(){
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return trim($ip);
}

$page_title = $mainframe->getPageTitle();
// echo $page_title;


$op = trim( JRequest::getVar(  'op', null));

if ( ($op == 'submit') ) {
	$option = trim( JRequest::getVar(  'oldoption'));
	$id = trim( JRequest::getVar(  'oldid'));
	$itemid = trim( JRequest::getVar(  'olditemid'));
	$view = trim( JRequest::getVar(  'oldview', null));
	$op = trim( JRequest::getVar(  'op', null));
	$community = trim( JRequest::getVar(  'community'));
	$organization = trim( JRequest::getVar(  'organization'));
	$sessionid = session_id();	// only if cookie. Else 0
	$ip_address = getIP();
	
	// echo 'Community =' . $community;
	// echo 'organization =' . $organization;

	// Save data into cookie
	$status = setcookie("Community", $community, time()+ (3* 365 * 3600) );	// Make it 3 yrs
	$status = setcookie("Organization", $organization, time()+ (3* 365 * 3600) );	// Make it 3 yrs
}

else {

	# example of using constant
	if(IS_COOKIES) {
	   # do something cookie related
		// echo "Cookies are enabled on your browser";
		// Check whether values are set
		$community = $_COOKIE["Community"];
		$organization = $_COOKIE["Organization"];
		$sessionid = session_id();	// only if cookie. Else 0
		$ip_address = getIP();
		// echo $sessionid;
		//echo $community . " " . $organization;
	
		// echo 'Community =' . $community;
		if (empty($community) ||empty($organization) ) {
			echo 'redirect to form';
			// Need to pass current URL so we can return to it after form submitted
			$link = "http://www.planetmassconect.org/form.php?oldview=$view&oldid=$id&olditemid=$itemid&oldoption=$option";
			// echo $link;
			$mainframe->redirect($link, $msg);
		}
	}
	else  {
		// echo "Cookies are <b>NOT</b> enabled on your browser";
	}
}
pageHit($page_title, $community, $organization,$sessionid, $ip_address);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />


<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/pmc_template/css/pmc.css" type="text/css" />
<link rel="shortcut icon" href="<?php echo $this->baseurl; ?>/images/favicon.ico" />
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/pmc_template/css/styles.ie6.css" type="text/css" />
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/pmc_template/css/styles.ie7.css" type="text/css" />
<![endif]-->
<!--<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/pmc_template/js/accordion_menu.js"></script>-->
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/pmc_template/js/dropdown.js"></script>
</head>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-12012144-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<body>

<div id="wrapper">

<!-- LOGO AND TOP MENU -->  

	<div id="header">
    	<a href="/"><img src="/images/blank.png" id="logolink" border="0" /></a>
    	<div id="top_menu_right">
        	<div id="top_menu_left">
        		<jdoc:include type="modules" name="topnav" style="none" />
        	</div>
        </div>
     </div>
     
<!-- MAIN MENU -->     
        
     <div id="main_menu">
        	<jdoc:include type="modules" name="menu" style="none" />
     </div>
     <div id="discussion">
          	<jdoc:include type="modules" name="discussion" style="none" />
     </div>
     
<!-- CONTENT AREA -->  
           
    <div id="roundedtop">
        <div id="roundtopleft">
        	<div id="roundtopright">
        	</div>
        </div>
    </div>
    <?php echo ($view != 'url' ?  "<div id='content_area'>" : "<div id='iframe_area'>"); ?>
        <div id="content_module">
            <jdoc:include type="modules" name="content" style="none" />
        </div>
        <div id="content_component" class="column">
            <jdoc:include type="component" />
        </div>
        <?php if($view != 'url') : ?>
            <div id="column_right" class="column">
            <?php if ($this->countModules('column_right')) : ?>
                
                    <jdoc:include type="modules" name="column_right" style="xhtml" />
                
            <?php endif; ?>
            
            </div>
        <?php endif; ?>
        <?php if ($this->countModules('column_left')) : ?>
            <div id="column_left">
                <jdoc:include type="modules" name="column_left" style="xhtml" />
            </div>
        <?php endif; ?>
        
        <div class="clr"></div>
        <div id="resource_module">
            <jdoc:include type="modules" name="resource_module" style="xhtml" />
        </div>
    </div>
    <div id="roundedbottom">
        <div id="roundbotleft">
        	<div id="roundbotright">
        	</div>
        </div>
    </div>
    
<!-- LOGIN -->
	<?php if ($this->countModules('bottom')) : ?>
    	<div id="bottom">
        	<jdoc:include type="modules" name="bottom" style="xhtml" />
        </div>
    <?php endif; ?>
	
</div>

</body>

</html>
