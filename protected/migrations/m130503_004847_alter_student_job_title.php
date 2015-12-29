<?php
/**
 * Add auto increment primary key to student job title. This change will allow the table to keep track of the hiring history.
 * Consider this scenario, student id A applied job_title 1 and was hired 4 months ago, and now he wants to apply the same job_title 1 again.
 * The current table structure with the composite key (student_id, job_title_id) would not be able to keep track of the history and neither to re-apply to the same job again.
 * To resolve this issue, I added the auto increment primary key and removed the composite key.
 * @author Wenbin
 *
 */
class m130503_004847_alter_student_job_title extends CDbMigration
{
	public function up()
	{
		$db=$this->getDbConnection();
		$transaction=$db->beginTransaction();

		try {
			$tbl='tbl_student_job_title';

			//cache the data from the current student job title
			$data=$db->createCommand()->select()->from($tbl)->queryAll(true);

			//create a new table with the new auto column
			$this->createTable($tbl.'_new', array('stu_job_id'=>'int not null primary key auto_increment',
					'user_id'=>'int NOT NULL',
					'job_title_id'=>'int NOT NULL',
					'job_type_id'=>'int NOT NULL',
					'resume_file'=>'varchar(100) NOT NULL',
					'skills'=>'varchar(200) NOT NULL',
					'expiry_date'=>'date NOT NULL',
					'employer_id'=>'int',
					'is_hired'=>"char(1) NOT NULL DEFAULT '0'",
					'is_current_hired'=>"char(1) NOT NULL DEFAULT '0'",
					'date_hired'=>'date',
					'date_created'=>'datetime NOT NULL',
					'date_updated'=>'timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
					'FOREIGN KEY (user_id) REFERENCES tbl_student (user_id) ON DELETE NO ACTION ON UPDATE CASCADE',
					'FOREIGN KEY (employer_id) REFERENCES tbl_employer (user_id) ON DELETE NO ACTION ON UPDATE CASCADE',
					'FOREIGN KEY (job_type_id) REFERENCES tbl_job_type (job_type_id) ON DELETE NO ACTION ON UPDATE CASCADE',
					'FOREIGN KEY (job_title_id) REFERENCES tbl_job_title (job_title_id) ON DELETE NO ACTION ON UPDATE CASCADE'));

			//insert back the data to the new table
			foreach ($data as $row) {
				$this->insert($tbl.'_new', $row);
			}

			//drop the dependent tables
			$this->dropTable('tbl_interview_student_job_title');
			$this->dropTable('tbl_favorite_student_job_title');

			//drop the target table
			$this->dropTable($tbl);
			//rename the new table with the target name
			$this->renameTable($tbl.'_new', $tbl);
				
			//re-create the dependent tables with the updated fk column
			$this->createTable('tbl_interview_student_job_title', array('stu_job_id'=>'int NOT NULL',
					'employer_id'=>'int NOT NULL',
					'interview_date'=>'datetime NOT NULL',
					'PRIMARY KEY (stu_job_id, employer_id)',
					'FOREIGN KEY (`employer_id`) REFERENCES tbl_employer(user_id) ON DELETE NO ACTION ON UPDATE CASCADE',
					'FOREIGN KEY (stu_job_id) REFERENCES tbl_student_job_title(stu_job_id) ON DELETE NO ACTION ON UPDATE CASCADE'));

			$this->createTable('tbl_favorite_student_job_title', array('stu_job_id'=>'int NOT NULL',
					'employer_id'=>'int NOT NULL',
					'PRIMARY KEY (stu_job_id, employer_id)',
					'FOREIGN KEY (`employer_id`) REFERENCES tbl_employer(user_id) ON DELETE NO ACTION ON UPDATE CASCADE',
					'FOREIGN KEY (stu_job_id) REFERENCES tbl_student_job_title(stu_job_id) ON DELETE NO ACTION ON UPDATE CASCADE'));
				
			$transaction->commit();
		} catch (Exception $e) {
			echo "Exception: ".$e->getMessage()."\n";
			$transaction->rollback();
			return false;
		}
	}

	public function down()
	{
		echo "m130503_004847_alter_student_job_title does not support migration down.\n";
		return true;
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