
CREATE TABLE IF NOT EXISTS `#__url` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `instructions` text NOT NULL,
  `author` varchar(128) NULL,
  `sectionID` int(11) NOT NULL,
  `stepID` int(11) NOT NULL,
  `ordering` int(4) NOT NULL,
  `pdf` tinyint(1) NOT NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__step` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__section` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stepID` int(11) NOT NULL,
  `ordering` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__tip` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contentID` int(11) NOT NULL,
  `contentType` varchar(50) NOT NULL,
  `iframePDF` tinyint(1) NOT NULL,
  `iframeWeb` tinyint(1) NOT NULL,
  `modified` datetime NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`));

