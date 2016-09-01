
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
  student_number VARCHAR(15) NOT NULL COMMENT '学号',
  student_sex VARCHAR(2) NOT NULL COMMENT '性别 0男、1女',
  phone VARCHAR(15) NOT NULL  COMMENT '手机号码',
  department_id INT NOT NULL  COMMENT '院系编号',
  arument VARCHAR(400) DEFAULT '' COMMENT '申请理由',
  create_time DATETIME  COMMENT '创建时间',
  update_time TIMESTAMP  ON UPDATE current_timestamp  DEFAULT current_timestamp COMMENT '更新时间，时间戳',
  remark VARCHAR(100) DEFAULT '0' COMMENT '备注 默认值0 没有意义'

);
#为学生临时表添加外键约束
ALTER TABLE mt_student_temp ADD CONSTRAINT c_fk_stydent_temp_dep FOREIGN KEY (department_id) REFERENCES mt_department(department_id);
