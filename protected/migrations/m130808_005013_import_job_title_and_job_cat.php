<?php

class m130808_005013_import_job_title_and_job_cat extends CDbMigration
{
	public function up()
	{
		
		$transaction=$this->dbConnection->beginTransaction();
		
		try {
			$this->addColumn('{{job_cat}}', 'is_active', 'tinyint default 1');
			$this->addColumn('{{job_title}}', 'is_active', 'tinyint default 1');
			
			$this->update('{{job_cat}}', array('job_cat_name'=>'System & Networking'),'job_cat_id=10');
			$this->update('{{job_cat}}', array('job_cat_name'=>'Accounting & Financial'),'job_cat_id=1');
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Community Services')); //id 15
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Art & Communication')); //id 16
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Food Services')); //id 17
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Protective Services')); //id 18
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Personal Care & Beauty')); //id 19
			$this->insert('{{job_cat}}', array('job_cat_name'=>'Installation & Maintenance')); //id 20
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
		echo "m130808_005013_import_job_title_and_job_cat does not support migration down.\n";
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