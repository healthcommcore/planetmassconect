<?php
JHTML::_('behavior.tooltip');

defined ( '_JEXEC') or die ('Restricted access');
class HTML_PContact

{
	function editContact( $row, $lists, $option)
	
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

		// Only organization name and category are required
		function submitbutton(pressbutton) {
			
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";
			
				if (isBlank(form.organization.value)) {
					msg += "<?php echo 'the organization'; ?>\n";
				}
				
				if (form.catID.selectedIndex == 0) {
					msg += "<?php echo 'the category'; ?>\n";
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
        <td width="100%" align="right" class="key">
        	ID :
        </td>
        <td width="400">
        	<?php if ($row->id > 0) echo $row->id; ?>
 		</td>
        </tr>
		
        <tr>
        <td width="100" align="right" class="key">
        	Category * :
        </td>
        <td>
        	<?php
			echo $lists['catID'];
			?>
 		</td>
        </tr>
		
        <tr>
        <td width="100" align="right" class="key">
        	Organization * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="organization" id="organization" size="50" maxlength="128" value="<?php echo $row->organization; ?>" >
 		</td>
        </tr>
 
        <tr>
        <td width="100" align="right" class="key">
        	Specialty :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="specialty" id="specialty" size="50" maxlength="128" value="<?php echo $row->specialty; ?>" >
 		</td>
		</tr>
        <tr>
        <td width="100" align="right" class="key">
        	Institution :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="institution" id="institution" size="50" maxlength="128" value="<?php echo $row->institution; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Building :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="building" id="building" size="50" maxlength="128" value="<?php echo $row->building; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Address 1 :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="address1" id="address1" size="50" maxlength="128" value="<?php echo $row->address1; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Address 2 :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="address2" id="address2" size="50" maxlength="128" value="<?php echo $row->address2; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	City :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="city" id="city" size="50" maxlength="128" value="<?php echo $row->city; ?>" >
 		</td>
		</tr>


        <tr>
        <td width="100" align="right" class="key">
        	State :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="state" id="state" size="2" maxlength="2" value="<?php echo $row->state; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Zip :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="zip" id="zip" size="10" maxlength="10" value="<?php echo $row->zip; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Web site URL (include http:// or https://)  :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="url" id="url" size="50" maxlength="255" value="<?php echo $row->url; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Telephone (xxx) xxx-xxxx :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="telephone" id="telephone" size="25" maxlength="25" value="<?php echo $row->telephone; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	Fax :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="fax" id="fax" size="25" maxlength="25" value="<?php echo $row->fax; ?>" >
 		</td>
		</tr>

        <tr>
        <td width="100" align="right" class="key">
        	email :
        </td>
        <td>
        	<input class="text_area" type="text"
 name="email" id="email" size="50" maxlength="128" value="<?php echo $row->email; ?>" >
 		</td>
		</tr>
        <tr>
        <td width="100" class="key">
        description :
        </td>
        <td>
        	<textarea  rows="7" cols="46" name="description" id="description" value="<?php echo $row->description; ?>"><?php echo $row->description; ?>
        </textarea>
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
        <!--input type="hidden" name="author"  value="<?php echo $row->author; ?>" /-->
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        
        
        <?php
	
	}
	// List of Contacts - default view
	function showContacts( $rows, $option, $pageNav)
	{
		$ordering = ($this->lists['order'] == 'a.ordering');
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
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
					echo $this->lists['categories'];
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
 			<?php echo JHTML::_('grid.sort',  'Organization', 'organization', ($this->lists['order'] == 'organization' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort',  'Published', 'published', ($this->lists['order'] == 'published' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="15%">Category
			</th>
            <th width="8%">
 			<?php echo JHTML::_('grid.sort',  'Institution', 'institution', ($this->lists['order'] == 'institution' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="8%">
 			<?php echo JHTML::_('grid.sort',  'City', 'city', ($this->lists['order'] == 'city' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="8%">
 			<?php echo JHTML::_('grid.sort',  'Modified', 'modified', ($this->lists['order'] == 'modified' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
           <th width="5%" nowrap="nowrap">ID</th>
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
        	<?php echo $row->organization; ?></a>
        </td>

        <!--td>
        	<a href="<?php echo $link; ?>">
         	<?php echo substr( strip_tags($row->definition), 0, 100); ?> ...</a>

 
        </td-->
        <td align="center">
        	<?php echo $published; ?>
        </td>
        <td>
        	<?php echo $row->name; ?>
        </td>
        <td>
        	<?php echo $row->institution; ?>
        </td>
		<td>

        	<?php echo $row->city; ?>
        </td>
		<td>

        	<?php echo $row->modified; ?>
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
		<td colspan="8"><?php echo $pageNav->getListFooter(); ?></td>
		</tfoot>
        
        </table>
        
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        <input type="hidden" name="boxchecked"  value="0" />
		<!-- for sort -->
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		<input type="hidden" name="search_value" value="<?php echo $this->lists['search']; ?>" />
 		</form>
        <?php 
		
	}

	/* Categories */
	// List of Categories - default view
	function showCategories( $rows, $option, $pageNav)
	{
		$ordering = ($this->lists['order'] == 'a.ordering');
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
            <th class="title">Name</th>
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
		$link = JFilterOutput::ampReplace( 'index.php?option=' . $option . '&task=editCategory&cid[]=' . $row->id . '&limitstart=' . $pageNav->limitstart);
		?>
        <tr class="<?php echo "row$k"; ?> ">
        <td>
        	<?php echo $checked; ?>
        </td>
          <td>
        	<a href="<?php echo $link; ?>">
        	<?php echo substr( strip_tags($row->name), 0, 50); ?></a>
        </td>

        <!--td>
        	<?php echo empty($row->description) ? '': substr( strip_tags($row->description), 0, 50) .'...'; ?>
        </td-->
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
        <input type="hidden" name="task"  value="categories" />
        <input type="hidden" name="boxchecked"  value="0" />
		
 		</form>
        <?php 
		
	}

	function editCategory ( $row, $option, $lists)
	
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