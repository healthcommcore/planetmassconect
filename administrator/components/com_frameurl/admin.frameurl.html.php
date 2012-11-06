<?php

defined ( '_JEXEC') or die ('Restricted access');
class HTML_Frameurl

{
	function editFrameurl( $row, $lists, $option)
	
	{
		$editor =& JFactory::getEditor();
		
		?>
						<script language="javascript" type="text/javascript">
	<!--
		var jsSections = new Array;
        
		<?php
			$k = 0;
			echo "jsSections[".$k++. "] = new Array( '','',' - Select Section - ' );";
			// foreach ( $lists['sectionbystep'] as $foldername => $folder ) {
			foreach ( $lists['sectionbystep'] as $stepID => $step ) {
				// print_r($step);
				// echo '<br>';
				echo "jsSections[".$k++. "] = new Array( '$stepID','',' - Select Section - ' );";
				foreach ( $step as $section ) {

					echo "\njsSections[".$k++. "] = new Array ( '$stepID','$section->id','$section->name' );";
				}
			
			}
			
		?>
		function isBlank(val) {
			if (val == null || val == "") return true;
			for(var i=0;i<val.length;i++) {
				if ((val.charAt(i)!=' ')&&(val.charAt(i)!="\t")&&(val.charAt(i)!="\n")&&(val.charAt(i)!="\r")){return false;}
				}
			return true;
				
		}

		function submitbutton(pressbutton) {
			
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";

			
				if (isBlank(form.title.value)) {
					msg += "<?php echo 'the title'; ?>\n";
				}
				/* URL is optional ?
				if (isBlank(form.url.value)) {
					msg += "<?php echo 'the url'; ?>\n";
				}
				*/

				if (form.stepID.selectedIndex == 0) {
					msg += "<?php echo 'the Step'; ?>\n";
				}
				if (form.sectionID.selectedIndex == 0) {
					msg += "<?php echo 'the Section'; ?>\n";
				}

				
				if (msg != "Please specify ") {
					alert(msg);
					return false;	
				}
				else {				
					if (isBlank(form.url.value)) alert('You did not specify the URL. The link will be saved, but not published');
				
					submitform(pressbutton);
					return;
				}
					
		}
		//-->
		</script>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminForm">
        
        <legend>Details</legend>
        
        <table class="admintable">
        <tr>
        <td width="100" align="right" class="key">
        	ID :
        </td>
        
        <td>
        	<?php if ($row->id > 0) echo $row->id; ?>
 		</td>
               
        </tr>
        <tr>
        <td width="100" align="right" class="key">
        	Title * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="title" id="title" size="50" maxlength="128" value="<?php echo $row->title; ?>" >
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	URL * (include http:// or https://) <br />Required for publishing :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="url" id="url" size="50" maxlength="255" value="<?php echo $row->url; ?>" >
 		</td>
		</tr>
         <tr>
        <td width="100" align="right" class="key">
        	PDF:
        </td>
        
        <td>
        	<?php
			echo $lists['pdf'];
			?>
 		</td>
               
        </tr>
       

        <tr>
        <td width="100" align="right" class="key">
        	Step *:
        </td>
        
        <td>
        	<?php
			echo $lists['steps'];
			?>
 		</td>
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Section *:
        </td>
        
        <td>
        	<?php
			print_r( $lists['sections']);
			// echo $lists['commmunity']; for some weird reason, this doesnt work!
			?>
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Order :
        </td>
        
        <td>
		        <input type="hidden" name="ordering"  value="<?php echo $row->ordering; ?>" />

        	<?php if ($row->id > 0) echo $row->ordering; 
				else echo 'New links default to the last place. Ordering can be changed in the URL listing after this link is saved';
			?>
 		</td>
        </tr>

  
        <tr>
        <td width="100" align="right" class="key">
        	Description :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'description', $row->description, '100%', '250', '40', '10');
			?>
 		</td>
               
        </tr>


        <tr>
        <td width="100" align="right" class="key">
        	Instructions :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'instructions', $row->instructions, '100%', '250', '40', '10');
			?>
 		</td>
        </tr>

		
		
        
        <tr>
        <td width="100" align="right" class="key">
        	Author:
        </td>
        
