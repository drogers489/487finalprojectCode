ALTER TABLE Syllabi DROP FOREIGN KEY FK_Syl_ClassID;
ALTER TABLE Syllabi DROP FOREIGN KEY FK_Syl_ProfessorID;
ALTER TABLE CurrentClasses DROP FOREIGN KEY FK_CC_ClassID;
ALTER TABLE CurrentClasses DROP FOREIGN KEY FK_CC_ProfessorID;
ALTER TABLE Labs DROP FOREIGN KEY FK_Lab_ClassID;

DROP TABLE IF EXISTS CurrentClasses, Labs, Professors, Syllabi, AllClasses;
-- DROP TABLE IF EXISTS adminLogin, profLogin;

-- Data from Course Sheet given in Fall 2023, professor information from cs.olemiss.edu
CREATE TABLE CurrentClasses(
ClassID varchar(12) NOT NULL,
ClassSection char(1) NOT NULL,
ProfessorID varchar(8),
DaysMeeting SET('M','T','W','TH','F'),
TimeSlot varchar(15),
ClassRoom varchar(15),
Lab BOOLEAN,
PRIMARY KEY (ClassID, ClassSection)
)Engine = InnoDB;

CREATE TABLE Labs(
ClassID varchar(12) NOT NULL,
ClassSection char(1) NOT NULL,
DaysMeeting SET('M','T','W','TH','F'),
TimeSlot varchar(15),
PRIMARY KEY (ClassID, ClassSection)
)Engine = InnoDB;

CREATE TABLE Professors(
ProfessorID varchar(8) NOT NULL,
PTitle varchar(4),
PFName varchar(10),
PLName varchar(10),
PEmail varchar(23),
PRIMARY KEY (ProfessorID)
)Engine = InnoDB;

CREATE TABLE Syllabi(
ProfessorID varchar(8) NOT NULL,
ClassID varchar(12) NOT NULL,
file_name VARCHAR(255),
file_data LONGBLOB,
PRIMARY KEY (ProfessorID, ClassID)
)Engine = InnoDB;

CREATE TABLE AllClasses(
    ClassID varchar(15) NOT NULL,
    CourseTitle varchar(50),
    CourseDesc LONGBLOB,
    PRIMARY KEY (ClassID)
)Engine = InnoDB;

-- Login tables
CREATE TABLE adminLogin (
	id int NOT NULL auto_increment,
	username varchar(50) NOT NULL,
	hashed_password varchar(60) NOT NULL,
	PRIMARY KEY (id)
)Engine=InnoDB;

CREATE TABLE profLogin (
	id int NOT NULL auto_increment,
	username varchar(50) NOT NULL,
	hashed_password varchar(60) NOT NULL,
	PRIMARY KEY (id)
)Engine=InnoDB;

-- Foreign Keys
ALTER TABLE Syllabi ADD CONSTRAINT FK_Syl_ClassID FOREIGN KEY (ClassID) references AllClasses(ClassID) ON DELETE CASCADE;
ALTER TABLE Syllabi ADD CONSTRAINT FK_Syl_ProfessorID FOREIGN KEY (ProfessorID) references Professors(ProfessorID) ON DELETE CASCADE;

ALTER TABLE CurrentClasses ADD CONSTRAINT FK_CC_ClassID FOREIGN KEY (ClassID) references AllClasses(ClassID) ON DELETE CASCADE;
ALTER TABLE CurrentClasses ADD CONSTRAINT FK_CC_ProfessorID FOREIGN KEY (ProfessorID) references Professors(ProfessorID) ON DELETE CASCADE;

ALTER TABLE Labs ADD CONSTRAINT FK_Lab_ClassID FOREIGN KEY (ClassID) references CurrentClasses(ClassID) ON DELETE CASCADE;

-- Initial Data
-- Entries MUST go in this order AllClasses > Professors > CurrentClasses > Labs

