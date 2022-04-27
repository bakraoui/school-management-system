CREATE DATABASE `school`; 
CREATE TABLE `manager`(
    `id_user` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `fname_user` VARCHAR(20) NOT NULL,
    `lname_user` VARCHAR(20) NOT NULL,
    `email_user` VARCHAR(50) UNIQUE NOT NULL,
    `cin_user` VARCHAR(16) NOT NULL,
    `adress_user` VARCHAR(100) ,
    `city_user` VARCHAR(20) ,
    `image_user` VARCHAR(20) ,
    `password` VARCHAR(80) NOT NULL,
    `is_super` BOOLEAN DEFAULT FALSE NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_user`)
);

 CREATE TABLE `student`(
    `id_user` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `fname_user` VARCHAR(20) NOT NULL,
    `lname_user` VARCHAR(20) NOT NULL,
    `email_user` VARCHAR(50) UNIQUE NOT NULL,
    `cin_user` VARCHAR(16) NOT NULL,
    `cne_student` VARCHAR(22) NOT NULL,
    `adress_user` VARCHAR(100) ,
    `city_user` VARCHAR(20) ,
    `image_user` VARCHAR(20) ,
    `password` VARCHAR(80) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_user`)
); 

CREATE TABLE `branch`(
    `id_branch` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title_branch` VARCHAR(40) NOT NULL,
    `description_branch` TEXT NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_branch`)
); 

CREATE TABLE `payement`(
    `id_payement` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `id_session` INT(8) UNSIGNED NOT NULL,
    `sum` DECIMAL(6, 2) NOT NULL,
    `sum_payed` DECIMAL(6, 2) NOT NULL,
    `sum_rest` DECIMAL(6, 2) NOT NULL,
    `date_payement` VARCHAR(30) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    `day_payement` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    PRIMARY KEY(`id_payement`)
); 

CREATE TABLE `class`(
    `id_class` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title_class` VARCHAR(20) NOT NULL,
    `id_branch` INT(8) UNSIGNED NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    FOREIGN KEY(`id_branch`) REFERENCES `branch`(`id_branch`),
    PRIMARY KEY(`id_class`)
); 

CREATE TABLE `session`(
    `id_session` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `date_start` INT(5) NOT NULL,
    `date_end` INT(5) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_session`)
); 

CREATE TABLE `inscription`(
    `id_inscription` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_class` INT(8) UNSIGNED NOT NULL,
    `id_session` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `date_inscription` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_inscription`,
        `id_user`,
        `id_session`,
        `id_class`
    ),
    FOREIGN KEY(`id_class`) REFERENCES `class`(`id_class`),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    FOREIGN KEY(`id_session`) REFERENCES `session`(`id_session`)
); 

CREATE TABLE `global_mark`(
    `id_global_mark` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_session` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `global_mark` DOUBLE NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_global_mark`,
        `id_user`,
        `id_session`
    ),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    FOREIGN KEY(`id_session`) REFERENCES `session`(`id_session`)
); 

CREATE TABLE `semester`(
    `id_semester` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title_semester` VARCHAR(40) NOT NULL,
    `id_session` INT(8) UNSIGNED NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_semester`),
    FOREIGN KEY(`id_session`) REFERENCES `session`(`id_session`)
); 

CREATE TABLE `mark_semester`(
    `id_mark_semester` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `id_semester` INT(8) UNSIGNED NOT NULL,
    `mark_semester` DOUBLE NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_mark_semester`,
        `id_user`,
        `id_semester`
    ),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    FOREIGN KEY(`id_semester`) REFERENCES `semester`(`id_semester`)
); 

CREATE TABLE `classroom`(
    `id_classroom` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title_classroom` VARCHAR(80) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_classroom`)
); 

CREATE TABLE `teacher`(
    `id_user` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `fname_user` VARCHAR(20) NOT NULL,
    `lname_user` VARCHAR(20) NOT NULL,
    `cin_user` VARCHAR(16) NOT NULL,
    `adress_user` VARCHAR(50) ,
    `email_user` VARCHAR(30) NOT NULL,
    `city_user` VARCHAR(20) ,
    `image_user` VARCHAR(20) ,
    `password` VARCHAR(80) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_user`)
); 

