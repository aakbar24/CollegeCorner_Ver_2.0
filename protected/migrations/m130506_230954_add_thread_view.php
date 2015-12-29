<?php

class m130506_230954_add_thread_view extends CDbMigration
{
	public function up()
	{
            $db=$this->getDbConnection();
//		$transaction=$db->beginTransaction();
//		try {
			//add the student_job_title view
//			$this->getDbConnection()->createCommand('CREATE VIEW v_thread AS
//SELECT 
//	tbl_post_item.post_item_id AS thread_id, 
//	title, 
//	description,
//	attachment,
//	program_code,
//	tbl_thread.college_id,
//	college_name,
//	tbl_thread.program_id,
//	program_name,
//	tbl_thread.semester_id,
//	semester_name,
//	tbl_post_item.user_id, 
//	username, 
//	first_name, 
//	last_name, 
//	email, 
//	profile_image,
//    tbl_user.date_created AS register_date,
//	tbl_post_item.is_active,
//	tbl_post_item.date_created, 
//	tbl_post_item.date_updated
//FROM tbl_post_item
//INNER JOIN tbl_thread ON tbl_post_item.post_item_id = tbl_thread.post_item_id
//INNER JOIN tbl_user ON tbl_post_item.user_id = tbl_user.user_id
//INNER JOIN tbl_college ON tbl_thread.college_id = tbl_college.college_id
//INNER JOIN tbl_program ON tbl_thread.program_id = tbl_program.program_id
//INNER JOIN tbl_semester ON tbl_thread.semester_id = tbl_semester.semester_id;')->execute();
//
//		} catch (Exception $e) {
//			echo "Exception: ".$e->getMessage()."\n";
//			$transaction->rollback();
//			return false;
//		}
            
            $this->getDbConnection()->createCommand('CREATE VIEW v_thread AS
SELECT 
	tbl_post_item.post_item_id AS thread_id, 
	title, 
	description,
	attachment,
	program_code,
	tbl_thread.college_id,
	college_name,
	tbl_thread.program_id,
	program_name,
	tbl_thread.semester_id,
	semester_name,
	tbl_post_item.user_id, 
	username, 
	first_name, 
	last_name, 
	email, 
	profile_image,
    tbl_user.date_created AS register_date,
	tbl_post_item.is_active,
	tbl_post_item.date_created, 
	tbl_post_item.date_updated
FROM tbl_post_item
INNER JOIN tbl_thread ON tbl_post_item.post_item_id = tbl_thread.post_item_id
INNER JOIN tbl_user ON tbl_post_item.user_id = tbl_user.user_id
INNER JOIN tbl_college ON tbl_thread.college_id = tbl_college.college_id
INNER JOIN tbl_program ON tbl_thread.program_id = tbl_program.program_id
INNER JOIN tbl_semester ON tbl_thread.semester_id = tbl_semester.semester_id;')->execute();
	}

	public function down()
	{
            $this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_thread;')->execute();
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