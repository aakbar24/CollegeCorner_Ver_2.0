<?php

class m140428_173920_delete_accounting_job_cat extends CDbMigration
{
	public function up()
	{
		
		$transaction=$this->dbConnection->beginTransaction();
		
		try {
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Software Testing & QA')); //id 21
			$transaction->commit();
		}
		catch(Exception $e)
		{
			echo "Exception: ".$e->getMessage()."\n";
			$transaction->rollback();
			return false;
		}
		
		//return false;
	}

	public function down()
	{
		echo "m140428_173920_delete_accounting_job_ca does not support migration down.\n";
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