INSERT INTO AllClasses VALUES ('CSCI/CIS 111', 'Computer Science I', 'Introduction to computer science with emphasis on problem solving and algorithm development. Using high-level, block-structured programming language, students design, implement, debug, test, and document computer programs for various applications.');
INSERT INTO AllClasses VALUES ('CSCI/CIS 112', 'Computer Science II', 'Continuation of CSCI 111 with emphasis on computer programming as a systematic discipline. The topics include data structures, abstract data types, algorithm design and analysis, and programming methods and standards.');
INSERT INTO AllClasses VALUES ('CSCI/CIS 211', 'Computer Science III', 'Continuation of Csci 112 with emphasis on advanced data structures, algorithm design analysis, advanced programming techniques, and user interfaces.');
INSERT INTO AllClasses VALUES ('CSCI 223', 'Computer Org. and Assembly Language', 'Introduction to the architecture of computer systems. The topics include processor and external device structures and operation, machine operation, machine operations and instructions, assembly language concepts, and assembly language programming.');
INSERT INTO AllClasses VALUES ('CSCI 311', 'Models of Computation', 'Introduction to the theoretical foundations of computer science, including automata and formal languages.');
INSERT INTO AllClasses VALUES ('CSCI 323', 'Systems of Programming', 'Study of a contemporary operating system and its set of tools from the perspective of software professionals and system administrators. The course analyzes the system components and their interactions, the tool environment, and system administration issues such as configuration, installation, networking, security, and performance tuning.');
INSERT INTO AllClasses VALUES ('CSCI 343', 'Fundamentals of Data Science','This course explores the field using a broad perspective. Topics include data collection and integration, exploratory data analysis, descriptive statistics, prediction, and regression, and evaluating and communicating results. Significant programming is required.');
INSERT INTO AllClasses VALUES ('CSCI 353', 'Introduction to Numerical Methods','Numerical solution of problems; problem analysis, algorithm design, coding, testing, interpretation of results; use of software packages on mainframe computers.');
INSERT INTO AllClasses VALUES ('CSCI 356', 'Data Structures in Python','This course will introduce data structures and their application using the Python programming language. Abstract data types for stack, queue, various lists, trees and graphs will be studied. Built-in data structures such as lists, dictionaries, and tuples will be used extensively.');
INSERT INTO AllClasses VALUES ('CSCI 361', 'Introduction to Computer Networks','Analysis of loosely coupled computer communication protocols and network services. A generic network model is presented and compared to selected examples of computer networks including the Internet TCP/IP and Internet-based applications.');
INSERT INTO AllClasses VALUES ('CSCI 387', 'Software Design and Development','Study of techniques for the construction of large, complex software systems, including project management, requirements analysis, specification, design, development, testing, documentation, deployment, and maintenance. Students develop software systems in a group structure that simulates an industrial setting');
INSERT INTO AllClasses VALUES ('CSCI 423', 'Introduction to Operating Systems','Study of the basic concepts of operating systems, including user interfaces, process management, state saving, interprocess communication, input/output, device drivers, timing services, memory management, file management, and system abstractions.');
INSERT INTO AllClasses VALUES ('CSCI 426', 'System Security','This course covers the fundamentals of computer security with an emphasis on computer systems security. Areas covered include operating system security mechanisms, access control models, and other relevant topics.');
INSERT INTO AllClasses VALUES ('CSCI 433', 'Algorithm and Data Structure Analysis','Study of the design and analysis of algorithms and data structures. The topics include analysis techniques, sorting, searching, advanced data structures, graphs, string matching, and NP-completeness.');
INSERT INTO AllClasses VALUES ('CSCI Hon 433', 'Honors Algorithm and Data Structure Analysis','For Members of the SMBHC only. Study of the design and analysis of algorithms and data structures. The topics include analysis techniques, sorting, searching, advanced data structures, graphs, string matching, and NP-completeness.');
INSERT INTO AllClasses VALUES ('CSCI 443', 'Advanced Data Science','This course extends the study in Csci 343 to processing and analysis of big data. Topics include machine learning, natural language processing, and data intensive processing techniques such as MapReduce, NoSQL, and other state-of-the-art frameworks.');
INSERT INTO AllClasses VALUES ('CSCI 450', 'Organization of Programming Languages','History and concepts of programming languages; run-time behavior; formal aspects; language definition; data types and structures; control; and data flow, compilation, and interpretation.');
INSERT INTO AllClasses VALUES ('CSCI 475', 'Introduction to Database Systems','This course introduces database systems covering basic concepts and best practices. Topics include data models (e.g., relational, object- oriented, NoSQL), normalization, SQL, security and privacy, current trends in data management, and web-to-database application programming.');
INSERT INTO AllClasses VALUES ('CSCI 487', 'Senior Project','Each student conducts an in-depth study of a current problem in computer science or related area. Upon completion, the student presents the results in both oral and written form.');
INSERT INTO AllClasses VALUES ('CSCI 490', 'Special Topics','Course differs each semester; contact professor for more information');
INSERT INTO AllClasses VALUES ('CSCI 491', 'Special Topics in Computer Security','Course differs each semester; contact professor for more information');
INSERT INTO AllClasses VALUES ('CSCI 492', 'Special Topics in Data Science','Course differs each semester; contact professor for more information');
INSERT INTO AllClasses VALUES ('CSCI 500', 'Fundamental Concepts in Computing','An intensive study of the formal concepts needed for graduate study in computer science.');
INSERT INTO AllClasses VALUES ('CSCI 501', 'Fundamental Concepts in Systems','An intensive study of the fundamental concepts of operating system and machine structures and the associated programming techniques.');
INSERT INTO AllClasses VALUES ('CSCI 502', 'Fundamental Concepts in Algorithms','An intensive study of the fundamental concepts of algorithms and data structures and the associated programming techniques.');
INSERT INTO AllClasses VALUES ('CSCI 503', 'Fundamental Concepts in Languages','An intensive study of the fundamental concepts of programming languages and the associated software system structures.');
INSERT INTO AllClasses VALUES ('CSCI 557', 'GPU Programming','This course examines the use of GPU for general-purpose high performance parallel computing. It covers the key principles, practices, and hardware/software architectures for design of general-purpose, parallel programs using GPUs. The course surveys and analyzes real-world applications that benefit from GPUs, and involves hands-on programming as well as performance profiling and analysis. The fundamentals of concurrent programming and its challenges at algorithm and coding levels are also discussed.');
INSERT INTO AllClasses VALUES ('ENGR 691', 'Special Topics in Engineering Science I','Course differs each semester; contact professor for more information');
INSERT INTO AllClasses VALUES ('ENGR 694', 'Research Topics in Eng. Science II','Course differs each semester; contact professor for more information');

