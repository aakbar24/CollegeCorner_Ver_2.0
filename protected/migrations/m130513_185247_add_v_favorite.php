<?php

class m130513_185247_add_v_favorite extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand('CREATE VIEW  v_favorite AS
				SELECT 
				fav.stu_job_id, 
				username, 
				s.user_id as student_id,
				first_name, 
				last_name, 
				college_id,
				program_id,
				job_cat.job_cat_id, 
				job_cat_name, 
				s.job_title_id, 
				job_title_name, 
				s.resume_file,
				s.skills,
				fav.employer_id,
			    company_name,
				(CASE WHEN expiry_date<NOW() THEN 1 else 0 END) AS expired 
			FROM tbl_favorite_student_job_title fav 
			INNER JOIN tbl_student_job_title s ON fav.stu_job_id = s.stu_job_id 
			INNER JOIN tbl_job_title job_title ON job_title.job_title_id = s.job_title_id
			INNER JOIN tbl_student student ON student.user_id = s.user_id
			INNER JOIN tbl_user user ON user.user_id = student.user_id
			INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
			INNER JOIN tbl_employer employer ON employer.user_id = fav.employer_id;')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_favorite')->execute();
		
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