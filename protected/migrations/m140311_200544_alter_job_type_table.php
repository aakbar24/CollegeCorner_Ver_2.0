<?php

class m140311_200544_alter_job_type_table extends CDbMigration
{
	public function up()
	{
        $transaction=$this->dbConnection->beginTransaction();
        try {

            $this->insert('{{job_type}}', array('job_type_name'=>'Grad'),'job_type_id=4');
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
		echo "m140311_200544_alter_job_type_table does not support migration down.\n";
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