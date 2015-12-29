<?php

class m130529_154208_add_tbl_student_event extends CDbMigration
{
	public function up()
	{
		$sql="
		CREATE TABLE IF NOT EXISTS `tbl_student_event` (
		`user_id` int(11) NOT NULL,
		`post_item_id` int(11) NOT NULL,
		`is_history` tinyint(1) NOT NULL DEFAULT 0,
		PRIMARY KEY (`user_id`,`post_item_id`),
		FOREIGN KEY (`user_id`) REFERENCES `tbl_student` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  		FOREIGN KEY (`post_item_id`) REFERENCES `tbl_event` (`post_item_id`) ON DELETE NO ACTION ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		";
		
		$this->dbConnection->createCommand($sql)->execute();
		
		$this->addColumn('tbl_event', 'college_id', 'INT');
		$this->addColumn('tbl_post_item', 'excerpt', 'VARCHAR(500) NOT NULL DEFAULT ""');
		$this->addForeignKey('FK_EVENT_COLLEGE_ID', 'tbl_event', 'college_id', 'tbl_college', 'college_id','NO ACTION','CASCADE');
	}

	public function down()
	{
		$this->dropTable('tbl_student_event');
		$this->dropForeignKey('FK_EVENT_COLLEGE_ID', 'tbl_event');
		$this->dropColumn('tbl_event', 'college_id');
		$this->dropColumn('tbl_post_item', 'excerpt');
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