CREATE TABLE `module`(
    `id_module`  INT(8) UNSIGNED AUTO_INCREMENT NOT NULL ,
    `title` VARCHAR(100) ,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
     PRIMARY KEY (`id_module`)
);

CREATE TABLE `subject`(
    `id_subject` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_module`  INT(8) UNSIGNED  NOT NULL ,
    `title_subject` VARCHAR(30) NOT NULL,
    `thumbnail` VARCHAR(50) DEFAULT NULL,
    `coefficient` INT(1) NOT NULL DEFAULT 1 ,
    `percentage` FLOAT NOT NULL DEFAULT 0.00 ,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_subject`)
); 
CREATE TABLE `unit`(
    `id_unit` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED  NOT NULL,
    `title_unit` VARCHAR(30) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_unit`,`id_subject`) ,
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`)
); 
CREATE TABLE `mark_module`(
    `id_mark_module` INT(8)  UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_module` INT(8) UNSIGNED NOT NULL,
    `id_semester` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `mark_module` DOUBLE NOT NULL ,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY( `id_mark_module`, `id_semester`,  `id_user`,`id_module` ),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`) ,
    FOREIGN KEY(`id_semester`) REFERENCES `semester`(`id_semester`)
); 

CREATE TABLE `mark_subject`(
    `id_mark_subject` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_semester` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `mark_subject` DOUBLE NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_mark_subject`,
        `id_user`,
        `id_semester`,
        `id_subject`
    ),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    FOREIGN KEY(`id_semester`) REFERENCES `semester`(`id_semester`),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`)
); 
CREATE TABLE `mark_unit`(
    `id_mark_unit` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_unit` INT(8) UNSIGNED NOT NULL,
    `id_semester` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `mark_unit` DOUBLE NOT NULL ,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_mark_unit`,
         `id_unit`,
        `id_user`,
        `id_semester`
    ),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`),
    FOREIGN KEY(`id_semester`) REFERENCES `semester`(`id_semester`),
    FOREIGN KEY(`id_unit`) REFERENCES `unit`(`id_unit`)
); 

CREATE TABLE `absence_subject`(
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `nbr_abs_total` INT(8) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_subject`, `id_user`),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`)
); 


CREATE TABLE `course`(
    `id_course` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_semester` INT(8) UNSIGNED NOT NULL,
    `id_class` INT(8) UNSIGNED NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_classroom` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `time_course` VARCHAR(8) NOT NULL,
    `date_course` VARCHAR(10) NOT NULL,
    `duration_course` VARCHAR(10) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_course`),
    FOREIGN KEY(`id_semester`) REFERENCES `semester`(`id_semester`),
    FOREIGN KEY(`id_class`) REFERENCES `class`(`id_class`),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_classroom`) REFERENCES `classroom`(`id_classroom`),
    FOREIGN KEY(`id_user`) REFERENCES `teacher`(`id_user`)
); 


CREATE TABLE `absence_course`(
    `id_absence_course` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `is_absent` BOOLEAN NOT NULL DEFAULT FALSE,
    `date_absence` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_absence_course`,
        `id_subject`,
        `id_user`,
        `date_absence`
    ),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`)
); 


