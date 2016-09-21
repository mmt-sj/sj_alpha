
DROP DATABASE  IF EXISTS sj_alpha ;
CREATE DATABASE IF NOT EXISTS sj_alpha DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;#创建数据库sj_alpha 并且设置编码
USE sj_alpha;#选择数据库
#创建课程表 用来存放学生的课程表信息
CREATE TABLE  IF NOT EXISTS `mt_course`(
  course_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT '课程编号',
  student_id INT NOT NULL COMMENT '学生编号',
  week INT NOT NULL COMMENT '星期',
  start_week INT NOT NULL COMMENT '开始星期',
  end_week INT NOT NULL COMMENT '结束星期',
  course_name VARCHAR(30) NOT NULL COMMENT '课程名称',
  lessons VARCHAR(30) NOT NULL  COMMENT '节数',
  course_type INT NOT NULL COMMENT '课程类型 0:单周 1：双周 2：连上',
  create_time DATETIME COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'
);
#创建学生表  用来存放学生信息
CREATE TABLE  IF NOT EXISTS `mt_student`(
  student_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '学生编号',
  student_number VARCHAR(15) NOT NULL COMMENT '学号',
  student_name VARCHAR(20) NOT NULL  COMMENT '姓名',
  student_sex VARCHAR(2) NOT NULL COMMENT '性别',
  student_type INT NOT NULL DEFAULT 0 COMMENT '0：一般 1：组长: 2管理员',
  department_id INT NOT NULL  COMMENT '院系编号',
  phone VARCHAR(15) NOT NULL COMMENT '手机号码',
  email VARCHAR(30) NOT NULL COMMENT '电子邮箱',
  create_time DATETIME  COMMENT '创建时间，',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  student_delete INT NOT NULL DEFAULT '0' COMMENT '0不存在，1存在',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'
);
#创建院系表 用来存放院系信息
CREATE TABLE IF NOT EXISTS `mt_department` (
  department_id INT NOT NULL  PRIMARY KEY AUTO_INCREMENT COMMENT '院系编号',
  department_name VARCHAR(40) NOT NULL COMMENT '院系名称',
  create_time DATETIME  COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'
);
#为学生课程表添加外键
ALTER TABLE mt_course ADD CONSTRAINT c_fk FOREIGN KEY (student_id) REFERENCES mt_student(student_id);

#为学生表添加外键
ALTER TABLE mt_student ADD CONSTRAINT c_fk_dep FOREIGN KEY (department_id) REFERENCES mt_department(department_id);

# 学生临时表 student_temp
CREATE TABLE IF NOT EXISTS `mt_student_temp`(
  student_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '学生编号',
  student_name VARCHAR(20) NOT NULL  COMMENT '姓名',
  student_number VARCHAR(15) NOT NULL COMMENT '学号',
  student_sex VARCHAR(2) NOT NULL COMMENT '性别 0男、1女',
  phone VARCHAR(15) NOT NULL  COMMENT '手机号码',
  department_id INT NOT NULL  COMMENT '院系编号',
  status INT  NOT NULL DEFAULT 0 COMMENT '状态 0为操作,1已操作',
  argument VARCHAR(400) DEFAULT '' COMMENT '申请理由',
  operate_id INT COMMENT '操作人id',
  create_time DATETIME  COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'

);
#为学生临时表添加外键约束
ALTER TABLE mt_student_temp ADD CONSTRAINT c_fk_stydent_temp_dep FOREIGN KEY (department_id) REFERENCES mt_department(department_id);

#角色表
CREATE TABLE IF NOT EXISTS `mt_role`(
  id INT NOT NULL  PRIMARY KEY  AUTO_INCREMENT COMMENT '权限ID',
  name VARCHAR(20) NOT NULL COMMENT '权限名称',
  describes VARCHAR(400) DEFAULT ' ' COMMENT '角色描述',
  status INT NOT NULL COMMENT '0禁止 1使用',
  create_time DATETIME  COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'

);
INSERT INTO mt_role(name, describes, status, create_time) VALUES ('超级管理员','拥有所有权限',1,'2016-9-15 22:32:00');
#后台用户表
CREATE TABLE IF NOT EXISTS `mt_admin`(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '用户id',
  account VARCHAR(20) NOT NULL COMMENT '用户账号',
  name VARCHAR(10) NOT NULL COMMENT '用户姓名',
  password CHAR(32) NOT NULL COMMENT '密码',
  login_count INT DEFAULT 0 COMMENT '登录次数',
  client_ip VARCHAR(15) COMMENT '登录的ip地址',
  status INT NOT NULL COMMENT '0禁止 1使用',
  role_id INT NOT NULL COMMENT '角色类型',
  create_time DATETIME  COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'
);
INSERT INTO mt_admin(account, name, password, login_count,client_ip,status,role_id,create_time) VALUES ('admin@admin.com','三江管理员',md5('admin'),2,'192.165.167.133',1,1,'2016-9-15 22:32:00');
# 为后台用户表添加外键
ALTER TABLE mt_admin ADD CONSTRAINT c_fk_admin_dep FOREIGN KEY (role_id) REFERENCES mt_role(id);