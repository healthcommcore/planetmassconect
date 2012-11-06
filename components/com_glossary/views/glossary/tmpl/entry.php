<?php

defined ( '_JEXEC') or die ('Restricted access');
// $buttonurl =  "images/M_images/printButton.png";
// print_r($this->setData);

/* TAKE OUT FOR NOW 
if ($this->backlink != '') {
?>
	<a href="<?php echo $this->backlink ?>">Back to <?php echo $this->backtext ?></a>

<?php
	
}
*/
$document =& JFactory::getDocument();
$entry = $this->entry;
$title = 'Glossary term: ' . $entry->term;
$document->setTitle($title);

?>



<div id="content_module">
<h1>Glossary Entry</h1>



<div id="content_container">
<?php $entry = $this->entry ?>
<h2><?php echo $entry->term ?>&nbsp;</h2>
<p><?php echo $entry->definition ?></p>

<div style="text-align:right; " ><!--adapted from--> <?php echo $entry->source ?></div>

</div><!--end content_container -->
<!--
<p></p>
<a href="index.php?option=com_glossary&view=glossary&Itemid=6">Glossary</a>
-->

</div><!-- end content_module -->

		

