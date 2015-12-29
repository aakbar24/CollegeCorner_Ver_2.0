<?php
/**
 * Added additional columns to inidicate if a student of favorite job title is currently hired.
 * 
 * E.g. 
 * 
 * Employer A favorites Student B with Job titles 1,2,3;
 * 
 * Later on Student B with Job title 1 is hired by either Employer A or other employers;
 * 
 * Employer A should notice if Student B is already hired. 
 * 
 * @author Wenbin
 *
 */
class m130515_153438_alter_v_favorite extends CDbMigration
{
	public function up()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_favorite')->execute();
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
				s.is_hired,
				s.is_current_hired,
				(CASE WHEN s.expiry_date<NOW() THEN 1 else 0 END) AS expired,
				(CASE WHEN st.user_id IS NULL THEN 0 else 1 END) AS is_student_hired
				FROM tbl_favorite_student_job_title fav
				INNER JOIN tbl_student_job_title s ON fav.stu_job_id = s.stu_job_id
				INNER JOIN tbl_job_title job_title ON job_title.job_title_id = s.job_title_id
				INNER JOIN tbl_student student ON student.user_id = s.user_id
				INNER JOIN tbl_user user ON user.user_id = student.user_id
				INNER JOIN tbl_job_cat job_cat ON job_cat.job_cat_id = job_title.job_cat_id
				INNER JOIN tbl_employer employer ON employer.user_id = fav.employer_id
				LEFT OUTER JOIN tbl_student_job_title st on st.is_current_hired="1" and  s.user_id=st.user_id
				')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_favorite')->execute();
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