INSERT INTO Professors VALUES ('hxiong', 'Mrs.', 'Hui', 'Xiong', 'hxiong@olemiss.edu');
INSERT INTO Professors VALUES ('jcarlis1', 'Mr.', 'Joseph', 'Carlisle', 'jcarlis1@olemiss.edu');
INSERT INTO Professors VALUES ('kdavidso', 'Dr.', 'Kristin', 'Davidson', 'kdavidso@olemiss.edu');
INSERT INTO Professors VALUES ('bjang', 'Dr.', 'Byunghyun', 'Jang', 'bjang@olemiss.edu');
INSERT INTO Professors VALUES ('jhlucas1', 'Mr.', 'Jeff', 'Lucas', 'jhlucas1@olemiss.edu');
INSERT INTO Professors VALUES ('ychen', 'Dr.', 'Yixin', 'Chen', 'ychen@cs.olemiss.edu');
INSERT INTO Professors VALUES ('tlholsto', 'Dr.', 'Timothy', 'Holston', 'tlholsto@olemiss.edu');
INSERT INTO Professors VALUES ('daharri6', 'Dr.', 'David', 'Harrison', 'daharri6@olemiss.edu');
INSERT INTO Professors VALUES ('yjiang7', 'Dr.', 'Yili', 'Jiang', 'yjiang7@olemiss.edu');
INSERT INTO Professors VALUES ('thaile', 'Dr.', 'Thai', 'Le', 'thaile@olemiss.edu');
INSERT INTO Professors VALUES ('cwwalter', 'Dr.', 'Charlie', 'Walter', 'cwwalter@olemiss.edu');
INSERT INTO Professors VALUES ('fwang', 'Dr.', 'Feng', 'Wang', 'fwang@olemiss.edu');
INSERT INTO Professors VALUES ('hxiao1', 'Dr.', 'Hong', 'Xiao', 'hxiao1@olemiss.edu');
INSERT INTO Professors VALUES ('askang', 'Dr.', 'Arvinder', 'Kang', 'askang@olemiss.edu');

