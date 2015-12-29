<?php

class m130504_130903_add_views extends CDbMigration
{
	public function up()
	{
		$db=$this->getDbConnection();
		$transaction=$db->beginTransaction();
		try {
			//add the student view
			$this->getDbConnection()->createCommand('CREATE VIEW v_student AS
					SELECT
					user.user_id,
					username,
					email,
					first_name,
					last_name,
					profile_image,
					user_group_name,
					membership_level_name,
					college_name,
					program_name,
					education_level_name,
					program_code,
					major_name,
					enrollment_date,
					about_me,
					is_notify,
					is_active,
					date_created,
					date_updated
					FROM tbl_user user
					INNER JOIN tbl_student student ON user.user_id = student.user_id
					INNER JOIN tbl_user_group user_group ON user.user_group_id = user_group.user_group_id
					INNER JOIN tbl_membership_level membership_level ON user.membership_level_id = membership_level.membership_level_id
					INNER JOIN tbl_college college ON student.college_id = college.college_id
					INNER JOIN tbl_program program ON student.program_id = program.program_id
					INNER JOIN tbl_education_level education_level ON student.education_level_id = education_level.education_level_id;
			')->execute();
			$transaction->commit();
		} catch (Exception $e) {
			echo "Exception: ".$e->getMessage()."\n";
			$transaction->rollback();
			return false;
		}

	}

	public function down()
	{
		echo "m130504_130903_add_views does not support migration down.\n";
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