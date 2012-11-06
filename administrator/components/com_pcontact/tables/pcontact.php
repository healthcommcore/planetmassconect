<?php

defined ( '_JEXEC') or die ('Restricted access');

class TablePContact extends JTable

{
	var $id = null;
	var $catID = null;
	var $organization = null;
	var $specialty = null;
	var $institution = null;
	var $building = null;
	var $address1 = null;
	var $address2 = null;
	var $city = null;
	var $state = null;
	var $zip = null;
	var $url = null;
	var $telephone = null;
	var $fax = null;
	var $modified = null;
	var $email = null;
	var $description = null;
	var $published = true;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__pmc_contact', 'id', $db);
	}
}
?>