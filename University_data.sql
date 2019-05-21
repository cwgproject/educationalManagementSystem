insert into un_role values(1,'管理员','管理一切后台信息');
insert into un_role values(2,'教师','发布作业和考试并可以查看学生成绩');
insert into un_role values(3,'学生','考试写作业查看成绩');
insert into un_role values(4,'超级管理员','牛笔！！');


insert into un_academy values(1,'经济学院','学院科研体系完善 师资力量雄厚','Tony Stark');
insert into un_academy values(2,'文学院','学院学术交流广泛 服务社会深入','Steve Rogers');
insert into un_academy values(3,'信息学院','学院办学层次齐全 发展历史悠久','Bruce Banner');
insert into un_academy values(4,'体育学院','学院文化底蕴深厚 教学示范中心','Thor Odinson');
insert into un_academy values(5,'艺术学院','学院重视学生 培养综合素质','Natasha Romanoff');



insert into un_major values(1,'国际贸易','',1,'1,2,3');
insert into un_major values(2,'保险精算','',1,'1,2,3');

insert into un_major values(3,'马克思主义','',2,'1');
insert into un_major values(4,'哲学','',2,'1');

insert into un_major values(5,'软件工程','',3,'1');
insert into un_major values(6,'网络工程','',3,'1');

insert into un_major values(7,'自行车','',4,'1');
insert into un_major values(8,'篮球','',4,'1');

insert into un_major values(9,'艺术鉴赏','',5,'1');
insert into un_major values(10,'声乐','',5,'1');



insert into un_course values(1,'商务经济','','是','是','6','40',1,'');
insert into un_course values(2,'经济学','','是','是','8','32',2,'');

insert into un_course values(3,'马克思主义哲学','','是','否','8','36',3,'');
insert into un_course values(4,'基本哲学','','是','是','10','60',4,'');

insert into un_course values(5,'软件构造','','否','否','8','36',5,'');
insert into un_course values(6,'数据库','','是','是','3','20',6,'');

insert into un_course values(7,'有氧运动','','是','是','2','15',7,'');
insert into un_course values(8,'蔡氏运球II','','是','是','1','10',8,'');
insert into un_course values(9,'素描II','','是','是','6','40',9,'');
insert into un_course values(10,'美声','','是','是','3','30',10,'');


insert into un_teacher values(1,'Rahul Khan','1000','讲师',1,1,'','');
insert into un_teacher values(2,'Pepper','1001','教授',1,2,'','');

insert into un_teacher values(3,'Bucky Barnes','2000','讲师',2,3,'','');
insert into un_teacher values(4,'Sam Wilson','2001','讲师',2,4,'','');

insert into un_teacher values(5,'Hulk','3000','教授',3,5,'','');
insert into un_teacher values(6,'Red Hulk','3001','副教授',3,6,'','');


insert into un_teacher values(7,'Loki','4000','讲师',4,7,'','');
insert into un_teacher values(8,'Hela','4001','讲师',4,8,'','');

insert into un_teacher values(9,'Barton','5000','副教授',5,9,'','');
insert into un_teacher values(10,'Wanda','5001','副教授',5,10,'','');


insert into un_class values(1,'经济学院1班',1);
insert into un_class values(2,'经济学院2班',2);

insert into un_class values(3,'文学院1班',3);
insert into un_class values(4,'文学院2班',4);

insert into un_class values(5,'信息学院1班',5);
insert into un_class values(6,'信息学院2班',6);

insert into un_class values(7,'体育学院1班',7);
insert into un_class values(8,'体育学院2班',8);

insert into un_class values(9,'艺术学院1班',9);
insert into un_class values(10,'艺术学院2班',10);


insert into un_student values(1,'201540704101','Mike','Male',1,'1996-1-1','北京',1,1);
insert into un_student values(2,'201540704102','Amy','Fmale',1,'1997-2-18','上海',1,1);

insert into un_student values(3,'201540704201','Cyclops','Male',2,'1995-12-30','青岛',1,2);
insert into un_student values(4,'201540704202','White Queen','Fmale',2,'1998-3-11','重庆',1,2);

insert into un_student values(5,'201540704301','Shadowcat','Fmale',3,'1995-11-11','广州',2,3);
insert into un_student values(6,'201540704302','Colossus','Male',3,'1996-10-9','北京',2,3);

insert into un_student values(7,'201540704401','Magneto','Male',4,'1996-12-12','厦门',2,4);
insert into un_student values(8,'201540704402','Polaris','Fmale',4,'1996-8-7','青岛',2,4);

insert into un_student values(9,'201540704501','Professor X','Male',5,'1996-7-9','海南',3,5);
insert into un_student values(10,'201540704502','Mystique','Fmale',5,'1996-5-15','浙江',3,5);

insert into un_student values(11,'201540704601','Azazel','Male',6,'1997-4-16','青岛',3,6);
insert into un_student values(12,'201540704602','NightCrawler','Male',6,'1996-6-29','北京',3,6);

insert into un_student values(13,'201540704701','Storm','Fmale',7,'1997-1-12','青岛',4,7);
insert into un_student values(14,'201540704701','Angel','Male',7,'1996-7-5','成都',4,7);

insert into un_student values(15,'201540704801','Deadpool','Male',8,'1998-3-2','上海',4,8);
insert into un_student values(16,'201540704801','Cable','Male',8,'1998-10-10','上海',4,8);

insert into un_student values(17,'201540704901','Rogue','Fmale',9,'1996-5-26','北京',5,9);
insert into un_student values(18,'201540704901','Iceman','Male',9,'1996-2-29','北京',5,9);

insert into un_student values(19,'201540704001','Beast','Male',10,'1997-6-1','青岛',5,10);
insert into un_student values(20,'201540704002','Quicksilver','Male',10,'1998-11-19','上海',5,10);




select * from un_user;

insert into un_user values(1,'Nick','202cb962ac59075b964b07152d234b70','',3,0,1,'','','','');
insert into un_user values(2,'Turing','202cb962ac59075b964b07152d234b70','',3,0,1,'','','','');
insert into un_user values(3,'Bill','202cb962ac59075b964b07152d234b70','',3,0,1,'','','','');

insert into un_user values(4,'1000','202cb962ac59075b964b07152d234b70','',3,0,2,'','','','');
insert into un_user values(5,'1001','202cb962ac59075b964b07152d234b70','',3,0,2,'','','','');

insert into un_user values(6,'201540704102','202cb962ac59075b964b07152d234b70','',3,0,3,'','','','');
insert into un_user values(7,'201540704602','202cb962ac59075b964b07152d234b70','',3,0,3,'','','','');
insert into un_user values(8,'Boss','202cb962ac59075b964b07152d234b70','',3,0,4,'','','','');


insert into un_authority(auth_name, auth_state) values('up_info', true);
insert into un_authority(auth_name, auth_state) values('del_info', false);
insert into un_authority(auth_name, auth_state) values('teacher_course', false);
insert into un_authority(auth_name, auth_state) values('student_course', false);
insert into un_authority(auth_name, auth_state) values('judge', false);
insert into un_authority(auth_name, auth_state) values('grade', false);
insert into un_authority(auth_name, auth_state) values('insert_info', false);