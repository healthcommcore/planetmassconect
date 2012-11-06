<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="joomla, Joomla" />
  <meta name="description" content="Joomla! - the dynamic portal engine and content management system" />
  <meta name="generator" content="Joomla! 1.5 - Open Source Content Management" />
	<title>Welcome to PLANET MassCONECT!</title>

  <script type='text/javascript'>
/*<![CDATA[*/
	var jax_live_site = 'http://pmc.hccdev.org/index.php';
/*]]>*/



<script type="text/javascript" src="/templates/pmc_template/js/dropdown.js"></script>

<link rel="stylesheet" href="/templates/pmc_template/css/pmc.css" type="text/css" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<!--[if lte IE 6]>
<script type="text/javascript" src="/templates/pmc_template/js/ie_suckerfish.js"></script>
<link rel="stylesheet" href="/templates/pmc_template/css/styles.ie.css" type="text/css" />
<![endif]-->
<!--[if lte IE 7]>
<link rel="stylesheet" href="/templates/pmc_template/css/styles.ie7.css" type="text/css" />
<![endif]-->
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
     </div>
     
<!-- MAIN MENU -->     
        
     
<!-- CONTENT AREA -->  
           
    <div id="roundedtop">
        <div id="roundtopleft">
        	<div id="roundtopright">
        	</div>

        </div>
    </div>
        
    <div id="content_area">
    	<div id="content_module">
    		
        </div>
        <div id="content_component">
        	


<div class="">
	<div id="page" class="full-article">
		
				<div class="article-rel-wrapper">
						<h2 class="contentheading">
				Welcome			</h2>
				 	</div>

		
		
				<div id="content_container">
			
			
<?php


	$op = trim($_GET['op']);

if ( ($op == 'submit') ) {
	// should not get here
	echo 'should not get here';
}

else {
 	$option = trim($_GET['oldoption']);
	$id = trim($_GET['oldid']);
	$itemid = trim($_GET['olditemid']);
	$view = trim($_GET['oldview']);
	$layout = trim($_GET['oldlayout']);
	
	// 
	$params = '';
	if (!empty($view)) {
	
	 	if (!empty($params)) $params .= "&view=$view";
		else   $params .= "?view=$view";
	}
	if (!empty($id)) {
	
	 	if (!empty($params)) $params .= "&id=$id";
		else   $params .= "?id=$id";
	}
	if (!empty($itemid)) {
	
	 	if (!empty($params)) $params .= "&Itemid=$itemid";
		else   $params .= "?Itemid=$itemid";
	}
	if (!empty($option)) {
	
	 	if (!empty($params)) $params .= "&option=$option";
		else   $params .= "?option=$option";
	}
	if (!empty($layout)) {
	
	 	if (!empty($params)) $params .= "&layout=$layout";
		else   $params .= "?layout=$layout";
	}
	
	// $link = "/index.php?view=$view&id=$id&Itemid=$itemid&option=$option";
	$link = "/index.php$params";
?>
<script language="javascript" type="text/javascript">
function processForm(form) {
				var msg = "Please specify ";

			

				if (form.community.selectedIndex == 0) {
					msg += "<?php echo 'your community'; ?>\n";
				}
				if (form.organization.selectedIndex == 0) {
					msg += "<?php echo 'your organization'; ?>\n";
				}

				
				if (msg != "Please specify ") {
					alert(msg);
					return false;	
				}
				else {				
					return true;
				}

}
</script>
<?php
	echo '<form action="'.$link.'" method="post" name="track" onSubmit="return processForm (this)">'; 
?>
<p>Welcome to PLANET MassCONECT!</p>
<p>Please choose an organization type that is closest to yours from the drop-down menus below. This information will be used for research purposes only.
</p>

	<fieldset class="input">
	<p>
	<select name="community" id="community">
	<option value="">Select your community</option>
	<option value="Boston">Boston</option>
	<option value="Brockton">Greater Brockton Area</option>
	<option value="Lawrence">Lawrence</option>
	<option value="Lowell">Greater Lowell Health Alliance, CHNA 10</option>
	<option value="Worcester">Worcester</option>
	<option value="Other">Other</option>

	</select>
    <br /><br />
	
    
	<select name="organization" id="organization">
	<option value="">Select your organization</option>
	<option value="Advocacy/Information Organization">Advocacy/Information Organization</option>
	<option value="Charity/Foundation/Funding Organization">Charity/Foundation/Funding Organization</option>
	<option value="Community Based Organization">Community Based Organization</option>
	<option value="Community Based Health Center">Community Based Health Center</option>
	<option value="Educational Institution">Educational Institution</option>
	<option value="Elder Services Organization">Elder Services Organization</option>
	<option value="Governmental Agency">Governmental Agency</option>
    <option value="Hospital">Hospital</option>
	<option value="Social Service/Assistance Organization">Social Service/Assistance Organization</option>
	<option value="Private Healthcare Provider">Private Healthcare Provider</option>
	<option value="Private Non-profit Organization">Private Non-profit Organization</option>
    <option value="Public Health Department">Public Health Department</option>
	<option value="Youth/Child Serving Organization">Youth/Child Serving Organization</option>
	<option value="Other">Other</option>
    <option value="PLANET Staff">**PLANET Staff**</option>
	</select>
	<input type="submit" name="Submit" class="button" value="<?php echo 'Submit' ?>" />
	</fieldset>

	<input type="hidden" name="op" value="submit" />
</form>
<?php } ?>



			        </div>    
	</div>
</div>
        </div>
    </div>
    <div id="roundedbottom">
        <div id="roundbotleft">
        	<div id="roundbotright">

        	</div>
        </div>
    </div>
</div>

</body>

</html>


</body>
</html>
