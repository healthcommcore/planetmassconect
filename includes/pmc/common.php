<?php
// FUNCTION: DB CONNECTIONS
// Note that error handling automatically performmed and intercepted by Joomla,
//	so no point trying to retrieve or display any error messages.
function dbJConnect( $dbname) {
	// echo $dbname;
	$conf =& JFactory::getConfig();
	
	$host 		= $conf->getValue('config.host');
	$user 		= $conf->getValue('config.user');
	$password 	= $conf->getValue('config.password');
	$database	= $dbname; 
	$prefix 	= '';// $conf->getValue('config.dbprefix');
	$driver 	= $conf->getValue('config.dbtype');
	
	$options	= array ( 'driver' => $driver, 'host' => $host, 'user' => $user, 'password' => $password, 'database' => $database, 'prefix' => $prefix );

	$db =& JDatabase::getInstance( $options );
	
    return $db;

}

function pageHit($page, $community, $organization, $sessionid, $ip_address) {
global $mainframe;
	$conf =& JFactory::getConfig();
	$dbname= $conf->getValue('config.db');
	$url = $_SERVER['REQUEST_URI'];
	
	$userDB = dbJConnect('pmc_site');
	if (!$userDB) {
		// Log error
		// error_log( "\n". date("Y-m-d H:i:s ") .  'Error: web site unable to connect to Joomla Database using JDatabase', 3, '/var/www/logs/hd2/hd2.log');
		// die( 'The site is temporarily offline (Unable to retrieve the application data)');
	}
	else {
		// echo 'connected to db';
		$time = time();
		$sql = "INSERT INTO jos_pmc_hits (hitTime, page, url, community, organization, sessionid, ip_address ) VALUES ( $time,  '$page', '$url', '$community', '$organization','$sessionid', '$ip_address')";
		// echo $sql;
		$userDB->setQuery( $sql);	
		$result =$userDB->query();
			
		if (!$result) {
				// echo 'db error';
				// error_log( "\n". date("Y-m-d H:i:s ") .  'Error: web site unable to connect to Joomla Database using JDatabase', 3, '/var/www/logs/hd2/hd2.log');
				// echo $userDB->getErrorMsg();
				return NULL;
		}
	}
	
}
?>