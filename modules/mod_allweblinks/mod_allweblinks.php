<?php
/**
* @package MOD_ALLWEBLINKS
* @copyright Copyright (C) 2007 - 2008 SJL Creations. All rights reserved.
* @license GNU/GPL, see LICENSE.php
* Author: C.Schneider /2.0.7
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// Get the weblinks
$list	= modAllWebLinksHelper::getList($params);
$count	= count($list);

require(JModuleHelper::getLayoutPath('mod_allweblinks'));
?>
