<?php

class m130605_141737_alter_v_thread_add_user_group extends CDbMigration
{
	public function up()
	{  
               $this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_thread;')->execute();
            
            
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
    tbl_user.user_group_id,
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