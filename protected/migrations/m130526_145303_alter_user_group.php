<?php

class m130526_145303_alter_user_group extends CDbMigration
{
	public function up()
	{
		$db=$this->dbConnection;
		
		$tr=$db->beginTransaction();
		
		try {
			$this->addColumn('tbl_user_group', 'parent_group_id', 'int');
			$this->insert('tbl_user_group', array('user_group_name'=>'User'));
			$this->update('tbl_user_group', array('parent_group_id'=>5),'user_group_id NOT IN (5, 4, 3)');
			$this->insert('tbl_user_group', array('user_group_name'=>'Super Admin','parent_group_id'=>3));
			//$this->update('tbl_user_group', array('parent_group_id'=>6),'user_group_id=3');
			$this->addForeignKey('FK_USER_GROUP_PARENT_GROUP_ID', 'tbl_user_group', 'parent_group_id', 'tbl_user_group', 'user_group_id');
			$tr->commit();
		} catch (Exception $e) {
			$tr->rollback();
			echo "Exception: ".$e->getMessage()."\n";
			return false;
		}
		
	}

	public function down()
	{
		echo "m130526_145303_alter_user_group does not support migration down.\n";
		return false;
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