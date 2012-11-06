<?php // @version $Id: default_items.php 11917 2009-05-29 19:37:05Z ian $
defined('_JEXEC') or die('Restricted access');
?>

<!--div class="display">
	<form action="<?php echo $this->escape($this->action); ?>" method="post" name="adminForm">
		<?php echo JText :: _('Display Num'); ?>&nbsp;
		<?php echo $this->pagination->getLimitBox(); ?>
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order'] ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
	</form>
</div-->

<ul class="links-resource">


	<?php foreach ($this->items as $item) : ?>

	<li><a class="link-resource" target='_blank' title="something about EBSCOhost" href="$item->link">EBSCOhost</a><br /><span class="ldes-resource"><?php echo nl2br($item->description); ?></span></li>

	<?php endforeach; ?>

</ul>


<!--p class="counter">
	<?php echo $this->pagination->getPagesCounter(); ?>
</p-->
<?php // echo $this->pagination->getPagesLinks();?>
