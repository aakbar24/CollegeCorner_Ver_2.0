<?php

class m140311_203505_alter_job_type_table extends CDbMigration
{
	public function up()
	{
	 $transaction=$this->dbConnection->beginTransaction();
        try {

            $this->update('{{job_type}}', array('job_type_name'=>'Apprenticeship'),'job_type_id=3');
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
		echo "m140311_203505_alter_job_type_table does not support migration down.\n";
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