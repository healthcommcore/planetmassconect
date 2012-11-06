<?php

defined ( '_JEXEC') or die ('Restricted access');
// $buttonurl =  "images/M_images/printButton.png";
function showfield( $field, $label = '') {
	if (!empty( $field)) echo $label . ($field) . '<br>';

}
$contact = $this->contact->organization;
$document =& JFactory::getDocument();
$document->setTitle($contact);
?>

<div id="content_module">
<h1><?php echo $this->contact->organization; ?></h1>

<div id="content_container">


<div class="contact<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php
	

	showfield($this->contact->specialty);
	showfield($this->contact->institution);
	showfield($this->contact->building);
	showfield($this->contact->address1);
	showfield($this->contact->address2);
	// >> Merge city/state/zip
	$str = $this->contact->city;
	if (!empty($this->contact->state)) {
		if (!empty($str)) $str .= ', '.$this->contact->state;
		else 	$str = $this->contact->state;
	}
	if (!empty($this->contact->zip)) {
		if (!empty($str)) $str .= ' '.$this->contact->zip;
		else 	$str = $this->contact->zip;
	}
	
	showfield($str);
	// showfield($this->contact->state);
	// showfield($this->contact->zip);
	
	showfield($this->contact->telephone, 'Telephone: ');
	showfield($this->contact->fax, 'Fax: ');
	showfield($this->contact->email);
	if (!empty( $this->contact->url)) echo 'Web site: <a href="'.($this->contact->url).'" target="_blank">'. ($this->contact->url) . '</a><br>';
	echo '<br>';
	showfield($this->contact->description);
	
	echo '<br /><div class="modified">';
	showfield($this->category);
	$mod = date('M j, Y', strtotime($this->contact->modified));
	showfield($mod, 'Last updated on ');
	echo '</div><br />';
	?>


</div>

</div><!--end content_container -->
</div><!-- end content_module -->

<?php 
?>


		

