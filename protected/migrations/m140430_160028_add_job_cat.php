<?php

class m140430_160028_add_job_cat extends CDbMigration
{
	public function up()
	{
		
		$transaction=$this->dbConnection->beginTransaction();
		
		try {             
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Big Data/SQL'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Web Development'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'ERPs'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Customer Relations Managment(CRM)'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Business Intelligence(BI)'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Business Analytics'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Business Analyst'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'IT project Managment'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Share Point'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Mobile Applications'));
            $this->insert('{{job_cat}}', array('job_cat_name'=>'Security'));

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
		echo "m140430_160028_add_job_cat does not support migration down.\n";
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