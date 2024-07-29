# Table structure for table 'tx_typo3features_domain_model_feature'
CREATE TABLE tx_typo3features_domain_model_feature (
	uid int(11) unsigned NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,

    `key` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `description` text NULL,
	`active` tinyint(4) unsigned DEFAULT '0' NOT NULL,
    `class_string` varchar(255) NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
    fe_group int(11) DEFAULT 0 NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY identifier (`key`)
);
