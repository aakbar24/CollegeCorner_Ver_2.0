<?php

class m130731_142653_add_tbl_workshop_planned extends CDbMigration
{
    public function up()
    {
        $this->getDbConnection()->createCommand("CREATE TABLE IF NOT EXISTS `tbl_workshop_planned` (
  `post_item_id` int(11) NOT NULL,
  PRIMARY KEY (`post_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_workshop_planned`
  ADD CONSTRAINT `tbl_workshop_planned_ibfk_1` FOREIGN KEY (`post_item_id`) REFERENCES `tbl_post_item` (`post_item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

  ALTER TABLE `tbl_post_type` CHANGE `post_type_name` `post_type_name` VARCHAR( 24 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

  INSERT INTO `collegecornerstone`.`tbl_post_type` (
`post_type_id` ,
`post_type_name`
)
VALUES (
'8', 'Planned Workshop'
);

")->execute();
    }

    public function down()
    {
        $this->getDbConnection()->createCommand('DROP TABLE IF EXISTS `tbl_workshop_planned`;

        ALTER TABLE `tbl_post_type` CHANGE `post_type_name` `post_type_name` VARCHAR( 15 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

        DELETE FROM `collegecornerstone`.`tbl_post_type` WHERE `tbl_post_type`.`post_type_id` =8;

        ')->execute();
    }

}