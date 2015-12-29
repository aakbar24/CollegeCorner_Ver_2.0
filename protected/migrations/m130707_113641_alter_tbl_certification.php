<?php

class m130707_113641_alter_tbl_certification extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{certification_cat}}', 'is_active', 'tinyint default 1');
		$this->addColumn('{{certification}}', 'provider_id', 'int default null');
		$this->addForeignKey('FK_CERTIFICATION_PROVIDER', '{{certification}}', 'provider_id', '{{employer}}', 'user_id');
	}

	public function down()
	{
		$this->dropForeignKey('FK_CERTIFICATION_PROVIDER', '{{certification}}');
		$this->dropColumn('{{certification}}', 'provider_id');
		$this->dropColumn('{{certification_cat}}', 'is_active');
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