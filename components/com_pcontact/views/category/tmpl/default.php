<?php

defined ( '_JEXEC') or die ('Restricted access');
$category = $this->category;
$document =& JFactory::getDocument();
$document->setTitle($category);
?>
<h2 class="contentheading<?php echo $this->suffix;?>"><?php echo $this->category; ?></h2>

<div id="content_container">
<!--div class="componentheading<?php echo $this->suffix;?>">
</div-->

<?php
// print_r($this->list);
?>
<a name="Menu" id="Menu"></a>
<?php
	$sections = array();
	$r = 0;
	if (count ($this->list) > 0 ) { ?>
		<table class="step2list" cellspacing="0">
	<?php 
		foreach ($this->list as $contact) :
		?>
            <tr class= "<?php echo "row$r"; ?>">
			<td>
    		<a href="<?php echo $contact->link; ?>"><?php echo ($contact->organization); ?></a></td> 
            <td> <?php echo ($contact->specialty); ?>
			</td>
			<td> <?php echo ($contact->institution); ?>
			</td>
			</tr>
		<?php $r = 1 - $r; ?>
		<?php endforeach; ?>
		</table>
		
		<?php
		
	}

?>

</div>
