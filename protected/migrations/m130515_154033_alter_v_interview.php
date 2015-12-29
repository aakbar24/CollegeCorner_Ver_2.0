<?php
/**
 * See m130515_153438_alter_v_favorite.php
 * @author Wenbin
 *
 */
class m130515_154033_alter_v_interview extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_interview')->execute();
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
				s.is_hired,
				s.is_current_hired,
				s.skills,
				s.expiry_date,
				interview_date,
				interview_student_job_title.employer_id,
				company_name,
				interview_student_job_title.active,
				(CASE WHEN st.user_id IS NULL THEN 0 else 1 END) AS is_student_hired
				FROM tbl_interview_student_job_title interview_student_job_title
				INNER JOIN tbl_student_job_title s ON interview_student_job_title.stu_job_id = s.stu_job_id
				INNER JOIN tbl_job_title job_title ON job_title.job_title_id = s.job_title_id
				INNER JOIN tbl_student student ON student.user_id = s.user_id
				INNER JOIN tbl_user user ON user.user_id = student.user_id
				INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
				INNER JOIN tbl_employer employer ON employer.user_id = interview_student_job_title.employer_id
				LEFT OUTER JOIN tbl_student_job_title st on st.is_current_hired="1" and  s.user_id=st.user_id
				')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_interview')->execute();
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