<?php

defined ( '_JEXEC') or die ('Restricted access');
// $buttonurl =  "images/M_images/printButton.png";
// print_r($this->setData);
?>

<div id="content_module">
<h1>Glossary</h1>

<div id="content_container">
<a name="Menu" id="Menu"></a>
<!--div class="pagenav"-->

<div class="glossarymenu">
<ul>

<?php
//echo 'A= '. ord('A');
//echo 'Z= '. ord('Z');
// Create copy of glossary entries array
$entries = array();

function truncate (&$item1, $key)
{
    $item1 = $item1[0];
}

foreach ($this->setData as $entry) : 
	$entries[] = ucfirst($entry->term);
endforeach; 

// print_r($entries);

array_walk($entries, 'truncate');
// print_r($entries);


for ( $i = ord('A'); $i <= ord('Z'); $i++) {
	// Determine whether we have data for the letter. If not, display letter without link
	$key = array_search(chr( $i), $entries); 
	if ( $key === FALSE) 
		echo '<li>'. chr( $i) . '</li>';	
	else
		echo '<li><a href="#'. chr( $i) .'">'. chr( $i) . '</a></li>';	
}

// Display links to each alphabetical letter
//foreach ($this->sets as $set) {
	?>
	<!--a href="index.php?option=<?php echo $this->option ?>&view=glossary&Itemid=<?php echo $this->itemid ?>&set=<?php echo $set ?>"><?php echo $set ?></a>&nbsp;&nbsp; -->
 <?php // } 

?>
</ul></div>


<?php if (count ($this->setData) > 0 ) { ?>

<?php 
	$letter = 0;

	foreach ($this->setData as $entry) : 
	// $words = explode(' ',$entry->term);
		// >> should make sure first letter is uppercase
		// $entry = ucfirst($entry);
		$string = ucfirst($entry->term);
		if ($letter != ord($string[0])) {
			// End previous if any
			if ($letter != 0 ) {
 				echo '<br /><div style="margin-right:13px"><a class="backtotop" href="#Menu" title="">Back to the top </a></div><br />';
			}
			$letter = ord($string[0]);
			
			// Display letter
		?>
			<br /><a name="<?php echo $string[0]?>"></a><span class="glossary_header"><?php echo $string[0]?></span><br />
        
        <?php
			
		}
?>
<div class="glossary_entry"><h2><?php echo $entry->term ?>&nbsp;</h2>
<?php echo $entry->definition ?>

<div style="text-align:right; " ><!--adapted from --><?php echo $entry->source ?></div></div>
<?php endforeach; 

			if ($letter != 0 ) {
 				echo '<br /><a class="backtotop" href="#Menu" title="">Back to the top </a><br />';
			}

?>

<?php } ?>
</div><!--end content_container -->
</div><!-- end content_module -->

		

