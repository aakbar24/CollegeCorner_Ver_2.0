<?php

class m130803_230314_modify_tbl_workshop_allow_nulls extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` CHANGE `address` `address` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `city` `city` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `province` `province` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `postal_code` `postal_code` CHAR( 7 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `phone` `phone` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE `start_date` `start_date` DATE NULL DEFAULT NULL ,
CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL ,
CHANGE `start_time` `start_time` TIME NULL DEFAULT NULL ,
CHANGE `end_time` `end_time` TIME NULL DEFAULT NULL;")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` CHANGE `address` `address` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `city` `city` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `province` `province` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `postal_code` `postal_code` CHAR( 7 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `phone` `phone` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
CHANGE `start_date` `start_date` DATE NOT NULL ,
CHANGE `end_date` `end_date` DATE NOT NULL ,
CHANGE `start_time` `start_time` TIME NOT NULL ,
CHANGE `end_time` `end_time` TIME NOT NULL;")->execute();
    }
}