CREATE TABLE `prof_subject`(
    `id_prof_subject` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(
        `id_prof_subject`,
        `id_subject`,
        `id_user`
    ),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_user`) REFERENCES `teacher`(`id_user`)
); 


CREATE TABLE `exam`(
    `id_exam` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_class` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `exam_file` VARCHAR(100) NOT NULL,
    `exam_start` DATE NOT NULL,
    `exam_end` DATE NOT NULL,
    `exam_date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `thumbnail` VARCHAR(50) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_exam`),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_user`) REFERENCES `teacher`(`id_user`),
    FOREIGN KEY(`id_class`) REFERENCES `class`(`id_class`)
); 


CREATE TABLE `exam_solution`(
    `id_exam_solution` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `id_exam` INT(8) UNSIGNED NOT NULL,
    `exam_solution` VARCHAR(100) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_exam_solution`),
    FOREIGN KEY(`id_exam`) REFERENCES `exam`(`id_exam`),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`)
); 


CREATE TABLE `setting`(
    `id_setting` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `allow_inscription` BOOLEAN DEFAULT FALSE NOT NULL,
    `allow_insert_marks` BOOLEAN DEFAULT FALSE NOT NULL,
    `allow_showing_marks` BOOLEAN DEFAULT FALSE NOT NULL,
    
    PRIMARY KEY(`id_setting`)
);
CREATE TABLE `school`(
    `id_school` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(200)  DEFAULT NULL,
    `adress`  VARCHAR(200)  DEFAULT NULL ,
    `city` VARCHAR(200) DEFAULT NULL ,
    `logo`  VARCHAR(200) DEFAULT NULL ,
    `type` INT(1)  DEFAULT NULL,
    `email` VARCHAR(200) DEFAULT NULL ,
    `tele` VARCHAR(200) DEFAULT NULL ,
    `facebook` VARCHAR(200)  DEFAULT NULL,
    `linked` VARCHAR(200)  DEFAULT NULL,
    `insta` VARCHAR(200) DEFAULT NULL ,
    `twitter` VARCHAR(200)  DEFAULT NULL,
    `director` TEXT DEFAULT NULL ,
    `about` TEXT DEFAULT NULL ,
    `low` TEXT DEFAULT NULL ,
    PRIMARY KEY (`id_school`) 
);

CREATE TABLE `service`(
    `id_service` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(200)  NOT NULL,
    `logo`  VARCHAR(200) DEFAULT NULL ,
    `description`  TEXT DEFAULT NULL ,
    PRIMARY KEY (`id_service`) 
);



CREATE TABLE `notification`(
    `id_notification` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `title` VARCHAR(100)  NOT NULL,
    `text` VARCHAR(200)  NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    `is_read` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_notification`),
    FOREIGN KEY(`id_user`) REFERENCES `student`(`id_user`)
); 

CREATE TABLE `events`(
    `id_event` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `event_title` VARCHAR(100) NOT NULL,
    `event_image` VARCHAR(100) ,
    `description` TEXT NOT NULL,
    `event_date` date NOT NULL,
    `event_time` time NOT NULL,
    `event_location` VARCHAR(150) NOT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_event`)
); 
CREATE TABLE `course_file`(
    `id_course_file` INT(8) UNSIGNED AUTO_INCREMENT NOT NULL,
    `id_subject` INT(8) UNSIGNED NOT NULL,
    `id_user` INT(8) UNSIGNED NOT NULL,
    `file` VARCHAR(100)  NOT NULL,
    `title` VARCHAR(100)  NOT NULL,
    `description` TEXT DEFAULT NULL,
    `is_deleted` BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(`id_course_file`),
    FOREIGN KEY(`id_subject`) REFERENCES `subject`(`id_subject`),
    FOREIGN KEY(`id_user`) REFERENCES `teacher`(`id_user`)
) ;

INSERT INTO `manager`(
    `id_user`,
    `fname_user`,
    `lname_user`,
    `cin_user`,
    `email_user`,
    `password`,
    `is_super`,
    `is_deleted`
)
VALUES(
    '1',
    'manager',
    'admin',
    'IB658905',
    'manager@gmail.com',
    'admin0000',
    TRUE,
    FALSE
);

INSERT INTO `setting`(
    `id_setting`,
    `allow_inscription`,
    `allow_insert_marks`,
    `allow_showing_marks`
)
VALUES(
    '1',
    FALSE ,
    FALSE ,
    FALSE
);