        <td>
 			<?php echo $row->author; ?>
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Published:
        </td>
        
        <td>
        	<?php
			echo $lists['published'];
			?>
 		</td>
               
        </tr>
        

        
        <tr>
        <td width="100" align="right" class="key">
        	Last modified:
        </td>
        
        <td>
 			<?php echo $row->modified; ?>
 		</td>
               
        </tr>
        
        </table>
       
       
       	</fieldset>
		<!-- hidden fields -->
		<!-- for pagination -->
		<input type="hidden" name="limit" value="<?php echo $lists['limit']; ?>" />
		<input type="hidden" name="limitstart" value="<?php echo $lists['limitstart']; ?>" />

		
        <input type="hidden" name="id"  value="<?php echo $row->id; ?>" />
        <input type="hidden" name="author"  value="<?php echo $row->author; ?>" />
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        
        
        <?php
	
	}
	// List of Frameurls - default view
	function showFrameurl( $rows, $option, $pageNav)
	{
		// $ordering = ($this->lists['order'] == 'a.ordering');
		$ordering = true;
		?>
        
        <form action="index.php" method="post"
 name="adminForm">
 		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_sectionid').value='';this.form.getElementById('filter_stepid').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
					echo $this->lists['steps'];
				?>
			</td>
			
			<td nowrap="nowrap">
				<?php
					echo $this->lists['sections'];
				?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
        <thead>
        <tr>
        	<th width="20">
            	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?> );" />
            
            </th>
            <th class="title">
 			<?php echo JHTML::_('grid.sort',  'Title', 'title', ($this->lists['order'] == 'title' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="15%">
 			<?php echo JHTML::_('grid.sort',  'URL', 'url', ($this->lists['order'] == 'url' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="8%">Description</th>
            <th width="8%">Instructions</th>
            <th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort',  'Published', 'published', ($this->lists['order'] == 'published' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="5%">
 			<?php echo JHTML::_('grid.sort',  'Step', 'step', ($this->lists['order'] == 'step' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="5%">Section</th>
            <th width="8%">Order</th>
            <th width="5%">
 			<?php echo JHTML::_('grid.sort',  'Author', 'author', ($this->lists['order'] == 'author' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
            </th>
			<th width="3%" nowrap="nowrap">
 			<?php echo JHTML::_('grid.sort',  'ID', 'id', ($this->lists['order'] == 'id' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
        </tr>
        </thead>
        
        <?php
		jimport('joomla.filter.filteroutput');
		$k = 0;
		for ($i = 0, $n = count($rows); $i < $n; $i++)
		
		{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		$published = JHTML::_('grid.published', $row, $i);
		
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=edit&cid[]=' . $row->id . '&limit=' . $pageNav->limit. '&limitstart=' . $pageNav->limitstart);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->title; ?></a>
        </td>

        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->url; ?></a>
        </td>
       <td>
        	<?php echo empty($row->description) ? '': substr( strip_tags($row->description), 0, 20) .'...'; ?>
        </td>
       <td>
        	<?php echo empty($row->instructions) ? '': substr( strip_tags($row->instructions), 0, 20) .'...'; ?>
        </td>
  
   
        <td align="center">
        	<?php echo $published; ?>
        </td>
        <td>
        	<?php echo $row->step; ?>
        </td>
        <td>
        	<?php echo $row->section; ?>
        </td>
 			<td class="order">
				<span><?php echo $pageNav->orderUpIcon( $i, ($row->sectionID == @$rows[$i-1]->sectionID),'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $pageNav->orderDownIcon( $i, $n, ($row->sectionID == @$rows[$i+1]->sectionID), 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
        	<?php echo $row->ordering; ?>
			</td>
		<td>

        	<?php echo $row->author; ?>
        </td>
		<td>

        	<?php echo $row->id; ?>
        </td>
        
        </tr>
		
		<?php
        $k = 1 - $k;
		
		}
		?>
		
		<tfoot>
		<td colspan="11"><?php echo $pageNav->getListFooter(); ?></td>
		</tfoot>
        
        </table>
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        <input type="hidden" name="boxchecked"  value="0" />
		<!-- for pagination -->
		<!--input type="hidden" name="limit" value="<?php echo $pageNav->limit; ?>" /-->
		<!--input type="hidden" name="limitstart" value="<?php echo $pageNav->limitstart; ?>" /-->
		<!-- for sort -->
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		<input type="hidden" name="search_value" value="<?php echo $this->lists['search']; ?>" />
 		</form>
        <?php 
		
	}

	/* Sections */
	// List of Sections - default view
	function showSections( $rows, $option, $pageNav)
	{
		// $ordering = ($this->lists['order'] == 'a.ordering');
		$ordering = true;
		?>
        
        <form action="index.php" method="post"
 name="adminForm">
 		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value=''; this.form.getElementById('filter_stepid').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
					echo $this->lists['steps'];
				?>
			</td>
			
		</tr>
		</table>
	
        
 		<table class="adminlist">
        <thead>
        <tr>
        	<th width="20">
            	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?> );" />
            
            </th>
            <th class="title">
			<?php echo JHTML::_('grid.sort',  'Name', 'name', ($this->lists['order'] == 'name' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th class="title" width="15%">
			<?php echo JHTML::_('grid.sort',  'Display Title', 'title', ($this->lists['order'] == 'title' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th class="title">Order</th>
             <th class="title">
			<?php echo JHTML::_('grid.sort',  'Step', 'step', ($this->lists['order'] == 'step' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th class="title" width="20%">Description</th>
            <th class="title">ID</th>
        </tr>
        </thead>
        <?php
		jimport('joomla.filter.filteroutput');
		$k = 0;
		for ($i = 0, $n = count($rows); $i < $n; $i++)
		
		{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=editSection&cid[]=' . $row->id . '&limitstart=' . $pageNav->limitstart);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
          <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo substr( strip_tags($row->name), 0, 50); ?></a>
        </td>
      <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo substr( strip_tags($row->title), 0, 50); ?></a>
        </td>
 			<td class="order">
				<span><?php echo $pageNav->orderUpIcon( $i, ($row->stepID == @$rows[$i-1]->stepID),'orderupsection', 'Move Up', $ordering ); ?></span>
				<span><?php echo $pageNav->orderDownIcon( $i, $n, ($row->stepID == @$rows[$i+1]->stepID), 'orderdownsection', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
        	<?php echo $row->ordering; ?>
			</td>

        <td>
        	<?php echo $row->step; ?>
        </td>
        <td>
        	<?php echo empty($row->description) ? '': substr( strip_tags($row->description), 0, 50) .'...'; ?>
        </td>
      <td>
        	<?php echo $row->id; ?>
        </td>
		</tr>
		<?php
        $k = 1 - $k;
		}
		?>
		
		<tfoot>
		<td colspan="9"><?php echo $pageNav->getListFooter(); ?></td>
		</tfoot>
        
        </table>
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="sections" />
        <input type="hidden" name="boxchecked"  value="0" />
		
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
 		</form>
        <?php 
		
	}

	function editSection ( $row, $option, $lists)
	
	{
		$editor =& JFactory::getEditor();
		?>
 						<script language="javascript" type="text/javascript">
	<!--
        
		function isBlank(val) {
			if (val == null || val == "") return true;
			for(var i=0;i<val.length;i++) {
				if ((val.charAt(i)!=' ')&&(val.charAt(i)!="\t")&&(val.charAt(i)!="\n")&&(val.charAt(i)!="\r")){return false;}
				}
			return true;
				
		}

		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'sections') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";

				if (isBlank(form.name.value)) {
					msg += "<?php echo 'the name'; ?>\n";
				}
			
				if (isBlank(form.title.value)) {
					msg += "<?php echo 'the title'; ?>\n";
				}
				if (form.stepID.selectedIndex == 0) {
					msg += "<?php echo 'the Step'; ?>\n";
				}
				
				if (msg != "Please specify ") {
					alert(msg);
					return false;	
				}
				else				
					submitform(pressbutton);
					return;
					
		}
		//-->
		</script>
      <form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminForm">
        
        <legend>Details</legend>
        
        <table class="admintable">
         <tr>
        <td width="100" align="right" class="key">
        	ID :
        </td>
        
        <td>
        	<?php if ($row->id > 0) echo $row->id; ?>
 		</td>
               
        </tr>
        <tr>
        <td width="100" align="right" class="key">
        	Name * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="name" id="name" size="50" maxlength="128" value="<?php echo $row->name; ?>" >
 		</td>
               
        </tr>
       <tr>
        <td width="100" align="right" class="key">
        	Display Title * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="title" id="title" size="50" maxlength="128" value="<?php echo $row->title; ?>" >
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Step *:
        </td>
        
        <td>
        	<?php
			echo $lists['steps'];
			?>
 		</td>
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Order :
        </td>
        
        <td>
		        <input type="hidden" name="ordering"  value="<?php echo $row->ordering; ?>" />
        	<?php if ($row->id > 0) echo $row->ordering; 
				else echo 'New sections default to the last place. Ordering can be changed in the Section listing after this Section is saved';
			?>
 		</td>
        </tr>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Description :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'description', $row->description, '100%', '250', '40', '10');
			?>
 		</td>
               

        </table>
       
       
       	</fieldset>
        <input type="hidden" name="id"  value="<?php echo $row->id; ?>" />
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        <?php 

	}

	/* Steps */
	// List of Steps - default view
	function showSteps( $rows, $option, $pageNav)
	{
		?>
        
        <form action="index.php" method="post"
 name="adminForm">
 		<table class="adminlist">
        <thead>
        <tr>
        	<th width="20">
            	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?> );" />
            
            </th>
            <th class="title">Name</th>
            <th class="title">Display Title</th>
              <th class="title" width=" 30%">Description</th>
          <th class="title">ID</th>
            <!--th class="title">Published</th-->
            <!--th width=" 50%">Step Number</th-->
        </tr>
        </thead>
        <?php
		jimport('joomla.filter.filteroutput');
		$k = 0;
		for ($i = 0, $n = count($rows); $i < $n; $i++)
		
		{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=editStep&cid[]=' . $row->id . '&limitstart=' . $pageNav->limitstart);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->name; ?></a>
        </td>
        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->title; ?></a>
        </td>
         <td>
        	<?php echo empty($row->description) ? '': substr( strip_tags($row->description), 0, 50) .'...'; ?>
 		</td>
       <td>
        	<?php echo $row->id; ?>
        </td>
        <!--td>
        	<?php echo substr( strip_tags($row->stepnumber), 0, 50); ?>
        </td-->
		</tr>
		<?php
        $k = 1 - $k;
		}
		?>
		
		<!--tfoot>
		<td colspan="3"><?php // echo $pageNav->getListFooter(); ?></td>
		</tfoot-->
        
        </table>
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="sections" />
        <input type="hidden" name="boxchecked"  value="0" />
		
 		</form>
        <?php 
		
	}
	function editStep ( $row, $option, $lists)
	
	{
		$editor =& JFactory::getEditor();
		?>
 						<script language="javascript" type="text/javascript">
	<!--
        
		function isBlank(val) {
			if (val == null || val == "") return true;
			for(var i=0;i<val.length;i++) {
				if ((val.charAt(i)!=' ')&&(val.charAt(i)!="\t")&&(val.charAt(i)!="\n")&&(val.charAt(i)!="\r")){return false;}
				}
			return true;
				
		}

		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'steps') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";

				if (isBlank(form.name.value)) {
					msg += "<?php echo 'the name'; ?>\n";
				}
			
				if (isBlank(form.title.value)) {
					msg += "<?php echo 'the title'; ?>\n";
				}
				
				if (msg != "Please specify ") {
					alert(msg);
					return false;	
				}
				else				
					submitform(pressbutton);
					return;
					
		}
		//-->
		</script>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminForm">
        
        <legend>Details</legend>
        
        <table class="admintable">
        <tr>
        <td width="100" align="right" class="key">
        	ID :
        </td>
        
        <td>
        	<?php if ($row->id > 0) echo $row->id; ?>
 		</td>
               
        </tr>
        <tr>
        <td width="100" align="right" class="key">
        	Name (eg. 'Step 1') * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="name" id="name" size="50" maxlength="128" value="<?php echo $row->name; ?>" >
 		</td>
               
        </tr>


        <tr>
        <td width="100" align="right" class="key">
        	Display Title * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="title" id="title" size="50" maxlength="128" value="<?php echo $row->title; ?>" >
 		</td>
               
        </tr>

        <!--tr>
        <td width="100" align="right" class="key">
        	Step Number *:
        </td>
        
        <td>
        	<?php
			echo $lists['steps'];
			?>
 		</td>
        </tr-->
        <tr>
        <td width="100" align="right" class="key">
        	Description :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'description', $row->description, '100%', '250', '40', '10');
			?>
 		</td>
               
        </tr>

		
        <!--tr>
        <td width="100" align="right" class="key">
        	Sections :
        </td>
        
        <td>
        	<?php
			echo $lists['sections'];
			?>
 		</td>
               
        </tr-->

 
        </table>
       
       
       	</fieldset>
        <input type="hidden" name="id"  value="<?php echo $row->id; ?>" />
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        <?php 

	}

	/* Tips */
	// List of Tips - default view
	function showTips( $rows, $option, $pageNav)
	{
		// $ordering = ($this->lists['order'] == 'a.ordering');
		$ordering = true;
		?>
        
        <form action="index.php" method="post"
 name="adminForm">
 		<table class="adminlist">
        <thead>
        <tr>
        	<th width="20">
            	<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count($rows);?> );" />
            
            </th>
            <th class="title">
			<?php echo JHTML::_('grid.sort',  'Title', 'title', ($this->lists['order'] == 'title' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
             <th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort',  'Published', 'published', ($this->lists['order'] == 'published' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
           <th class="title" width=" 35%">Description</th>
					<th width="8%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Order', 'order', @$lists['order_Dir'], @$lists['order'] ); ?>
						<?php // if ($ordering) echo JHTML::_('grid.order',  $rows ); ?>
					</th>
          <th class="title" width=" 10%">Type</th>
          <th class="title" width=" 5%">PDF</th>
          <th class="title" width=" 5%">Web</th>
            <th class="title">content ID</th>
          <th class="title">ID</th>
        </tr>
        </thead>
        <?php
		jimport('joomla.filter.filteroutput');
		$k = 0;
		for ($i = 0, $n = count($rows); $i < $n; $i++)
		
		{
		$row = &$rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->id);
		$published = JHTML::_('grid.published', $row, $i);
		// Generate own version of HTML because we need to call a different method
		if ($row->published) {
			$published = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\',\'unpublishTip\')" title="Unpublish Item">
		<img src="images/tick.png" border="0" alt="Published" /></a>';
		}
		
		else {
			$published = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'.$i.'\',\'publishTip\')" title="Publish Item">
		<img src="images/publish_x.png" border="0" alt="Unpublished" /></a>'; 
		}
		
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=editTip&cid[]=' . $row->id . '&limitstart=' . $pageNav->limitstart);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
        <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo $row->title; ?></a>
        </td>
        <td align="center">
        	<?php echo $published; ?>
        </td>
         <td>
        	<?php echo empty($row->description) ? '': substr( strip_tags($row->description), 0, 75) .'...'; ?>
 		</td>
			<td class="order">
		<!--
				<span><?php echo $pageNav->orderUpIcon( $i, ($row->stepID == @$rows[$i-1]->stepID),'orderupsection', 'Move Up', $ordering ); ?></span>
				<span><?php echo $pageNav->orderDownIcon( $i, $n, ($row->stepID == @$rows[$i+1]->stepID), 'orderdownsection', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				-->

				<span><?php echo $pageNav->orderUpIcon( $i, true ,'orderuptip', 'Move Up', $ordering ); ?></span>
				<span><?php echo $pageNav->orderDownIcon( $i, $n, true, 'orderdowntip', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
        	<?php echo $row->ordering; ?>
			</td>
        <td>
        	<?php echo $row->contentType; ?>
        </td>
        <td>
        	<?php echo ($row->iframePDF? 'Y': 'N'); ?>
        </td>
        <td>
        	<?php echo ($row->iframeWeb? 'Y': 'N'); ?>
        </td>
         <td>
        	<?php echo $row->contentID; ?>
        </td>
      <td>
        	<?php echo $row->id; ?>
        </td>
		</tr>
		<?php
        $k = 1 - $k;
		}
		?>
		
		<!--tfoot>
		<td colspan="3"><?php // echo $pageNav->getListFooter(); ?></td>
		</tfoot-->
        
        </table>
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="tips" />
        <input type="hidden" name="boxchecked"  value="0" />

		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
 		</form>
        <?php 
		
	}


	function editTip ( $row, $option, $lists)
	
	{
		$editor =& JFactory::getEditor();
		?>
 						<script language="javascript" type="text/javascript">
	<!--
        
		function isBlank(val) {
			if (val == null || val == "") return true;
			for(var i=0;i<val.length;i++) {
				if ((val.charAt(i)!=' ')&&(val.charAt(i)!="\t")&&(val.charAt(i)!="\n")&&(val.charAt(i)!="\r")){return false;}
				}
			return true;
				
		}

		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'tips') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";

			
				if (isBlank(form.title.value)) {
					msg += "<?php echo 'the title'; ?>\n";
				}

			/* unable to check description
				if (isBlank(form.description.value)) {
					msg += "<?php echo 'the description'; ?>\n";
				}
				*/
				if (form.contentType.selectedIndex == 0) {
					msg += "<?php echo 'the content type'; ?>\n";
				}
				// Can add more checks such as:
				//	if iframeWeb or iframePDF are checked, make sure contentType != Tip
				//  if published, check that contentType and contentID are consistent
				//	etc...
				
				if (msg != "Please specify ") {
					alert(msg);
					return false;	
				}
				else				
					submitform(pressbutton);
					return;
					
		}
		//-->
		</script>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminForm">
        
        <legend>Details</legend>
        
        <table class="admintable">
        <tr>
        <td width="100" align="right" class="key">
        	ID :
        </td>
        
        <td>
        	<?php if ($row->id > 0) echo $row->id; ?>
 		</td>
               
        </tr>


        <tr>
        <td width="100" align="right" class="key">
        	Title * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="title" id="title" size="50" maxlength="128" value="<?php echo $row->title; ?>" >
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Description * :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'description', $row->description, '100%', '250', '40', '10');
			?>
 		</td>
               
        </tr>
        <tr>
        <td width="100" align="right" class="key">
        	Content Type:
        </td>
        
        <td>
        	<?php
			echo $lists['type'];
			?>
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	content ID (Remember to specify an ID if you are publishing this tip, BUT ONLY for Content Types = Glossary, Help, Resource) :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="contentID" id="contentID" size="50" maxlength="255" value="<?php echo $row->contentID; ?>" >
 		</td>
		</tr>
		
        <tr>
        <td width="100" align="right" class="key">
        	iFrame PDF (only applicable to tips with content IDs) :
        </td>
        
        <td>
        	<?php
			echo $lists['iframePDF'];
			?>
 		</td>
               
        </tr>
        <tr>
        <td width="100" align="right" class="key">
        	iFrame Web (only applicable to tips with content IDs):
        </td>
        
        <td>
        	<?php
			echo $lists['iframeWeb'];
			?>
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Order :
        </td>
        
        <td>
		        <input type="hidden" name="ordering"  value="<?php echo $row->ordering; ?>" />

        	<?php if ($row->id > 0) echo $row->ordering; 
				else echo 'New tips default to the last place. Ordering can be changed in the tip listing after this tip is saved';
			?>
 		</td>
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Published:
        </td>
        
        <td>
        	<?php
			echo $lists['published'];
			?>
 		</td>
               
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Last Modified:
        </td>
        
        <td>
        	<?php
			echo $row->modified;
			?>
 		</td>
               
        </tr>
		

       

        </table>
       	</fieldset>
        <input type="hidden" name="id"  value="<?php echo $row->id; ?>" />
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
     
        </form>
        <?php 

	}



}

?>