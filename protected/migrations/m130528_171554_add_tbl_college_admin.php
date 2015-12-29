<?php

class m130528_171554_add_tbl_college_admin extends CDbMigration
{
	public function up()
	{
		$this->insert('tbl_user_group', array('user_group_name'=>'College Admin','parent_group_id'=>4));
		
		$sql="CREATE TABLE IF NOT EXISTS `tbl_college_admin` (
		`user_id` int(11) NOT NULL,
		`college_id` int(11) NOT NULL,
		`department` varchar(50),
		PRIMARY KEY (`user_id`),
		FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
		FOREIGN KEY (`college_id`) REFERENCES `tbl_college` (`college_id`) ON DELETE NO ACTION ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		$this->dbConnection->createCommand($sql)->execute();
	}

	public function down()
	{
		$this->dropTable('tbl_college_admin');
		$this->delete('tbl_user_group', 'user_group_name = "College Admin" ');
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