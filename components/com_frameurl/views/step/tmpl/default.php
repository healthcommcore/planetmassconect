<?php

defined ( '_JEXEC') or die ('Restricted access');
$step = $this->step->title;
$document =& JFactory::getDocument();
$document->setTitle($step);
?>
<h2 class="contentheading<?php echo $this->suffix;?>"><?php echo $this->step->title; ?></h2>

<div id="content_container">
<!--div class="componentheading<?php echo $this->suffix;?>">
<?php // if ($this->showtitle) echo $this->pagetitle ?>
</div-->

<?php
if ($this->step->description != '')  echo $this->step->description;
$sectionID = 0;

?>
<a name="Menu" id="Menu"></a>
<?php
	$sections = array();
	
	if (count ($this->list) > 0 ) { 
		foreach ($this->list as $url) :

		if ($url->sectionID != $sectionID) {
			$sectionID = $url->sectionID;
			$sections[] = $url->section;
		}
	
		endforeach; 
		
		// print_r($sections);
	}

	if (count($sections) > 0) {
?>


<?php
	if (count($sections) >= 2) {
?>

<div class="resourcemenu">

<ul>
<?php
		foreach ($sections as $section) {
			echo '<li><a href="#'. $section .'" title="">'. $section .'</a></li>';

		?>

<?php
		}
		?>
</ul></div>
<?php
		}
	}
?>

<?php if (count ($this->list) > 0 ) { ?>
<?php 
	$sectionID = 0;

	foreach ($this->list as $url) : ?>

<?php 
	if ($url->sectionID != $sectionID) {
		// New section
		if ($sectionID != 0 ) {
			echo '<a class="backtotop" href="#Menu" title="">Back to the top </a><br />';
			echo '</div>';	
		}
		
		echo '<span class="stepsheader"><a name="'. $url->section .'" id="'. $url->section .'">'. $url->section .'</a></span>';
		echo '<div class="steps">';
		if ($url->sectiondescription != '') echo '<p>'. $url->sectiondescription. '</p>';
		$sectionID = $url->sectionID;
	}
?>
    
    <a href="<?php echo $url->link; ?>"><?php echo ($url->title); ?></a>
    <?php
    if ($url->pdf) { ?> (PDF) <img src="images/pdficon_large.gif" alt="PDF file" />
    <?php } ?>
    <?php
    if ($url->description != '') { 
        echo $url->description; 
    } 
	else echo '<p></p>';	// >> check with DR
    
    ?>
    
    <!--span class="article_separator">&nbsp;</span-->
    
<?php endforeach; 
		if ($sectionID != 0 ) {
			echo '<a class="backtotop" href="#Menu" title="">Back to the top </a><br />';

			echo '</div>';	
		}
?>
<?php } ?>
</div>
