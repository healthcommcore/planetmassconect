<?php

defined ( '_JEXEC') or die ('Restricted access');
$title = $this->url->title;
$document =& JFactory::getDocument();
$document->setTitle($title);
?>

<h2 class="iframe_contentheading"><?php echo $this->url->title; ?></h2>
<div id="column_left">
<div class="moduletable">
<div class="howdoibox">
<div class="header">
How do I...</div>
<div class="content">
<ul>
<?php // different links depending on iframe type
	// if (count($this->tips) > 0 ) {
	foreach ($this->tips as $row) {
		if ( $row->contentType == 'Tip' ) {
			continue;
		}
		if ( $row->contentType == 'Help/Other' ) {
			$url = "/index.php?option=com_content&view=article&id=$row->contentID&Itemid=45"; /// Invisible menu, won't affec title or menus
		}
		if ( $row->contentType == 'Glossary' ) {
			// If handle Back link in future: &back=".urlencode($_SERVER['REQUEST_URI']) . "&backtxt=". urlencode($page_title);
			$url = "/index.php?option=com_glossary&view=glossary&Itemid=6&cid=$row->contentID";
		}
		if ( $row->contentType == 'Resource' ) {
			// If handle Back link in future: &back=".urlencode($_SERVER['REQUEST_URI']) . "&backtxt=". urlencode($page_title);
			$url = "/index.php?option=com_weblinks&view=category&id=$row->contentID&Itemid=7";
		}
		


?>
<li><a href="<?php echo $url?>"><?php echo $row->title?></a></li>
<?php }  

//}
?> 
</ul>


</div><!-- end content -->
</div><!-- end iframeNavContainer -->
</div><!-- end moduletable -->
</div><!-- end colum_left -->
<div id="content_module">

<?php			if ($this->url == NULL) { ?>
<h1>This link does not exist </h1>
<?php 
} else {
?>


<!-- Backlink deleted -->
<!--<?php if (!empty($this->backlink)) { ?>

	<a href="<?php echo $this->backlink ?>">Back to <?php echo $this->step->title ?> </a><br />
<?php } ?>
<?php if (!empty ($this->url->instructions)) { ?>-->

<!-- HTML Codes by Quackit.com -->
<div class="instrbox">
<div class="header">
About this Resource
</div>
<div class="content">
<?php echo $this->url->instructions ?></div>
</div>
</div>

<?php } ?>



<?php } ?>
</div><!--end content module -->
<div class="clr"></div>
<?php if ($this->url) { ?>

<!-- iframe content component -->
<div id="content_component">
<?php if (! $this->url->pdf) { ?>
        	<script language="javascript" type="text/javascript">
function iFrameHeight() {
	var h = 0;
	if ( !document.all ) {
		h = document.getElementById('blockrandom').contentDocument.height;
		document.getElementById('blockrandom').style.height = h + 60 + 'px';
	} else if( document.all ) {
		h = document.frames('blockrandom').document.body.scrollHeight;
		document.all.blockrandom.style.height = h + 20 + 'px';
	}
}
</script>
<?php } ?>

<!-- contentpane -->
<div class="iframewrapper">
<div class="header">
Resource Window
</div>
<div class="content">
<?php if (! $this->url->pdf) { ?>
<iframe 	id="blockrandom"
	name="iframe"
	src="<?php echo $this->url->url ?>"
	width="100%"
	height="500"
	scrolling="auto"
	align="top"
	frameborder="0">
	This option will not work correctly. Unfortunately, your browser does not support inline frames.</iframe>
<?php } 
	else { ?>
	<embed src="<?php echo $this->url->url ?>" width="910" height="500"/>

<?php	}
?>

</div>
<div class="iframelink">
	<a href="<?php echo $this->url->url ?>" <?php echo ($this->url->pdf )? "": 'target="_blank"' ?> >Click here to open this resource in a new window</a>
</div>
<div class="clr">
</div>
</div>
<?php } ?>
		

