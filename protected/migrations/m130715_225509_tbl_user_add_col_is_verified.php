<?php

class m130715_225509_tbl_user_add_col_is_verified extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_user` ADD `is_verified` CHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1' AFTER `is_active`; ")->execute();
	}

	public function down()
	{
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_user` DROP `is_verified`;")->execute();
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