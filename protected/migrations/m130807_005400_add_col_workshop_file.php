<?php

class m130807_005400_add_col_workshop_file extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` ADD `workshop_file` VARCHAR( 100 ) NULL AFTER `website`;")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop` DROP `workshop_file`;")->execute();
    }
}