<?php

class m130721_013921_add_tbl_user_verification extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("CREATE TABLE IF NOT EXISTS `tbl_user_verification` (
  `user_id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_user_verification`
  ADD CONSTRAINT `tbl_user_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand('DROP TABLE IF EXISTS `tbl_user_verification`;')->execute();
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