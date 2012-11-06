CREATE TABLE IF NOT EXISTS `jos_pmc_contact` (
  `id` int(11) NOT NULL auto_increment,
  `catID` int(11) NOT NULL,
  `organization` varchar(128) NOT NULL,
  `specialty` varchar(128) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `building` varchar(128) NOT NULL,
  `address1` varchar(128) NOT NULL,
  `address2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `url` varchar(255) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `email` varchar(128) NOT NULL,
  `description` varchar(500) NOT NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ;

CREATE TABLE IF NOT EXISTS `jos_pmc_contact_cat` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ;
