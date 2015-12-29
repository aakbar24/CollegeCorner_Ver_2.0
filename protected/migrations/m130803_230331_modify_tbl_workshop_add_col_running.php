<?php

class m130803_230331_modify_tbl_workshop_add_col_running extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` ADD `is_running` CHAR( 1 ) NOT NULL DEFAULT '0' AFTER `is_approved`;")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` DROP COLUMN `is_running`;")->execute();
    }
}