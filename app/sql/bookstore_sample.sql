# Do active ones...
INSERT INTO active_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments,hold,paused) VALUES (1,1,1,1,78.00,2,'slight watermark',0,0);
INSERT INTO active_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments,hold,paused) VALUES (2,2,1,1,65.00,3,'severe highlighting',0,0);
INSERT INTO active_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments,hold,paused) VALUES (3,2,2,2,93.00,2,'minimal binding wear',0,0);
INSERT INTO active_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments,hold,paused) VALUES (4,1,3,3,71.00,1,'mint condition',0,0);

# Now do sold ones....
INSERT INTO sold_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (10,1,4,3,103.00,1,'mint condition');
INSERT INTO sold_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (11,1,5,2,79.00,1,'mint condition');
INSERT INTO sold_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (12,1,6,3,122.00,1,'mint condition');

# Now do REMOVED ones.... (ie if lost, etc)
INSERT INTO removed_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (13,1,2,6,127.00,1,'mint condition');
INSERT INTO removed_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (14,1,2,5,129.00,1,'awesome condition');
INSERT INTO removed_listings (listing_id,user_id,book_id,school_id,price,condition_id,comments) VALUES (15,1,1,6,111.00,1,'poor condition');


INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (1,'1234567890','12345678901234','Chemistry 101','Joe Smith, PhD.','hardcover',6, '2007-11-17', 'SimonSchuster',892,'12345678901234.jpg','Intro to Chemistry basics');
INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (2,'2345678901','23456789012345','Chemistry 102','Karen Michaels, PhD. et al','hardcover',3, '2006-05-22', 'McGraw Hill',984,'23456789012345.jpg','Continuation of Chemistry basics');
INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (3,'3456789012','3456789012345','Macroeconomics','Albert Schumaker','softcover',4, '2008-02-29', 'Addison-Wesley',455,'3456789012345.jpg','Macro view of economics, basics');
INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (4,'4567890123','4567890123456','Introduction to Web Design','Kevin Torrenson','hardcover',3, '2008-01-13', 'Sybex',454,'4567890123456.jpg','Fundamentals of web design and development');
INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (5,'5678901234','5678901234567','Classic Art History','Jim Wilder et al','hardcover',1, '2008-04-02', 'Carlson',339,'5678901234567.jpg','Art history from 1670 - 1830');
INSERT INTO books (book_id,isbn10,isbn13,title,author,format,edition,pubdate,publisher,pages,image,description) VALUES (6,'6789012345','6789012345678','Investment Fundamentals','Steve Bender','softcover',3, '2007-11-17', 'SimonSchuster',892,'6789012345678.jpg','Overview of Stocks, Bonds, Annuities, etc.');

INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (1,1,'sold','2008-06-23');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (2,1,'dropped','2008-06-24');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (3,1,'paid','2008-06-25');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (4,1,'accepted','2008-06-25');

INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (5,2,'sold','2008-06-23');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (6,2,'dropped','2008-06-23');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (7,2,'paid','2008-06-23');

INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (8,3,'sold','2008-06-23');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (9,3,'dropped','2008-06-23');
INSERT INTO listing_events (listing_event_id,listing_id,type,time) VALUES (10,4,'sold','2008-06-23');


# Added listing_id, book_id for cross-referencing (so know what book sold, event record, etc)
INSERT INTO sales (sale_id,user_id,total,time,listing_id,book_id) VALUES (1,1,103.00,'2008-06-23',10,4);
INSERT INTO sales (sale_id,user_id,total,time,listing_id,book_id) VALUES (2,1,79.00,'2008-06-25',11,5);
INSERT INTO sales (sale_id,user_id,total,time,listing_id,book_id) VALUES (3,1,122.00,'2008-07-02',12,6);


INSERT INTO schools (school_id,name,domain) VALUES(1,'UPenn','uppen.edu');
INSERT INTO schools (school_id,name,domain) VALUES(2,'Wharton','wharton.edu');
INSERT INTO schools (school_id,name,domain) VALUES(3,'Drexel','drexel.edu');


INSERT INTO users (user_id,school_id,school_email,email,password,first,last,phone,student_id,regdate,verified) VALUES (1,1,'joe@students.upenn.edu','joeschmoe@hotmail.com','joeschmoe1','Joe','Schmoe','2154451234','0987654321','2008-01-01',1);
INSERT INTO users (user_id,school_id,school_email,email,password,first,last,phone,student_id,regdate,verified) VALUES (2,1,'mark@students.upenn.edu','markmiller@yahoo.com','markmiller1','Mark','Miller','2152223333','1987654321','2008-04-12',1);
INSERT INTO users (user_id,school_id,school_email,email,password,first,last,phone,student_id,regdate,verified) VALUES (3,3,'mike@students.drexel.edu','mikelaudo@gmail.com','mikelaudo1','Mike','Laudo','2151112222','2987654321','2008-05-22',1);
