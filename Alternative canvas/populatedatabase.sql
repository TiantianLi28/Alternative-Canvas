USE systemDB; 
LOAD DATA LOCAL INFILE 'class.csv' INTO TABLE class
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'student.csv' INTO TABLE student
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'question.csv' INTO TABLE question
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'tags.csv' INTO TABLE tags
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'thread.csv' INTO TABLE thread
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'assignment.csv' INTO TABLE assignment
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'teaches.csv' INTO TABLE teaches
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'assists.csv' INTO TABLE assists
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'takes.csv' INTO TABLE takes
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'does.csv' INTO TABLE does
FIELDS TERMINATED BY ',';
LOAD DATA LOCAL INFILE 'course_title.csv' INTO TABLE course_title
FIELDS TERMINATED BY ',';
