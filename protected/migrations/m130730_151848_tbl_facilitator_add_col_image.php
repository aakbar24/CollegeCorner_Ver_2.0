<?php

class m130730_151848_tbl_facilitator_add_col_image extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop_facilitator` ADD `image` VARCHAR( 30 ) NULL AFTER `biography`; ")->execute();
	}

	public function down()
	{
        $this->getDbConnection()->createCommand("ALTER TABLE `tbl_workshop_facilitator` DROP `image`;")->execute();
	}

}