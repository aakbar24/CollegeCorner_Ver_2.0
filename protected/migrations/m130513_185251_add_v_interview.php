<?php

class m130513_185251_add_v_interview extends CDbMigration
{
	public function up()
	{
		$this->addColumn('tbl_interview_student_job_title', 'active', "tinyint(1) default 1");
		
		$this->getDbConnection()->createCommand('CREATE VIEW  v_interview AS
				SELECT
				interview_student_job_title.stu_job_id,
				username,
				student.user_id as student_id,
				first_name,
				last_name,
				college_id,
				program_id,
				job_cat.job_cat_id,
				job_cat_name,
				s.job_title_id,
				job_title_name,
				s.resume_file,
				is_hired,
				is_current_hired,
				s.skills,
				expiry_date,
				interview_date,
				interview_student_job_title.employer_id,
				company_name,
				interview_student_job_title.active		
				FROM tbl_interview_student_job_title interview_student_job_title
				INNER JOIN tbl_student_job_title s ON interview_student_job_title.stu_job_id = s.stu_job_id
				INNER JOIN tbl_job_title job_title ON job_title.job_title_id = s.job_title_id
				INNER JOIN tbl_student student ON student.user_id = s.user_id

				INNER JOIN tbl_user user ON user.user_id = student.user_id
				INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
				INNER JOIN tbl_employer employer ON employer.user_id = interview_student_job_title.employer_id')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_interview')->execute();
		$this->dropColumn('tbl_interview_student_job_title', 'active');
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