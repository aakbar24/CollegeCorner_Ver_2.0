<?php

class m130627_211236_add_tbl_slide extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("CREATE TABLE IF NOT EXISTS `tbl_slide` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_image` varchar(100) DEFAULT NULL,
  `label` varchar(500) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand('DROP TABLE IF EXISTS `tbl_slide`;')->execute();
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}