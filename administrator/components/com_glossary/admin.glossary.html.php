<?php
JHTML::_('behavior.tooltip');

defined ( '_JEXEC') or die ('Restricted access');
class HTML_Glossary

{
	function editGlossary( $row, $lists, $option)
	
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
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// Else: apply or cancel
				var msg = "Please specify ";
			
				if (isBlank(form.term.value)) {
					msg += "<?php echo 'the term'; ?>\n";
				}
				
				// document.getElementById("thetext2");
				/*
				editelement = document.getElementById('definition_editFrame');
alert('def =' + editelement.value );

				if (isBlank(editelement.value)) {
					msg += "<?php echo 'the definition'; ?>\n";
				}
				*/
				
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
        	Term * :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="term" id="term" size="50" maxlength="128" value="<?php echo $row->term; ?>" >
 		</td>
        </tr>
 
        <tr>
        <td width="100" align="right" class="key">
        	Definition * :
        </td>
        
        <td>
        	<?php
			echo $editor->display( 'definition', $row->definition, '100%', '250', '100', '30');
			?>
 		</td>
        </tr>

        <tr>
        <td width="100" align="right" class="key">
        	Source :
        </td>
        
        <td>
        	<input class="text_area" type="text"
 name="source" id="source" size="50" maxlength="255" value="<?php echo $row->source; ?>" >
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
        <!--input type="hidden" name="author"  value="<?php echo $row->author; ?>" /-->
        <input type="hidden" name="option"  value="<?php echo $option; ?>" />
        <input type="hidden" name="task"  value="" />
        
        </form>
        
        
        <?php
	
	}
	// List of Glossaries - default view
	function showGlossaries( $rows, $option, $pageNav)
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
 			<?php echo JHTML::_('grid.sort',  'Term', 'term', ($this->lists['order'] == 'term' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="35%">Definition</th>
            <th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort',  'Published', 'published', ($this->lists['order'] == 'published' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="8%">
 			<?php echo JHTML::_('grid.sort',  'Source', 'source', ($this->lists['order'] == 'source' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
			</th>
            <th width="8%">
 			<?php echo JHTML::_('grid.sort',  'Author', 'author', ($this->lists['order'] == 'author' ) ? $this->lists['order_Dir']: 'desc', $this->lists['order'] ); ?>
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
        	<?php echo $row->term; ?></a>
        </td>

        <td>
        	<a href="<?php echo $link; ?>">
         	<?php echo substr( strip_tags($row->definition), 0, 100); ?> ...</a>

 
        </td>
        <td align="center">
        	<?php echo $published; ?>
        </td>
        <td>
        	<?php echo $row->source; ?>
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



}

?>