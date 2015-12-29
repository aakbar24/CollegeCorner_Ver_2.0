<?php

class m130608_192820_alter_workshop_tables extends CDbMigration
{
	public function up()
	{
		$this->addColumn('tbl_workshop_cat', 'is_active', 'tinyint(1) DEFAULT 1');
		$this->addColumn('tbl_workshop_facilitator', 'is_active', 'tinyint(1) DEFAULT 1');
	}

	public function down()
	{
		$this->dropColumn('tbl_workshop_cat', 'is_active');
		$this->dropColumn('tbl_workshop_facilitator', 'is_active');
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