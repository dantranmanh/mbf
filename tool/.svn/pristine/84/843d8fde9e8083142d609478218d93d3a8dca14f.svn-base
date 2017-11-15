/*
Navicat Oracle Data Transfer
Oracle Client Version : 10.2.0.5.0

Source Server         : 115.146.126.194
Source Server Version : 120200
Source Host           : 115.146.126.194:1521
Source Schema         : CARD_CREDIT

Target Server Type    : ORACLE
Target Server Version : 120200
File Encoding         : 65001

Date: 2017-11-09 14:20:36
*/


-- ----------------------------
-- Table structure for IDVN_CORE_ACTION
-- ----------------------------
DROP TABLE "CARD_CREDIT"."IDVN_CORE_ACTION";
CREATE TABLE "CARD_CREDIT"."IDVN_CORE_ACTION" (
"ACTION_ID" NUMBER(10) NOT NULL ,
"CONTROLLER_NAME" VARCHAR2(100 BYTE) DEFAULT NULL  NULL ,
"ACTION_NAME" VARCHAR2(100 BYTE) DEFAULT NULL  NULL ,
"TYPE" VARCHAR2(255 BYTE) NOT NULL 
)
LOGGING
NOCOMPRESS
NOCACHE

;

-- ----------------------------
-- Records of IDVN_CORE_ACTION
-- ----------------------------
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('32', 'Group_Controller', 'list', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('35', 'Group_Controller', 'delete', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('44', 'Permission_Controller', 'index', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('45', 'Permission_Controller', 'action', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('55', 'User_Controller', 'list', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('59', 'User_Controller', 'activate', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('60', 'User_Controller', 'check', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('95', 'Permission_Controller', 'delete_action', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('97', 'Group_Controller', 'add', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('98', 'Group_Controller', 'edit', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('100', 'Group_Controller', 'activate', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('105', 'User_Controller', 'add', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('106', 'User_Controller', 'edit', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('107', 'User_Controller', 'delete', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('110', 'User_Controller', 'suggest', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_ACTION" VALUES ('130', 'System_Controller', 'config', 'TOOL');

-- ----------------------------
-- Table structure for IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------
DROP TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS";
CREATE TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" (
"PID" NUMBER(10) NOT NULL ,
"PERMISSION_NAME" VARCHAR2(100 BYTE) NOT NULL ,
"PERMISSION_TYPE" NUMBER(10) DEFAULT NULL  NULL ,
"CONTROLLER_NAME" VARCHAR2(255 BYTE) DEFAULT NULL  NULL ,
"GROUP_ID" NUMBER(10) NOT NULL 
)
LOGGING
NOCOMPRESS
NOCACHE

;

-- ----------------------------
-- Records of IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------

-- ----------------------------
-- Table structure for IDVN_CORE_USER
-- ----------------------------
DROP TABLE "CARD_CREDIT"."IDVN_CORE_USER";
CREATE TABLE "CARD_CREDIT"."IDVN_CORE_USER" (
"USER_ID" NUMBER(10) NOT NULL ,
"GROUP_ID" NUMBER(10) NOT NULL ,
"FULL_NAME" VARCHAR2(100 BYTE) NOT NULL ,
"USER_NAME" VARCHAR2(100 BYTE) NOT NULL ,
"PASSWORD" VARCHAR2(50 BYTE) NOT NULL ,
"EMAIL" VARCHAR2(255 BYTE) DEFAULT NULL  NULL ,
"IS_ACTIVE" NUMBER(3) DEFAULT '0'  NOT NULL ,
"CREATED_DATE" TIMESTAMP(0)  DEFAULT NULL  NULL ,
"LOGGED_IN_DATE" TIMESTAMP(0)  DEFAULT NULL  NULL ,
"IS_ONLINE" NUMBER(3) DEFAULT '0'  NULL ,
"CREATED_USER_ID" NUMBER(10) DEFAULT NULL  NULL ,
"TYPE" VARCHAR2(255 BYTE) DEFAULT NULL  NULL 
)
LOGGING
NOCOMPRESS
NOCACHE

;

-- ----------------------------
-- Records of IDVN_CORE_USER
-- ----------------------------
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER" VALUES ('1', '1', 'Duong Van Bien', 'admin', 'efe8103e655b12d99f8ad9e8923a7983', 'bien.duongvan@yahoo.com', '1', TO_TIMESTAMP(' 2017-11-02 16:49:51', 'YYYY-MM-DD HH24:MI:SS:'), TO_TIMESTAMP(' 2017-11-02 16:49:55', 'YYYY-MM-DD HH24:MI:SS:'), '1', '1', 'TOOL');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER" VALUES ('35', '1', 'Demo', 'demo', 'efe8103e655b12d99f8ad9e8923a7983', 'demo@gmail.com', '1', TO_TIMESTAMP(' 2017-11-02 16:51:57', 'YYYY-MM-DD HH24:MI:SS:'), TO_TIMESTAMP(' 2017-11-02 16:52:01', 'YYYY-MM-DD HH24:MI:SS:'), '1', '1', 'TOOL');

-- ----------------------------
-- Table structure for IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
DROP TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS";
CREATE TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" (
"PID" NUMBER(10) NOT NULL ,
"PERMISSION_NAME" VARCHAR2(100 BYTE) NOT NULL ,
"PERMISSION_TYPE" NUMBER(10) DEFAULT NULL  NULL ,
"CONTROLLER_NAME" VARCHAR2(255 BYTE) DEFAULT NULL  NULL ,
"USERID" NUMBER(10) NOT NULL 
)
LOGGING
NOCOMPRESS
NOCACHE

;

-- ----------------------------
-- Records of IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5032', 'config', '1', 'system', '35');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5033', 'list', '1', 'group', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5034', 'delete', '1', 'group', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5035', 'add', '1', 'group', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5036', 'edit', '1', 'group', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5037', 'activate', '1', 'group', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5038', 'index', '1', 'permission', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5039', 'action', '1', 'permission', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5040', 'config', '1', 'system', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5041', 'list', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5042', 'activate', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5043', 'check', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5044', 'add', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5045', 'edit', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5046', 'delete', '1', 'user', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" VALUES ('5047', 'suggest', '1', 'user', '1');

-- ----------------------------
-- Table structure for IDVN_CORE_USERGROUPS
-- ----------------------------
DROP TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS";
CREATE TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS" (
"GROUP_ID" NUMBER(10) NOT NULL ,
"GROUP_NAME" VARCHAR2(100 BYTE) NOT NULL ,
"IS_ACTIVE" NUMBER(10) DEFAULT '0'  NOT NULL 
)
LOGGING
NOCOMPRESS
NOCACHE

;

-- ----------------------------
-- Records of IDVN_CORE_USERGROUPS
-- ----------------------------
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USERGROUPS" VALUES ('1', 'Root', '1');
INSERT INTO "CARD_CREDIT"."IDVN_CORE_USERGROUPS" VALUES ('2', 'Member', '1');

-- ----------------------------
-- Indexes structure for table IDVN_CORE_ACTION
-- ----------------------------

-- ----------------------------
-- Triggers structure for table IDVN_CORE_ACTION
-- ----------------------------
CREATE OR REPLACE TRIGGER "CARD_CREDIT"."IDVN_CORE_ACTION_SEQ_TR" BEFORE INSERT ON "CARD_CREDIT"."IDVN_CORE_ACTION" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW ENABLE WHEN (NEW.action_id IS NULL)
BEGIN
 SELECT idvn_core_action_seq.NEXTVAL INTO :NEW.action_id FROM DUAL;
END;
-- ----------------------------
-- Checks structure for table IDVN_CORE_ACTION
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_ACTION" ADD CHECK ("ACTION_ID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_ACTION" ADD CHECK ("TYPE" IS NOT NULL);

-- ----------------------------
-- Primary Key structure for table IDVN_CORE_ACTION
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_ACTION" ADD PRIMARY KEY ("ACTION_ID");

-- ----------------------------
-- Indexes structure for table IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------

-- ----------------------------
-- Triggers structure for table IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------
CREATE OR REPLACE TRIGGER "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS_SEQ_TR" BEFORE INSERT ON "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW ENABLE WHEN (NEW.pid IS NULL)
BEGIN
 SELECT idvn_core_group_permissions_seq.NEXTVAL INTO :NEW.pid FROM DUAL;
END;
-- ----------------------------
-- Checks structure for table IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" ADD CHECK ("PID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" ADD CHECK ("PERMISSION_NAME" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" ADD CHECK ("GROUP_ID" IS NOT NULL);

-- ----------------------------
-- Primary Key structure for table IDVN_CORE_GROUP_PERMISSIONS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_GROUP_PERMISSIONS" ADD PRIMARY KEY ("PID");

-- ----------------------------
-- Indexes structure for table IDVN_CORE_USER
-- ----------------------------

-- ----------------------------
-- Triggers structure for table IDVN_CORE_USER
-- ----------------------------
CREATE OR REPLACE TRIGGER "CARD_CREDIT"."IDVN_CORE_USER_SEQ_TR" BEFORE INSERT ON "CARD_CREDIT"."IDVN_CORE_USER" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW ENABLE WHEN (NEW.user_id IS NULL)
BEGIN
 SELECT idvn_core_user_seq.NEXTVAL INTO :NEW.user_id FROM DUAL;
END;
-- ----------------------------
-- Uniques structure for table IDVN_CORE_USER
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD UNIQUE ("USER_NAME");

-- ----------------------------
-- Checks structure for table IDVN_CORE_USER
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("USER_ID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("GROUP_ID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("FULL_NAME" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("USER_NAME" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("PASSWORD" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK ("IS_ACTIVE" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD CHECK (user_id > 0);

-- ----------------------------
-- Primary Key structure for table IDVN_CORE_USER
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER" ADD PRIMARY KEY ("USER_ID");

-- ----------------------------
-- Indexes structure for table IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
CREATE INDEX "CARD_CREDIT"."CONTROL_NAME"
ON "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ("CONTROLLER_NAME" ASC)
LOGGING
VISIBLE;
CREATE INDEX "CARD_CREDIT"."PR_NAME"
ON "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ("PERMISSION_NAME" ASC)
LOGGING
VISIBLE;
CREATE INDEX "CARD_CREDIT"."USER_ID"
ON "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ("USERID" ASC)
LOGGING
VISIBLE;

-- ----------------------------
-- Triggers structure for table IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
CREATE OR REPLACE TRIGGER "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS_SEQ_TR" BEFORE INSERT ON "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW ENABLE WHEN (NEW.pid IS NULL)
BEGIN
 SELECT idvn_core_user_permissions_seq.NEXTVAL INTO :NEW.pid FROM DUAL;
END;
-- ----------------------------
-- Checks structure for table IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ADD CHECK ("PID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ADD CHECK ("PERMISSION_NAME" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ADD CHECK ("USERID" IS NOT NULL);

-- ----------------------------
-- Primary Key structure for table IDVN_CORE_USER_PERMISSIONS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USER_PERMISSIONS" ADD PRIMARY KEY ("PID");

-- ----------------------------
-- Indexes structure for table IDVN_CORE_USERGROUPS
-- ----------------------------

-- ----------------------------
-- Triggers structure for table IDVN_CORE_USERGROUPS
-- ----------------------------
CREATE OR REPLACE TRIGGER "CARD_CREDIT"."IDVN_CORE_USERGROUPS_SEQ_TR" BEFORE INSERT ON "CARD_CREDIT"."IDVN_CORE_USERGROUPS" REFERENCING OLD AS "OLD" NEW AS "NEW" FOR EACH ROW ENABLE WHEN (NEW.group_id IS NULL)
BEGIN
 SELECT idvn_core_usergroups_seq.NEXTVAL INTO :NEW.group_id FROM DUAL;
END;
-- ----------------------------
-- Checks structure for table IDVN_CORE_USERGROUPS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS" ADD CHECK ("GROUP_ID" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS" ADD CHECK ("GROUP_NAME" IS NOT NULL);
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS" ADD CHECK ("IS_ACTIVE" IS NOT NULL);

-- ----------------------------
-- Primary Key structure for table IDVN_CORE_USERGROUPS
-- ----------------------------
ALTER TABLE "CARD_CREDIT"."IDVN_CORE_USERGROUPS" ADD PRIMARY KEY ("GROUP_ID");
