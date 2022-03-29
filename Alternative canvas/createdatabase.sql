/* Create the systemDB schema */
CREATE DATABASE systemDB;
               
/* Specify the database to use */               
USE systemDB; 

/* Create the department table -- the foreign key
   constraint was dropped to prevent circular integrity
   constraints */                              
CREATE TABLE class 
(
  course_number CHAR(5) NOT NULL,
  semester VARCHAR(8) NOT NULL,
  year INT,
  CONSTRAINT classPK PRIMARY KEY (course_number, semester, year)
);   

CREATE INDEX class_semester USING BTREE ON class(semester);
CREATE INDEX class_year USING BTREE ON class(year);

/* Create the department location */                                                    
CREATE TABLE student  
(
  login_id VARCHAR(20),
  fname VARCHAR(20),
  lname VARCHAR(20),
  sid char(10),
  CONSTRAINT studentPK PRIMARY KEY (sid),
  CONSTRAINT studentSK UNIQUE (login_id)
);         

/* Create the employee table */                                         
CREATE TABLE teaches   
(
  course_number CHAR(5) NOT NULL,
  semester VARCHAR(8) NOT NULL,      
  sid CHAR(10) NOT NULL,
  year INT,
  CONSTRAINT teachesPK PRIMARY KEY (course_number,semester, year, sid),
  CONSTRAINT teaches_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT teaches_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT teaches_semesterFK FOREIGN KEY (semester) REFERENCES class(semester),
  CONSTRAINT teaches_sidFK FOREIGN KEY (sid) REFERENCES student(sid)

);         

/* Create the project table */                                                               
CREATE TABLE assists
(
  course_number CHAR(5) NOT NULL,
  semester VARCHAR(8),    
  year INT,
  sid CHAR(10) NOT NULL,
  CONSTRAINT assistsPK PRIMARY KEY (course_number,semester,year, sid),
  CONSTRAINT assists_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT assists_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT assists_semesterFK FOREIGN KEY (semester) REFERENCES class(semester),
  CONSTRAINT assists_sidFK FOREIGN KEY (sid) REFERENCES student(sid)
);

/* Create the workson table */                                                                     
CREATE TABLE takes   
(
  sid CHAR(10),
  course_number CHAR(5),
  semester VARCHAR(8),
  grade VARCHAR(12),
  year INT,
  CONSTRAINT takesPK PRIMARY KEY (course_number,semester,year, sid),
  CONSTRAINT takes_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT takes_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT takes_semesterFK FOREIGN KEY (semester) REFERENCES class(semester),
  CONSTRAINT takes_sidFK FOREIGN KEY (sid) REFERENCES student(sid)
);                              
/* Create the dependent table */                                                                                
CREATE TABLE question  
(
  
  course_number CHAR(5),
  semester VARCHAR(8),
  year INT,
  title VARCHAR(50),
  time_posted TIMESTAMP, 
  content VARCHAR(300),     
  sid CHAR(10),   
  qid INT,
  CONSTRAINT questionPK PRIMARY KEY (qid),
  CONSTRAINT question_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT question_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT question_semesterFK FOREIGN KEY (semester) REFERENCES class(semester),
  CONSTRAINT question_sidFK FOREIGN KEY (sid) REFERENCES student(sid)
);

CREATE TABLE tags
(
  course_number CHAR(5),
  semester VARCHAR(8),
  year INT,
  tag VARCHAR(20),
  qid INT,
  CONSTRAINT tagsPK PRIMARY KEY (qid, tag),
  CONSTRAINT tags_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT tags_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT tags_semesterFK FOREIGN KEY (semester) REFERENCES class(semester),
  CONSTRAINT tags_qidFK FOREIGN KEY (qid) REFERENCES question(qid)
);

/* Create the dependent table */                                                                                
CREATE TABLE thread
(
  qid INT,
  time_posted TIMESTAMP, 
  content VARCHAR(300),    
  sid CHAR(10),
  CONSTRAINT threadPK PRIMARY KEY (qid,sid,time_posted),
  CONSTRAINT thread_qidFK FOREIGN KEY (qid) REFERENCES question(qid),
  CONSTRAINT thread_sidFK FOREIGN KEY (sid) REFERENCES student(sid)
);

/* Create the dependent table */                                                                                
CREATE TABLE assignment
( 
  course_number CHAR(5),
  semester VARCHAR(8),
  year INT,
  name VARCHAR(30),
  due_date TIMESTAMP, 
  content VARCHAR(255),     
  point INT, 
  aid INT,
  CONSTRAINT assignmentPK PRIMARY KEY (aid),
  CONSTRAINT assignment_yearFK FOREIGN KEY (year) REFERENCES class(year),
  CONSTRAINT assignment_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number),
  CONSTRAINT assignment_semesterFK FOREIGN KEY (semester) REFERENCES class(semester)
);

CREATE TABLE does
(
  sid CHAR(10), 
  grade INT,
  aid INT,
  CONSTRAINT doesPK PRIMARY KEY (aid,sid),
  CONSTRAINT does_qidFK FOREIGN KEY (aid) REFERENCES assignment(aid),
  CONSTRAINT does_sidFK FOREIGN KEY (sid) REFERENCES student(sid)
);

CREATE TABLE course_title
(
  
  course_name VARCHAR(25) NOT NULL,
  course_number CHAR(5) NOT NULL,
  CONSTRAINT course_titlePK PRIMARY KEY (course_number),
  CONSTRAINT course_title_course_numberFK FOREIGN KEY (course_number) REFERENCES class(course_number)

);




