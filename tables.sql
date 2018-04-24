
DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
	id smallint unsigned NOT NULL auto_increment,
	publicationDate date NOT NULL,	
	title varchar(255) NOT NULL,	
	summary text NOT NULL,	
	content mediumtext NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS pages;
CREATE TABLE pages
(
	id smallint unsigned NOT NULL auto_increment,
	publicationDate date NOT NULL,
	slug varchar(255) NOT NULL,
	template varchar(255) NOT NULL,
	title varchar(255) NOT NULL,
	summary text NOT NULL,
	content mediumtext NOT NULL,
	image_ids blob NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS images;
CREATE TABLE images
(
	id smallint unsigned NOT NULL auto_increment,
	image_path blob NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS entries;
CREATE TABLE entries
(
	id smallint unsigned NOT NULL auto_increment,
	entryDate date NOT NULL,
	name varchar(255) NOT NULL,
	email varchar(320) NOT NULL,
	subject varchar(255) NOT NULL,
	message mediumtext NOT NULL,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	password varchar(100) NOT NULL
);