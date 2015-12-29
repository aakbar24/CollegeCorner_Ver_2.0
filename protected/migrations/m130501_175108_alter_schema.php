<?php

class m130501_175108_alter_schema extends CDbMigration
{
	public function up()
	{
		$transaction=$this->getDbConnection()->beginTransaction();			
		try
		{
			$this->_alter_student_job_title();
			$this->_alter_interview_student_job_title();
			$this->_alter_news();
			$this->_alter_article();
			$this->_alter_event();
			$this->_alter_certification();
			$this->_alter_thread();
			$this->_alter_workshop();
			$this->_alter_student_workshop();
			
			$transaction->commit();
		}
		catch(Exception $e)
		{
			echo "Exception: ".$e->getMessage()."\n";
			$transaction->rollback();
			return false;
		}
	}

	public function down()
	{
		echo "m130501_175108_alter_schema does not support migration down.\n";
		return false;
	}
	
	private function _alter_student_job_title(){
		$this->addColumn('tbl_student_job_title', 'is_current_hired', "char(1) NOT NULL DEFAULT '0'");
		$this->addColumn('tbl_student_job_title', 'date_hired', "date");
		$this->addColumn('tbl_student_job_title', 'date_updated', "timestamp NULL DEFAULT NULL");
	}
	
	private function _alter_interview_student_job_title(){
		$this->addColumn('tbl_interview_student_job_title', 'interview_date', "datetime NOT NULL");
	}
	
	private function _alter_news(){
		$this->addColumn('tbl_news', 'news_image', "varchar(100)");
	}
	
	private function _alter_article(){
		$this->addColumn('tbl_article', 'article_image', "varchar(100)");
	}
	
	private function _alter_event(){
		$this->addColumn('tbl_event', 'event_image', "varchar(100)");
	}
	
	private function _alter_certification(){
		$this->addColumn('tbl_certification', 'cert_image', "varchar(100)");
		$this->alterColumn('tbl_certification', 'provider', "varchar(100) NOT NULL");
	}
	
	private function _alter_thread(){
		$this->addColumn('tbl_thread', 'attachment', "varchar(100)");
	}
	
	private function _alter_workshop(){
		$this->alterColumn('tbl_workshop', 'workshop_facilitator_id', "int");
		$this->addColumn('tbl_workshop', 'workshop_image', "varchar(100)");
	}

	private function _alter_student_workshop(){
		$this->addColumn('tbl_student_workshop', 'is_history', "char(1) NOT NULL DEFAULT '0'");
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