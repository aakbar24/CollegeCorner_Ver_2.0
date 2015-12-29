<?php

class m130610_014105_alter_tbl_complaint_add_date_col extends CDbMigration
{
	public function up()
	{
             $this->getDbConnection()->createCommand('ALTER TABLE `tbl_complaint` ADD `date_created` DATETIME NOT NULL ;')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('ALTER TABLE `tbl_complaint` DROP `date_created`;')->execute();
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