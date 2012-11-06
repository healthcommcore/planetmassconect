	<?php // @version $Id: default_results.php 10381 2008-06-01 03:35:53Z pasamio $
defined('_JEXEC') or die('Restricted access');

?>

<?php if (!empty($this->searchword)) : ?>
<div class="searchintro">
	
	
		<div class="readon-wrap1"><div class="readon1-l"></div><a href="#form1" class="readon-main" onclick="document.getElementById('search_searchword').focus();return false" onkeypress="document.getElementById('search_searchword').focus();return false"><span class="readon1-m"><span class="readon1-r"><!--<?php echo JText::_('Search_again') ?>--></span></span></a></div><div class="clr"></div>
	</p>
</div>
<?php endif; ?>

<?php if (count($this->results)) : ?>

<!--Search result title-->
<div class="sidemod-title"><h2 class="side"><?php echo JText :: _('Search_result'); ?></h2></div>

<p>
	<div class="readon-wrap1"><div class="readon1-l"></div><a class="readon-main"><span class="readon1-m"><span class="readon1-r"></span></span></a></div>
</p>

<!--Display number of results-->
<?php if (count($this->results)) : ?>
<div class="display">
<label for="limit"><?php echo JText :: _('Display Num') ?></label>
	<?php echo $this->pagination->getLimitBox(); ?>
	
</div>
<?php endif; ?>

<input type="hidden" name="task"   value="search" />
</form>


<!--Start list-->
<div class="results">
	<?php $start = $this->pagination->limitstart + 1; ?>
	<ul class="list" start="<?php echo  $start ?>">
    
<!--Total Results and Page__of__-->
    	<div class="bold">
		<?php echo JText::_('Search Keyword') ?> <span style="color:#0091CD"><?php echo $this->escape($this->searchword) ?></span>
		<?php echo $this->result ?>
		<br />
		<?php echo $this->pagination->getPagesCounter(); ?>
		</div>

<!--Listed results-->
		<?php foreach ($this->results as $result) : ?>
		<?php
		$text = $result->text;
		$text = preg_replace( '/\[.+?\]/', '', $text);
		?>
        
<!--Attempted alternating color
        <?php 
			$resultCount = $this->result;
			if($resultCount % 2 == 0){
			echo "<li class=\"results-odd\">";
		}
		else{
			echo "<li class=\"results-even\">";
		}
		?>
      	-->  
        
        <li>
			<?php if ($result->href) : ?>
			<h4>
				<a href="<?php echo JRoute :: _($result->href) ?>" <?php echo ($result->browsernav == 1) ? 'target="_blank"' : ''; ?>>
					<?php echo $this->escape($result->title); ?></a>
			</h4>
			<?php endif; ?>
			<?php if ($result->section) : ?>
			<!--<h5><?php echo JText::_('Category') ?>:
				<span class="small">
					<?php echo $this->escape($result->section); ?>
				</span>
			</h5>-->
			<?php endif; ?>

			<div class="description">
				<?php echo $text; ?>
			</div>
			<!--<span class="small">
				<?php echo $result->created; ?>
			</span>-->
		</li>
		<?php endforeach; ?>
	</ol>
    
<!--Page nav-->
	<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div><br />
</div>
<?php else: ?>
<div class="noresults"></div>
<?php endif; ?>