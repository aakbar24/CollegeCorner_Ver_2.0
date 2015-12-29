<?php

class m140428_180535_add_job_cat extends CDbMigration
{
	public function up()
	{
		
		$transaction=$this->dbConnection->beginTransaction();
		
		try {
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Client Services')); //id 22
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Systems Analysis')); //id 23
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Computer Repair')); //id 24
            $this->insert('{{job_cat}}', array('job_cat_name'=>'IT Sales')); //id 25
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
		echo "m140428_180535_add_job_cat does not support migration down.\n";
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