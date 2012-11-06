CREATE TABLE IF NOT EXISTS `#__glossary` (
  `id` int(11) NOT NULL auto_increment,
  `term` varchar(255) NOT NULL,
  `definition` text NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(128) NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
);

