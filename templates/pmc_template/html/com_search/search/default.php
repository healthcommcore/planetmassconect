<?php // @version $Id: default.php 10498 2008-07-04 00:05:36Z ian $
defined('_JEXEC') or die('Restricted access');
?>

<?php if($this->params->get('show_page_title',1)) : ?>
<div class="component-header"><h2 class="componentheading<?php echo $this->params->get('pageclass_sfx') ?>"><?php echo $this->escape($this->params->get('page_title')) ?></h2></div>
<?php endif; ?>

<div id="page">
	<div class="search-area">
    	<?php echo $this->loadTemplate('form'); ?>
		<?php if (!$this->error) :
			echo $this->loadTemplate('results');
		else :
			echo $this->loadTemplate('error');
		endif; ?>
		
	</div>
</div>