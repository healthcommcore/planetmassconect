<?php

defined ( '_JEXEC') or die ('Restricted access');
?>
<h2><?php echo $this->step->title; ?></h2>

<div class="componentheading<?php echo $this->suffix;?>">
<?php if ($this->showtitle) echo $this->pagetitle ?>

</div>
<table class="blog" cellpadding="0" cellspacing="0">
<td valign="top">

<?php
if ($this->step->description != '')  echo '<p>' . nl2br( $this->step->description) .'</p>';
?>
</td>
</tr>
<tr>
	<td valign="top">
<?php if (count ($this->list) > 0 ) { ?>
<?php foreach ($this->list as $url) : ?>

<?php 
	if ($url->sectionID != $sectionID) {
		// New section	
		echo "<h3>$url->section</h3>";
		$sectionID = $url->sectionID;
	}
?>
					<div>

<table class="contentpaneopen<?php echo $this->suffix;?>">
<tbody><tr>
<!-- Title -->
<td class="contentheading<?php echo $this->suffix;?>" width="80%">

<a href="<?php echo $url->link; ?>"><?php echo ($url->title); ?></a>
</td>
</tr>
<tr>
<td>
<?php
if ($url->description != '') { 
	echo $url->description; 
} 

?>

</td>
</tr>
</tbody></table>
<span class="article_separator">&nbsp;</span>

</div>
<?php endforeach; ?>
<?php } ?>
</td>

</tr>
</tbody></table>
