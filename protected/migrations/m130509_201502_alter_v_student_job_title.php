<?php
/**
 * Added two additional columns (college_id, and program_id) to v_student_job_title to serve employer resume features better.
 * @author Wenbin
 *
 */
class m130509_201502_alter_v_student_job_title extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_student_job_title')->execute();
		$this->getDbConnection()->createCommand('CREATE VIEW  v_student_job_title AS
				SELECT
				stu_job_id,
				student_job_title.user_id AS student_id,
				user.username,
				user.first_name,
				user.last_name,
				student.college_id,
				student.program_id,
				student_job_title.job_title_id,
				job_title_name,
				student_job_title.job_type_id,
				job_type_name,
				job_cat.job_cat_id,
				job_cat_name,
				resume_file,
				skills,
				expiry_date,
				student_job_title.employer_id,
				company_name,
				is_hired,
				is_current_hired,
				date_hired,
				student_job_title.date_created,
				student_job_title.date_updated
				FROM tbl_student_job_title student_job_title
				LEFT OUTER JOIN tbl_employer employer ON employer.user_id = student_job_title.employer_id
				INNER JOIN tbl_job_title job_title ON student_job_title.job_title_id = job_title.job_title_id
				INNER JOIN tbl_job_type job_type ON student_job_title.job_type_id = job_type.job_type_id
				INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
				INNER JOIN tbl_student student ON student.user_id = student_job_title.user_id
				INNER JOIN tbl_user user ON user.user_id = student.user_id;')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_student_job_title')->execute();
		$this->getDbConnection()->createCommand('CREATE VIEW v_student_job_title AS
				SELECT
				stu_job_id,
				student_job_title.user_id AS student_id,
				user.username,
				user.first_name,
				user.last_name,
				student_job_title.job_title_id,
				job_title_name,
				student_job_title.job_type_id,
				job_type_name,
				job_cat.job_cat_id,
				job_cat_name,
				resume_file,
				skills,
				expiry_date,
				student_job_title.employer_id,
				company_name,
				is_hired,
				is_current_hired,
				date_hired,
				student_job_title.date_created,
				student_job_title.date_updated
				FROM tbl_student_job_title student_job_title
				LEFT OUTER JOIN tbl_employer employer ON employer.user_id = student_job_title.employer_id
				INNER JOIN tbl_job_title job_title ON student_job_title.job_title_id = job_title.job_title_id
				INNER JOIN tbl_job_type job_type ON student_job_title.job_type_id = job_type.job_type_id
				INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
				INNER JOIN tbl_student student ON student.user_id = student_job_title.user_id
				INNER JOIN tbl_user user ON user.user_id = student.user_id;')->execute();
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