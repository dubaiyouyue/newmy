DROP TABLE IF EXISTS tbs_categories;
CREATE TABLE tbs_categories (
	id smallint(6) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	catename char(50) NOT NULL ,
	cateurl varchar(120) NOT NULL ,
	cateorder int(3) NOT NULL
) ENGINE = MYISAM;

DROP TABLE IF EXISTS tbs_articles;
CREATE TABLE tbs_articles (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	istop tinyint(1) NOT NULL default '0' ,
	cateid smallint(6) unsigned NOT NULL default '0' ,
	catename char(50) NOT NULL ,
	cateurl varchar(120) NOT NULL ,
	username char(20) NOT NULL ,
	title varchar(120) NOT NULL ,
	htmlurl varchar(120) NOT NULL ,
	abstract text NOT NULL ,
	content mediumtext NOT NULL ,
	tags char(50) NOT NULL ,
	commentnum int NOT NULL default '0' ,
	tbnum int NOT NULL default '0' ,
	viewnum int NOT NULL default '0' ,
	updatetime int(10) unsigned NOT NULL default '0'
) ENGINE = MYISAM;

DROP TABLE IF EXISTS tbs_comments;
CREATE TABLE tbs_comments (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	artid mediumint(8) NOT NULL default '0' ,
	username char(20) NOT NULL ,
	homepage char(50) NOT NULL ,
	content text NOT NULL ,
	status char(10) NOT NULL default 'approved' ,
	ipaddress char(20) NOT NULL ,
	commenttime int(10) unsigned NOT NULL default '0'
) ENGINE = MYISAM;

DROP TABLE IF EXISTS tbs_users;
CREATE TABLE tbs_users (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	username char(20) NOT NULL ,
	password char(50) NOT NULL ,
	email char(50) NOT NULL ,
	homepage char(50) NOT NULL ,
	flag tinyint(1) NOT NULL default '0'
) ENGINE = MYISAM ;

DROP TABLE IF EXISTS tbs_trackbacks;
CREATE TABLE tbs_trackbacks (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	url varchar(120) NOT NULL ,
	title varchar(120) NOT NULL ,
	blogname varchar( 120 ) NOT NULL ,
	excerpt text NOT NULL ,
	artid mediumint(8) NOT NULL default '0' ,
	ipaddress char(20) NOT NULL ,
	updatetime int(10) unsigned NOT NULL default '0'
) ENGINE = MYISAM ;

DROP TABLE IF EXISTS tbs_tags;
CREATE TABLE tbs_tags (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	tag VARCHAR( 20 ) NOT NULL ,
	artid INT NOT NULL
) ENGINE = MYISAM ;

DROP TABLE IF EXISTS tbs_attach;
CREATE TABLE tbs_attach (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	artid mediumint(8) NOT NULL default '0' ,
	truefilename varchar(120) NOT NULL ,
	filename varchar(120) NOT NULL ,
	path varchar(120) NOT NULL ,
	filesize varchar(20) NOT NULL ,
	filetype varchar(20) NOT NULL ,
	uploadtime int(10) unsigned NOT NULL default '0'
) ENGINE = MYISAM ;

DROP TABLE IF EXISTS tbs_links;
CREATE TABLE tbs_links (
	id mediumint(8) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	url varchar(120) NOT NULL ,
	webname varchar(120) NOT NULL ,
	linkorder int(3) NOT NULL ,
	updatetime int(10) unsigned NOT NULL default '0'
) ENGINE = MYISAM ;

DROP TABLE IF EXISTS tbs_settings;
CREATE TABLE tbs_settings (
	title varchar(50) NOT NULL default '',
  	value text NOT NULL,
  	PRIMARY KEY  (title)
) ENGINE = MYISAM ;
