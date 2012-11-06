<?php // @version $Id: default_form.php 10381 2008-06-01 03:35:53Z pasamio $
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JRoute::_( 'index.php?option=com_search#content' ) ?>" method="post" class="search_result">
<a name="form1"></a>

<div class="search_header">Search Parameters</div>

<fieldset class="search_container">
<label for="search_searchword"><?php echo JText::_('Search Keyword<br>(20 character limit) :') ?> </label>
<input type="text" name="searchword" id="search_searchword" size="40" maxlength="40" value="<?php echo $this->escape($this->searchword) ?>" class="inputbox" />
<input type="submit" name="Search" onClick="this.form.submit()" class="button" value="<?php echo JText::_( 'Search' );?>" />
<p class="margin">
<label for="ordering" class="ordering"><?php echo JText::_('Ordering') ?>:</label>
<span class="right">
<?php echo $this->lists['ordering']; ?>
</span>
<?php echo $this->lists['searchphrase']; ?>
</p>
</fieldset>

<?php if ($this->params->get('search_areas', 1)) : ?>
<fieldset class="only"><legend><?php echo JText::_('Search Only') ?>:</legend>
	<?php foreach ($this->searchareas['search'] as $val => $txt) : ?>
		<?php $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="true"' : ''; ?>
		<input type="checkbox" name="areas[]" value="<?php echo $val ?>" id="area_<?php echo $val ?>" <?php echo $checked ?> />
		<label for="area_<?php echo $val ?>">
		<?php echo JText::_($txt); ?>
		</label>
	<?php endforeach; ?>
</fieldset>
<?php endif; ?>

