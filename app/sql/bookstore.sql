# Instead of 'active_listings' and 'removed_listings' AND 'sold_listings' together, adding complications to searching,
# it makes better sense to have a single 'book_listings' table with a 'removed' / 'sold' flag (maybe sold, maybe lost, etc)
# there may be a case where its refunded and worth keeping mentioned in system ,etc...

#DROP TABLE IF EXISTS book_listings;
#CREATE TABLE IF NOT EXISTS book_listings
#(
#	listing_id	INT(10) PRIMARY KEY,
#	user_id		INT(10),
#	book_id		INT(10),
#	price		FLOAT,
#	condition_id	INT(11),
#	comments	TEXT,
#	hold		INT(1) DEFAULT 0,
#	paused		INT(1) DEFAULT 0,
#
#	removed		INT(1) DEFAULT 0, # 
#	# Once a record is added, it defaults to NOT removed, meaning its an active book....
#
#	# Once sold, will flip this flag.
#	sold		INT(1) DEFAULT 0,
#	sale_id		INT(10),
#
#	INDEX		(sold), # So we can query quickly which were sold
#	INDEX		(removed), # So we can quickly query which were removed
#	INDEX		(sale_id),
#
#	INDEX		(user_id),
#	INDEX		(book_id)
#);


DROP TABLE IF EXISTS active_listings;
CREATE TABLE IF NOT EXISTS active_listings
(
	listing_id	INT(10) PRIMARY KEY AUTO_INCREMENT,
	user_id		INT(10),
	book_id		INT(10),
	school_id	INT(10),
	price		FLOAT,
	condition_id	ENUM('Like New', 'Very Good', 'Good', 'Acceptable', 'International'),
	postdate	DATETIME,
	comments	TEXT,
	hold		INT(1) NOT NULL DEFAULT '0',
	paused		INT(1) NOT NULL DEFAULT '0',

	INDEX		(user_id),
	INDEX		(book_id)
);

# Given isbn, automatically retrieved from isbndb.org
# tho how get image?
DROP TABLE IF EXISTS books;
CREATE TABLE IF NOT EXISTS books
(
	book_id		INT(10) PRIMARY KEY AUTO_INCREMENT,
	isbn10		VARCHAR(10) UNIQUE,
	isbn13		VARCHAR(14) UNIQUE,
	title		VARCHAR(100),
	author		VARCHAR(75),
	format		VARCHAR(15), # ?
	edition		SMALLINT(6),
	pubdate		TIMESTAMP,
	publisher	VARCHAR(50),
	pages		INT(11),
	imageFullURL	VARCHAR(128),
	imageThumbURL	VARCHAR(128),
	amazonRetailPrice	FLOAT,
	amazonListPrice		FLOAT,
	description	TEXT
);

# Where status of book has changed (along sale process)
# We want to know when each event happened, what day, etc.... (for tracking), needing separate (this) table...
DROP TABLE IF EXISTS listing_events;
CREATE TABLE IF NOT EXISTS listing_events
(
	listing_event_id	INT(10) PRIMARY KEY AUTO_INCREMENT,
	active_listing_id	INT(10),
	sold_listing_id		INT(10),
	type			ENUM('sold','dropped','accepted','paid','canceled','refund','returned'),
	time			TIMESTAMP,

	INDEX			(active_listing_id),
	INDEX			(sold_listing_id)
);

# Once a person sells the book, it gets moved here... 
# ????
# ??? REUSE listing_id from active_listings table version, so can cross-reference events
# **** THIS ADDS SERIOUS COMPLICATIONS TO CODE, makes better sense to have FLAG
# 'active = 1', so we can not need to always bother with checking TWO tables....
#
DROP TABLE IF EXISTS removed_listings;
CREATE TABLE IF NOT EXISTS removed_listings
(
	listing_id		INT(10) PRIMARY KEY AUTO_INCREMENT,
	active_listing_id 	INT(10) UNIQUE,
	user_id			INT(10),
	book_id			INT(10),
	school_id		INT(10),
	price			FLOAT,
	condition_id		ENUM('Like New', 'Very Good', 'Good', 'Acceptable', 'International'),
	postdate		DATETIME,
	comments		TEXT,

	INDEX			(user_id),
	INDEX			(book_id)
);

