--------------------------------------------------------
--  File created - Sunday-December-17-2017   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table IDVN_REPORT_BAD_DEBT
--------------------------------------------------------


CREATE TABLE "IDVN_REPORT_BAD_DEBT"
   (	"CARD_AMOUNT" NUdddddMBER(12,0),
   "DATES" VARCHAR2(255 BYTE) DEFAULT NULL,
	"AMOUNT" NUMBER(12,0) DEFAULT NULL,
	"REPORT_TIME" TIMESTAMP (0) DEFAULT NULL
   ) SEGMENT CREATION IMMEDIATE
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;