
drop database University;

CREATE DATABASE IF NOT EXISTS University DEFAULT CHARACTER SET utf8;
USE University;

/*学院表*/ /*学院ID(主键) 学院名称 学院描述 学院主管*/
CREATE TABLE un_academy
(
academy_id int NOT NULL AUTO_INCREMENT,
academy_name varchar(50) NOT NULL,
academy_desc varchar(200),
academy_director varchar(50),
PRIMARY KEY(academy_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*专业表*/ /*专业ID(主键) 专业名称 专业描述 学院ID(外键) 主修课程*/
CREATE TABLE un_major
(
major_id int NOT NULL AUTO_INCREMENT,
major_name varchar(50) NOT NULL,
major_desc varchar(200),
academy_id int NOT NULL,
course_ids varchar (50),
PRIMARY KEY (major_id),
FOREIGN KEY (academy_id) REFERENCES un_academy (academy_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*课程表*/ /*课程ID(主键) 课程名称 专业描述 是否必修课 是否公选课 学分 课时 专业ID(外键) 教材封面*/
CREATE TABLE un_course
(
course_id int auto_increment,
course_name varchar(50) NOT NULL,
course_desc varchar(50),
course_required varchar(50) NOT NULL,
course_public varchar(50) NOT NULL,
course_score varchar(50) NOT NULL,
course_hour varchar(50) NOT NULL,
major_id int NOT NULL,
course_cover varchar(200),
primary key(course_id),
FOREIGN KEY (major_id) REFERENCES un_major (major_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

select * from un_course;

/*教师表*/ /*教师ID(主键) 教师名称 教师职称 专业ID(外键)，课程ID(教授课程 外键) 教师介绍 教师照片*/
CREATE TABLE un_teacher
(
tea_id int auto_increment,
tea_name varchar(50) NOT NULL,
tea_rollno varchar(50) NOT NULL,
tea_title varchar(50) NOT NULL,
academy_id int NOT NULL,
course_id int NOT NULL,
tea_desc varchar(50),
tea_photo varchar(200),
primary key(tea_id),
FOREIGN KEY (academy_id) REFERENCES un_academy (academy_id),
FOREIGN KEY (course_id) REFERENCES un_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

select * from un_teacher;


/*班级表*/ /*班级ID(主键) 班级名称 专业ID(外键)*/
CREATE TABLE un_class
(
class_id int auto_increment,
class_name varchar(50) NOT NULL,
major_id int NOT NULL,
primary key(class_id),
FOREIGN KEY (major_id) REFERENCES un_major (major_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

select * from un_class;


/*学生表*/ /*学生ID(主键) 学生学号 学生姓名 班级ID(外键) 学生生日 学生住址*/
CREATE TABLE un_student
(
stu_id int auto_increment,
stu_rollno varchar(50) NOT NULL,
stu_name varchar(50) NOT NULL,
stu_sex varchar(50) NOT NULL,
class_id int NOT NULL,
stu_birth date,
stu_address varchar(200),
academy_id int NOT NULL,
major_id int NOT NULL,
primary key(stu_id),
FOREIGN KEY (academy_id) REFERENCES un_academy (academy_id),
FOREIGN KEY (major_id) REFERENCES un_major (major_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*角色表*/ /*角色ID(主键) 角色名称 角色介绍*/
CREATE TABLE un_role
(
role_id int auto_increment,
role_name varchar(50) NOT NULL,
role_desc varchar(50),
primary key(role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

select * from un_role;



/*用户表*/ /*用户ID(主键) 用户姓名 用户密码 用户头像 角色ID(外键) 最近登录时间 最近登录地址 所用的浏览器UserAent*/
CREATE TABLE un_user
(
user_id int auto_increment,
user_name varchar(50) NOT NULL,
user_password varchar(50) NOT NULL,
user_photo varchar(200),
user_count int,
user_status int,
role_id int NOT NULL,
rec_time varchar(200),
time_last_error varchar(200), 
rec_address varchar(200),
rec_useraent varchar(200),
primary key(user_id),
FOREIGN KEY (role_id) REFERENCES un_role (role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


select * from un_user;

CREATE TABLE un_mark 
(
mark_id int auto_increment,
stu_id int NOT NULL,
course_id int NOT NULL,
mark varchar(200) NOT NULL,	
primary key(mark_id),
FOREIGN KEY (stu_id) REFERENCES un_student (stu_id),
FOREIGN KEY (course_id) REFERENCES un_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




