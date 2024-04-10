DROP TABLE IF EXISTS CurrentClasses, Labs, Professors, Syllabi, AllClasses;

-- Data from Course Sheet given in Fall 2023, professor information from cs.olemiss.edu
CREATE TABLE CurrentClasses(
ClassID varchar(12) NOT NULL,
ClassSection char(1) NOT NULL,
ProfessorID varchar(8),
DaysMeeting SET('M','T','W','TH','F'),
TimeSlot varchar(15), -- May switch to a "set" datatype as well, string allows for more flexibility atm
ClassRoom varchar(15),
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
Syllabus LONGBLOB,
PRIMARY KEY (ProfessorID, ClassID)
)Engine = InnoDB;

CREATE TABLE AllClasses(
    ClassID varchar(15) NOT NULL,
    CourseTitle varchar(50),
    CourseDesc LONGBLOB,
    PRIMARY KEY (ClassID)
)Engine = InnoDB;


-- Example data for demo
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 111', '1', 'hxiong', 'M,W', '9:00-9:50a', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 111', '2', 'hxiong', 'M,W', '2:00-2:50p', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '1', 'jcarlis1', 'T,TH', '11:00-11:50a', 'Weir 106', '1'); 
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '2', 'jcarlis1', 'T,TH', '1:00-1:50p', 'Weir 106', '1');
INSERT INTO CurrentClasses VALUES ('CSCI/CIS 112', '3', 'kdavidso', 'M,W', '1:00-1:50p', 'Weir 106', '1');
INSERT INTO CurrentClasses VALUES ('CSCI 223', '1', 'bjang', 'T,TH', '9:30-10:45a', 'Holman 139', '0');
INSERT INTO CurrentClasses VALUES ('CSCI 323', '1', 'jhlucas1', 'M,W,F', '9:00-9:50a', 'Weir 235', '0'); 

INSERT INTO Labs VALUES ('CSCI/CIS 111', '1', 'F', '8:00-9:50a');
INSERT INTO Labs VALUES ('CSCI/CIS 111', '2', 'F', '2:00-3:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '1', 'TH', '12:00-1:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '2', 'TH', '2:00-3:50p');
INSERT INTO Labs VALUES ('CSCI/CIS 112', '3', 'F', '12:00-1:50p');

INSERT INTO Professors VALUES ('hxiong', 'Mrs.', 'Hui', 'Xiong', 'hxiong@olemiss.edu');
INSERT INTO Professors VALUES ('jcarlis1', 'Mr.', 'Joseph', 'Carlisle', 'jcarlis1@olemiss.edu');
INSERT INTO Professors VALUES ('kdaviso', 'Dr.', 'Kristin', 'Davidson', 'kdavidso@olemiss.edu');
INSERT INTO Professors VALUES ('bjang', 'Dr.', 'Byunghyun', 'Jang', 'bjang@olemiss.edu');
INSERT INTO Professors VALUES ('jhlucas1', 'Mr.', 'Jeff', 'Lucas', 'jhlucas1@olemiss.edu');

INSERT INTO Syllabi VALUES ('hxiong', 'CSCI/CIS 111', 'This is a placeholder');

INSERT INTO AllClasses VALUES ('CSCI/CIS 111', 'Computer Science 1', 'Introduction to computer science with emphasis on problem solving and algorithm development. Using high-level, block-structured programming language, students design, implement, debug, test, and document computer programs for various applications.');
INSERT INTO AllClasses VALUES ('CSCI/CIS 112', 'Computer Science 2', 'Continuation of CSCI 111 with emphasis on computer programming as a systematic discipline. The topics include data structures, abstract data types, algorithm design and analysis, and programming methods and standards.');
INSERT INTO AllClasses VALUES ('CSCI 223', 'Computer Org. and Assembly Language', 'Introduction to the architecture of computer systems. The topics include processor and external device structures and operation, machine operation, machine operations and instructions, assembly language concepts, and assembly language programming.');
INSERT INTO AllClasses VALUES ('CSCI 323', 'Systems of Programming', 'Study of a contemporary operating system and its set of tools from the perspective of software professionals and system administrators. The course analyzes the system components and their interactions, the tool environment, and system administration issues such as configuration, installation, networking, security, and performance tuning.');