DROP TABLE IF EXISTS orders;
CREATE TABLE IF NOT EXISTS orders
(
	order_id	INT(10) PRIMARY KEY AUTO_INCREMENT,
	buyer_id	INT(10),
	time		TIMESTAMP
);

# Transactions
# DONT we want to reference the LISTING ID???? (so know what book WAS)
DROP TABLE IF EXISTS sales; # A single record per item bought...
CREATE TABLE IF NOT EXISTS sales
(
	sale_id		INT(10) PRIMARY KEY AUTO_INCREMENT,
	buyer_id	INT(10),
	seller_id	INT(10), 
	order_id	INT(10), # Group all stuff at same 'checkout' into a single order_id
	transaction_id	INT(10), # For cross-referencing payments, etc...
	sale_total	FLOAT, # price.
	time		TIMESTAMP,

	# ids added so we can reference other records, including book itself
	#listing_id	INT(10) UNIQUE, # ADDED, so we can reference the transaction and events....
		# Not needed since sold_listings CONTAINS sale_id
	#book_id		INT(10), # ADDED so we can reference which book the sale was for...  (without looking up listing_id)

	INDEX		(order_id),
	INDEX		(buyer_id)
);

DROP TABLE IF EXISTS schools;
CREATE TABLE IF NOT EXISTS schools
(
	school_id	INT(10) PRIMARY KEY AUTO_INCREMENT,
	name		VARCHAR(64) UNIQUE,
	domain		VARCHAR(32)
);

INSERT INTO schools (school_id, name, domain) VALUES (1,'Drexel University','drexel.edu');
INSERT INTO schools (school_id, name, domain) VALUES (2,'Temple University','temple.edu');
INSERT INTO schools (school_id, name, domain) VALUES (3,'University of Pennsylvania','upenn.edu');
INSERT INTO schools (school_id, name, domain) VALUES (4,'U of MalySoft (Test)','laptop.malysoft.com');
INSERT INTO schools (school_id, name, domain) VALUES (5,'Univ. of BTTB (Test)','betterthanthebookstore.com');
INSERT INTO schools (school_id, name, domain) VALUES (6,'Univ. of Tactile Design (Test)','tactiledesign.com');
INSERT INTO schools (school_id, name, domain) VALUES (7,'Univ. of Comcast (Test)','comcast.net');

DROP TABLE IF EXISTS sold_listings;
CREATE TABLE IF NOT EXISTS sold_listings
(
	listing_id	INT(10) PRIMARY KEY AUTO_INCREMENT,
	active_listing_id INT(10),
	user_id		INT(10),
	book_id		INT(10),
	school_id	INT(10),
	price		FLOAT,
	condition_id	ENUM('Like New', 'Very Good', 'Good', 'Acceptable', 'International'),
	postdate	DATETIME,
	comments	TEXT,
	sale_id		INT(10) UNIQUE,

	INDEX		(active_listing_id),
	INDEX		(user_id),
	INDEX		(book_id),
	INDEX		(sale_id)
);

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users
(
	user_id		INT(10) PRIMARY KEY AUTO_INCREMENT,
	school_id	INT(10),
	email		VARCHAR(64) UNIQUE, # AT SCHOOL!
	payment_email	VARCHAR(64), # FOR PAYMENT, ie paypal.
	password	VARCHAR(128), # Since encoded.
	old_password	VARCHAR(25),
	first		VARCHAR(20),
	last		VARCHAR(20),
	phone		VARCHAR(10),
	student_id	VARCHAR(10),
	regdate		TIMESTAMP,
	verified	INT(1) NOT NULL DEFAULT '0',
	activation_code VARCHAR(32), # Code that must be matched in email links to re-enable accounts....
	is_admin	BOOL DEFAULT FALSE, # If have access to /admin

	INDEX		(school_id),
	INDEX		(email)
);

DROP TABLE IF EXISTS cart_items;
CREATE TABLE IF NOT EXISTS cart_items
(
	item_id		INT(10) PRIMARY KEY AUTO_INCREMENT,
	user_id		INT(10),
	session_id	VARCHAR(64), # If still anonymous....
	listing_id	INT(10) NOT NULL,
	book_id		INT(10) NOT NULL,
	quantity	INT(10) NOT NULL DEFAULT '1',
	price		FLOAT,
	created_date	TIMESTAMP,

	INDEX		(session_id),
	INDEX		(user_id)
);
