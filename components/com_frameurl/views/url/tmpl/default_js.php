<?php

defined ( '_JEXEC') or die ('Restricted access');
// $buttonurl =  "images/M_images/printButton.png";
// print_r($this->url);
?>
<script language="JavaScript" type="text/javascript">
<!--
var pos=0; //100;

function Scroll(up) {
  if (!document.getElementById) return;
  var winelement;
  winelement=document.getElementById("thetext2");
  if (winelement == null) alert ('winelement not found');
  
  
 
  
  // alert('obj cur top = '+ obj.style.pos);
  newpos = pos - (up? 130 : -130);
  //lower limit
  if (up) {
  	if (newpos < 0-winelement.offsetHeight+ 40) {
	   // alert('stop at pos= '+ newpos + ' object height ='+ winelement.offsetHeight);
	    // downelement = document.getElementById("down");
		// downelement.style.disabled = true;
		return;
	}
  } else
{  	if (newpos > 0) {
	   // alert('stop at pos= '+ newpos);
		return;
	}
 }
 pos = newpos;
 // alert('obj cur top = '+ obj.style.pos);


 // obj.style.top=pos;
 winelement.style.top = newpos +'px';
  // window.setTimeout("Scroll()",30);
}
-->
</script>

<div id="content_module">

<?php			if ($this->url == NULL) { ?>
<h1>This link does not exist </h1>
<?php 
} else {
?>
<h1><?php echo $this->url->title ?></h1>

<?php if (!empty ($this->url->instructions)) { ?>
<!-- UP/DOWN only if necessary - how do we know this? -->
<!-- Current area 170px by 660px -->
<p><span id="up">[<a href="javascript:Scroll(0)">Up</a>]</span></p>
<p><span id="down">[<a href="javascript:Scroll(1)">Down</a>]</span></p>
<div id="thewindow" style="position:relative; width:600px;height:170px;
  overflow:hidden; border-width:1px; border-style:solid; border-color:grey;">
<div id="thetext2" style="position:absolute;width:600px;left:5px;top:0px;">
<p><?php echo $this->url->instructions ?></p>


</div>
</div>
<?php } ?>

<p><?php // echo $this->url->instructions ?></p>
<p><a href="<?php echo $this->url->url ?>" <?php echo ($this->url->pdf )? "": 'target="_blank"' ?> ><?php echo $this->url->url ?></a></p>


<?php } ?>
</div><!--end content module -->
		
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
<div class="contentpane">
<?php if (! $this->url->pdf) { ?>
<iframe 	id="blockrandom"
	name="iframe"
	src="<?php echo $this->url->url ?>"
	width="100%"
	height="500"
	scrolling="auto"
	align="top"
	frameborder="0"
	class="wrapper">
	This option will not work correctly. Unfortunately, your browser does not support inline frames.</iframe>
<?php } 
	else { ?>
	<embed src="<?php echo $this->url->url ?>" width="850" height="500"/>
	
<?php	}
?>

</div><!-- end contentpane -->
</div><!-- iframe content component -->

<?php } ?>
		