INSERT INTO CurrentClasses VALUES ('CSCI/CIS 111', '1', 'hxiong', 'M,W', '9:00-9:50a', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 111', '2', 'hxiong', 'M,W', '2:00-2:50p', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '1', 'jcarlis1', 'T,TH', '11:00-11:50a', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '2', 'jcarlis1', 'T,TH', '1:00-1:50p', 'Weir 106', '1');
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '3', 'kdavidso', 'M,W', '1:00-1:50p', 'Weir 106', '1');
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 211', '1', 'kdavidso', 'M,W', '11:00-11:50a', 'Weir 235', '1');
INSERT INTO CurrentClasses VALUES ('CSCI 223', '1', 'bjang', 'T,TH','9:30-10:45a', 'Holman 139', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 311', '1', 'tlholsto', 'T,TH', '9:30-10:45a', 'Weir 106', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 323', '1', 'jhlucas1', 'M,W,F', '9:00-9:50a', 'Weir 235', '0'); 
INSERT INTO CurrentClasses VALUES ('CSCI 343', '1', 'thaile', 'M,W,F', '10:00-10:50a', 'Weir 235', '0'); 
INSERT INTO CurrentClasses VALUES ('CSCI 353', '1', 'hxiao1', 'T,TH', '9:30-10:45a', 'TBD', '0'); 
INSERT INTO CurrentClasses VALUES ('CSCI 356', '1', 'kdavidso', 'M,W,F', '10:00-10:50a', 'Conner 13', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 361', '1', 'fwang', 'M,W', '4:00-5:15p', 'Weir 106', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 387', '1', 'tlholsto', 'T,TH', '11:00a-12:15p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 423', '1', 'fwang', 'M,W,F', '11:00-11:50a', 'Weir 106', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 426', '1', 'yjiang7', 'T,TH', '2:30-3:45p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 433', '1', 'ychen', 'M,W,F', '12:00-12:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI Hon 433', '1', 'ychen', 'M,W,F', '12:00-12:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 443', '1', 'daharri6', 'T,TH', '2:30-3:45p', 'Weir 106', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 450', '1', 'hxiong', 'M,W,F', '1:00-1:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 475', '1', 'kdavidso', 'M,W,F', '2:00-2:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 487', '1', 'tlholsto', 'M,W', '4:00-5:15p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 490', '1', 'askang', 'T,TH', '9:30-10:45a', 'Conner 13', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 491', '1', 'cwwalter', 'T,TH', '4:00-5:15p', 'Weir Conf. Room', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 492', '1', 'thaile', 'M,W,F', '1:00-1:50p', 'TBD', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 500', '1', 'tlholsto', 'T,TH', '9:30a-10:45a', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 501', '1', 'fwang', 'M,W,F', '11:00-11:50a', 'Weir 106', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 502', '1', 'ychen', 'M,W,F', '12:00-12:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 503', '1', 'ychen', 'M,W,F', '1:00-1:50p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 557', '1', 'bjang', 'T,TH', '4:00-5:15p', 'Weir 235', '0');
INSERT INTO CurrentClasses VALUES ('ENGR 691', '1', 'thaile', 'M,W,F', '1:00-1:50p', 'TBD', '0');
INSERT INTO CurrentClasses VALUES ('ENGR 694', '1', 'cwwalter', 'T,TH', '11:00a-12:15p', 'Weir Conf. Room', '0');

INSERT INTO Labs VALUES ('CSCI/CIS 111', '1', 'F', '8:00-9:50a');
INSERT INTO Labs VALUES ('CSCI/CIS 111', '2', 'F', '2:00-3:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '1', 'TH', '12:00-1:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '2', 'TH', '2:00-3:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '3', 'F', '12:00-1:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 211', '1', 'F', '10:00-11:50a');



