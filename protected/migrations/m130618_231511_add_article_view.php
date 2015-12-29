<?php

class m130618_231511_add_article_view extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand('CREATE VIEW v_article AS
SELECT 
	tbl_post_item.post_item_id AS article_id, 
	article_image,
	title, 
	description, 
	source, 
	tbl_post_item.user_id, 
	username, 
	first_name, 
	last_name, 
	email, 
	profile_image, 
        tbl_post_item.post_type_id,
	tbl_post_item.is_active,
	tbl_post_item.date_created, 
	tbl_post_item.date_updated
FROM tbl_post_item
INNER JOIN tbl_article ON tbl_post_item.post_item_id = tbl_article.post_item_id
INNER JOIN tbl_user ON tbl_post_item.user_id = tbl_user.user_id;')->execute();
	}

	public function down()
	{
		$this->getDbConnection()->createCommand('DROP VIEW IF EXISTS v_article;')->execute();
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