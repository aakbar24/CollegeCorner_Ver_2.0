<?php

class m130704_200441_add_view_workshop extends CDbMigration
{
	public function up()
	{
        $this->getDbConnection()->createCommand("CREATE VIEW `v_workshop` AS select `tbl_post_item`.`post_item_id` AS `workshop_id`,`tbl_workshop`.`workshop_cat_id` AS `workshop_cat_id`,`tbl_workshop_cat`.`workshop_cat_name` AS `workshop_cat_name`,`tbl_workshop`.`workshop_facilitator_id` AS `facil_id`,`tbl_workshop_facilitator`.`first_name` AS `facil_first_name`,`tbl_workshop_facilitator`.`last_name` AS `facil_last_name`,`tbl_workshop_facilitator`.`biography` AS `facil_bio`,`tbl_workshop`.`workshop_image` AS `workshop_image`,`tbl_post_item`.`title` AS `title`,`tbl_post_item`.`description` AS `description`,`tbl_workshop`.`address` AS `address`,`tbl_workshop`.`city` AS `city`,`tbl_workshop`.`province` AS `province`,`tbl_workshop`.`postal_code` AS `postal_code`,`tbl_country`.`country_name` AS `country_name`,`tbl_workshop`.`phone` AS `phone`,`tbl_workshop`.`ext` AS `ext`,`tbl_workshop`.`start_date` AS `start_date`,`tbl_workshop`.`end_date` AS `end_date`,`tbl_workshop`.`start_time` AS `start_time`,`tbl_workshop`.`end_time` AS `end_time`,`tbl_workshop`.`website` AS `website`,`tbl_workshop`.`is_approved` AS `is_approved`,`tbl_post_item`.`user_id` AS `user_id`,`tbl_user`.`username` AS `username`,`tbl_user`.`first_name` AS `user_first_name`,`tbl_user`.`last_name` AS `user_last_name`,`tbl_user`.`email` AS `email`,`tbl_user`.`profile_image` AS `profile_image`,`tbl_post_item`.`is_active` AS `is_active`,`tbl_post_item`.`date_created` AS `date_created`,`tbl_post_item`.`date_updated` AS `date_updated` from (((((`tbl_post_item` join `tbl_workshop` on((`tbl_post_item`.`post_item_id` = `tbl_workshop`.`post_item_id`))) join `tbl_user` on((`tbl_post_item`.`user_id` = `tbl_user`.`user_id`))) join `tbl_country` on((`tbl_workshop`.`country_id` = `tbl_country`.`country_id`))) join `tbl_workshop_cat` on((`tbl_workshop`.`workshop_cat_id` = `tbl_workshop_cat`.`workshop_cat_id`))) left join `tbl_workshop_facilitator` on((`tbl_workshop`.`workshop_facilitator_id` = `tbl_workshop_facilitator`.`workshop_facilitator_id`)));")->execute();
	}

	public function down()
	{
        $this->getDbConnection()->createCommand('DROP VIEW IF EXISTS `v_workshop`;')->execute();
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