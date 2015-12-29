<?php

class m130601_174557_alter_college_details extends CDbMigration
{
	public function up()
	{
		$this->addColumn('tbl_college_details', 'event_background_color', 'varchar(10) NOT NULL default "#000000"');
		$this->addColumn('tbl_college_details', 'event_text_color', 'varchar(10) NOT NULL default "#ffffff"');
	}

	public function down()
	{
		$this->dropColumn('tbl_college_details', 'event_background_color');
		$this->dropColumn('tbl_college_details', 'event_text_color');
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