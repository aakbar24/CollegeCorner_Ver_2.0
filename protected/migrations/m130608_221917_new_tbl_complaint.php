<?php

class m130608_221917_new_tbl_complaint extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand('CREATE TABLE IF NOT EXISTS `tbl_complaint` (
  `complaint_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_item_id` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`complaint_id`),
  KEY `post_item_id` (`post_item_id`),
  KEY `user_id` (`user_id`),
  KEY `reply_id` (`reply_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;')->execute();
            
            $this->getDbConnection()->createCommand('ALTER TABLE `tbl_complaint`
  ADD CONSTRAINT `tbl_complaint_ibfk_3` FOREIGN KEY (`reply_id`) REFERENCES `tbl_reply` (`reply_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_complaint_ibfk_1` FOREIGN KEY (`post_item_id`) REFERENCES `tbl_post_item` (`post_item_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_complaint_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();
	}

	public function down()
	{
		   $this->getDbConnection()->createCommand('DROP TABLE IF EXISTS `tbl_complaint`;')->execute();
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