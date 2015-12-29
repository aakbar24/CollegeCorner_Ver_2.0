<?php

class m140428_183217_add_job_cat extends CDbMigration
{
	public function up()
	{
		
		$transaction=$this->dbConnection->beginTransaction();
		
		try {            $this->insert('{{job_cat}}', array('job_cat_name'=>'Software Development')); //id 1
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Databases')); //id 2
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Networking')); //id 3
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Client Services')); //id 4
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Systems Analysis')); //id 5
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Computer Repair')); //id 6
            $this->insert('{{job_cat}}', array('job_cat_name'=>'IT Sales')); //id 7
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Software Testing & QA')); //id 8
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
		echo "m140428_183217_add_job_cat does not support migration down.\n";
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